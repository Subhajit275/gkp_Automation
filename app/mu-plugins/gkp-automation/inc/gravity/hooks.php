<?php
add_action( 'gform_after_submission', 'gkp_handle_build_site_submission', 10, 2 );

function gkp_handle_build_site_submission( $entry, $form ) {

    error_log(json_encode($entry));

	if ( $form['title'] !== 'Build Your Site' ) {
		return;
	}

	global $wpdb;

	$payload = [
		'author_name'      => rgar( $entry, '2' ),
		'email'            => rgar( $entry, '4' ),
		'book_title'       => rgar( $entry, '3' ),
		'socials'          => rgar( $entry, '40' ),
		'meta_title'       => rgar( $entry, '30' ),
		'meta_description' => rgar( $entry, '31' ),
		'template_style'   => rgar( $entry, '5' ),
		'enable_animations' => ! empty( rgar( $entry, '6.1' ) ),
		'sections'         => gkp_parse_sections_from_entry( $entry ),
	];

	$wpdb->insert(
		$wpdb->base_prefix . 'gkp_site_requests',
		[
			'entry_id'        => $entry['id'],
			'template_style'  => $payload['template_style'],
			'enable_animations'=> $payload['enable_animations'],
			'payload'         => wp_json_encode( $payload ),
			'status'          => 'pending',
		]
	);

	if ( ! wp_next_scheduled( 'gkp_process_site_requests' ) ) {
        wp_schedule_single_event( time() + 10, 'gkp_process_site_requests' );
    }
}
