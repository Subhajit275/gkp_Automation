<?php
if (! defined('ABSPATH')) exit;

function gkp_process_next_site_request()
{

	global $wpdb;
	$table = $wpdb->base_prefix . 'gkp_site_requests';

	$request = $wpdb->get_row(
		"SELECT * FROM {$table} WHERE status = 'pending' ORDER BY id ASC LIMIT 1"
	);

	if (! $request) {
		return;
	}

	$wpdb->update(
		$table,
		['status' => 'processing'],
		['id' => $request->id]
	);

	try {

		$payload = json_decode($request->payload, true);

		if (empty($payload) || ! is_array($payload)) {
			throw new Exception('Invalid payload');
		}

		/* -------------------------------------------------
		 * 1. Clone site
		 * ------------------------------------------------- */
		$template_style = $request->template_style ?? 'simple';
		$site_id_response = gkp_clone_site_from_template($payload, $template_style);


		if (is_wp_error($site_id_response)) {
			//error_log('Site clone failed: ' . $site_id_response->get_error_message());

			throw new Exception(
				'Clone failed: ' . $site_id_response->get_error_message()
			);
		}

		$site_id = (int) ($site_id_response ?? 0);
		//error_log('Final site_id (casted): ' . $site_id);
		//error_log('Final site_id type: ' . $site_id);

		if (! get_blog_details($site_id)) {
			throw new Exception(
				'Target site does not exist after cloning. Site ID: ' . $site_id
			);
		}

		switch_to_blog($site_id);

		// $socials = gkp_normalize_socials($payload['socials'] ?? []);
		$socials = $payload['social_links'] ?? [];

		/* -------------------------------------------------
		 * 2. Normalize intake for placeholders
		 * ------------------------------------------------- */
		$intake = [
			'author_name'    => $payload['author']['name'] ?? '',
			'book_title'     => $payload['book']['title'] ?? '',
			'contact_email'  => $payload['author']['email'] ?? '',

			// Expanded social keys
			'social_instagram' => $socials['instagram'] ?? '',
			'social_facebook'  => $socials['facebook'] ?? '',
			'social_twitter'   => $socials['twitter'] ?? '',
			'social_linkedin'  => $socials['linkedin'] ?? '',
			'social_youtube'   => $socials['youtube'] ?? '',
			'social_website'   => $socials['website'] ?? '',



			// Book
			'book_title' => $payload['book']['title'] ?? '',

			// Branding
			'site_title'   => $payload['branding']['site_title'] ?? '',
			'site_tagline' => $payload['branding']['site_tagline'] ?? '',
			'logo'         => $payload['branding']['logo'] ?? '',
			'primary_color'   => $payload['branding']['primary_color'] ?? '',
			'secondary_color' => $payload['branding']['secondary_color'] ?? '',
			'title_font'   => $payload['branding']['title_font'] ?? '',
			'body_font'    => $payload['branding']['body_font'] ?? '',

		];


		update_option('gkp_intake_data', $intake);

		$template = [
			'style'   => $payload['template']['style'] ?? 'minimal',
			'content' => $payload['template']['content'] ?? [],
		];
		update_option('gkp_template_data', $template);

		$branding = [
			'site_title'   => $payload['branding']['site_title'] ?? '',
			'site_tagline' => $payload['branding']['site_tagline'] ?? '',
			'logo'         => $payload['branding']['logo'] ?? '',
			'primary_color'   => $payload['branding']['primary_color'] ?? '',
			'secondary_color' => $payload['branding']['secondary_color'] ?? '',
			'title_font'   => $payload['branding']['title_font'] ?? '',
			'body_font'    => $payload['branding']['body_font'] ?? '',
		];
		update_option('gkp_branding', $branding);

		/* -------------------------------------------------
		 * 3. Replace placeholders (CONTENT)
		 * ------------------------------------------------- */
		if (function_exists('gkp_apply_intake_to_site')) :
			gkp_apply_intake_to_site();
		endif;

		/* -------------------------------------------------
		 * 4. Replace placeholders (MENUS)
		 * ------------------------------------------------- */
		if (function_exists('gkp_replace_placeholders_in_menus')) :
			gkp_replace_placeholders_in_menus($intake);
		endif;

		/* -------------------------------------------------
		 * 5. Apply automation lifecycle (SAFE)
		 * ------------------------------------------------- */
		if (function_exists('gkp_run_automation_lifecycle')) :
			gkp_run_automation_lifecycle();
		endif;

		restore_current_blog();

		/* -------------------------------------------------
		 * 6. Mark completed
		 * ------------------------------------------------- */
		$wpdb->update(
			$table,
			[
				'status'       => 'completed',
				'site_id'      => $site_id ,
				'processed_at' => current_time('mysql'),
			],
			['id' => $request->id]
		);
	} catch (Exception $e) {

		$wpdb->update(
			$table,
			[
				'status' => 'failed',
				'error'  => $e->getMessage(),
			],
			['id' => $request->id]
		);
	}

	// Schedule next job (queue continues)
	wp_schedule_single_event(time() + 30, 'gkp_process_site_requests');
}


