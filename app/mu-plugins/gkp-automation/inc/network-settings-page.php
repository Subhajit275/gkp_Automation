<?php
if (!defined('ABSPATH')) exit;

add_action('admin_enqueue_scripts', function () {
	wp_enqueue_media();
});

function gkp_include_assets()
{
	echo '<script>tailwind={config:{corePlugins:{preflight:false}}}</script>';
	echo '<script src="' . network_site_url('/wp-content/mu-plugins/gkp-automation/inc/assets/tailwindcdn.js') . '"></script>';
	echo '<script src="' . network_site_url('/wp-content/mu-plugins/gkp-automation/inc/assets/form-script.js') . '"></script>';
}
add_action('admin_footer', 'gkp_include_assets');


function gkp_render_network_settings_page()
{
	$settings = get_site_option('gkp_automation_settings', gkp_default_network_settings());
	$tab = $_GET['tab'] ?? 'general';
?>
	<div class="wrap">
		<h1>Gatekeeper Automation</h1>
		<p class="description">Global automation settings applied across the network.</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ($tab === 'general') echo 'nav-tab-active'; ?>"
				href="<?php echo network_admin_url('admin.php?page=gkp-automation&tab=general'); ?>">General</a>
			<a class="nav-tab <?php if ($tab === 'defaults') echo 'nav-tab-active'; ?>"
				href="<?php echo network_admin_url('admin.php?page=gkp-automation&tab=defaults'); ?>">Defaults</a>
		</h2>

		<?php if (isset($_GET['updated'])) : ?>
			<div class="notice notice-success is-dismissible">
				<p>Settings saved successfully.</p>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo network_admin_url('admin-post.php'); ?>">
			<input type="hidden" name="action" value="gkp_clone_form_submit">

			<?php wp_nonce_field('gkp_automation_settings'); ?>

			<?php if ($tab === 'general') : ?>
				<table class="form-table">
					<tr>
						<th>Enable Automation</th>
						<td>
							<label>
								<input type="checkbox" name="enabled" value="1" <?php checked($settings['enabled']); ?>>
								Enable provisioning & automation
							</label>
						</td>
					</tr>
					<tr>
						<th>NS Cloner Integration</th>
						<td>
							<label>
								<input type="checkbox" name="ns_cloner" value="1" <?php checked($settings['ns_cloner']); ?>>
								Enable NS Cloner automation
							</label>
						</td>
					</tr>
					<tr>
						<th>Placeholder Replacement</th>
						<td>
							<label>
								<input type="checkbox" name="placeholders" value="1" <?php checked($settings['placeholders']); ?>>
								Replace intake placeholders after cloning
							</label>
						</td>
					</tr>
					<tr>
						<th>Enable Animations</th>
						<td>
							<label>
								<input type="checkbox" name="enable_animations" value="1" <?php checked($settings['enable_animations']); ?>>
								Enable AOS animations by default
							</label>
						</td>
					</tr>
				</table>
			<?php endif; ?>

			<?php if ($tab === 'defaults') : ?>
				<table class="form-table">
					<tr>
						<th>Default Template Style</th>
						<td>
							<select name="default_template">
								<option value="clean" <?php selected($settings['default_template'], 'clean'); ?>>Clean</option>
								<option value="elegant" <?php selected($settings['default_template'], 'elegant'); ?>>Elegant</option>
								<option value="minimal" <?php selected($settings['default_template'], 'minimal'); ?>>Minimal</option>
							</select>
						</td>
					</tr>
				</table>
			<?php endif; ?>

			<?php submit_button('Save Network Settings'); ?>
		</form>
	</div>
	<?php
}

function gkp_render_network_logs_page()
{
	echo '<div class="wrap"><h1>Automation Logs</h1><p>Logs coming soon.</p></div>';
}

// Clone Form for intake submission
function gkp_render_network_clone_form_page()
{
	if (!current_user_can('manage_network_options')) {
		wp_die('Unauthorized access');
	}

	if (isset($_GET['success'])) { ?>

		<div id="success-toast" class="fixed top-8 left-1/2 -translate-x-1/2 z-50 opacity-0 -translate-y-full transition-all duration-500 ease-out">
			<div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-2xl shadow-2xl border-2 border-green-400 flex items-center gap-4 min-w-[400px]">
				<!-- Success Icon -->
				<div class="flex-shrink-0 w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
					<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
					</svg>
				</div>

				<!-- Message -->
				<div class="flex-1">
					<p class="text-lg font-bold mb-0">Success!</p>
					<p class="text-sm text-green-50 mb-0">Form submitted successfully.</p>
				</div>

				<!-- Close Button -->
				<button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 w-8 h-8 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center transition-all duration-300">
					<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>
		</div>

		<script>
			setTimeout(function() {
				const toast = document.getElementById("success-toast");
				if (toast) {
					toast.classList.remove("opacity-0", "-translate-y-full");
					toast.classList.add("opacity-100", "translate-y-0");
				}
			}, 100);
		</script>
	<?php
	}

	global $wpdb;
	$table = $wpdb->base_prefix . 'gkp_authors';
	$authors = $wpdb->get_results(
		"SELECT * FROM {$table} WHERE status = 'pending' ORDER BY name ASC"
	);
	?>
	<!-- Layout wrapper -->
	<div class="flex flex-col lg:flex-row gap-2 items-start my-5 mr-3">
		<!-- Form FIRST on mobile -->
		<div class="flex-1 min-w-0 order-1 lg:order-2">
			<div id="form-error"
				class="hidden mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
			</div>

			<form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="gkp-clone-form">
				<?php wp_nonce_field('gkp_clone_form_submit'); ?>
				<input type="hidden" name="action" value="gkp_clone_form_submit">
				<!-- rest of form -->
				<?php
				// STEP 1: Author Information & Template Selection
				include 'form-includes/autherdetails.php';

				// STEP 2: Template Content (Simple) ,Template Content (Minimal)
				include 'form-includes/templates/simple.php';
				include 'form-includes/templates/minimal.php';

				// STEP 3: Branding 
				include 'form-includes/branding.php';

				// STEP 4: Review & Submit
				include 'form-includes/final-review.php';
				?>

			</form>
		</div> <!-- end form column -->

		<!-- Progress Bar -->
		<div
			id="progress-container"
			class="
					w-full
					lg:w-64
					order-2 lg:order-1
					sticky lg:top-8
					h-auto lg:h-[calc(100vh-6rem)]
				">
		</div>
	</div>
<?php
}



/// submissions logs
function gkp_render_clone_submissions_page()
{
	
	if (!current_user_can('manage_network_options')) {
		wp_die('Unauthorized access');
	}

	global $wpdb;
	$table = $wpdb->base_prefix . 'gkp_clone_submissions';

	$submissions = $wpdb->get_results(
		"SELECT id, author_name, author_email, book_title, template, status, created_at
         FROM {$table}
         ORDER BY created_at DESC"
	);

	// $table = $wpdb->base_prefix . 'gkp_site_requests';

	// $request = $wpdb->get_row(
	// 	"SELECT * FROM {$table} WHERE status = 'pending' ORDER BY id ASC LIMIT -1"
	// );
	// if(!$request) {
	// 	echo 'No pending requests';
	// }
	// // print_r($request);
	// $template_map = [
	// 	'simple'  => 12,
	// 	'clean'   => 3,
	// 	'elegant' => 4,
	// 	'minimal' => 2,
	// ];
	// $template_style = $request->template_style;
	// $source_id = $template_map[$template_style] ?? 12;

	// $payload_raw = $request->payload;

	// $payload = is_string($payload_raw)
	// 	? json_decode($payload_raw, true)
	// 	: $payload_raw;
	// $socials = $payload['social_links'] ?? [];
	// // print_r($socials);
	// $posts = get_posts([
	// 	'post_type'   => ['page', 'post'],
	// 	'post_status' => 'any',
	// 	'numberposts' => -1,
	// ]);
	// print_r($posts);
	// print_r(count($posts));
	// gkp_process_next_site_request();
	// die($posts);
	// die('end');
	include('form-includes/logs/submissionlog.php');
}


function gkp_render_clone_view_page()
{
	if (!current_user_can('manage_network_options')) {
		wp_die('Unauthorized');
	}

	if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		wp_die('Invalid submission ID');
	}

	global $wpdb;
	$id    = (int) $_GET['id'];
	$table = $wpdb->base_prefix . 'gkp_clone_submissions';

	$submission = $wpdb->get_row(
		$wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", $id)
	);

	if (!$submission) {
		wp_die('Submission not found');
	}

	// Normalize NULL values
	foreach ($submission as $key => $value) {
		if ($value === null) {
			$submission->$key = '';
		}
	}

	//COMMON DATA (SAME FOR ALL TEMPLATES)
	$common_view_data = [
		'books'        => json_decode($submission->book_title, true) ?: [],
		'social_links' => json_decode($submission->social_links, true) ?: [],
		'branding'     => json_decode($submission->branding, true) ?: [],
	];

	// TEMPLATE DATA
	$raw_template = json_decode($submission->template_content, true) ?: [];

	$template_view_data = gkp_arrange_template_blocks(
		$submission->template,
		$raw_template
	);

	// RENDER VIEW
	include __DIR__ . '/form-includes/logs/submission-view.php';
}

function gkp_arrange_template_blocks(string $template, array $raw_template): array
{
	switch ($template) {

		case 'minimal':
			return gkp_template_minimal($raw_template);

		case 'simple':
			return gkp_template_simple($raw_template);

		default:
			return [];
	}
}


function gkp_template_minimal(array $raw): array
{
	$blocks = [];

	$home = $raw['home'] ?? [];
	if (!empty($home['section1'])) {
		$blocks[] = ['type' => 'hero', 'data' => $home['section1']];
	}

	if (!empty($home['section2'])) {
		$blocks[] = ['type' => 'cta_group', 'data' => $home['section2']];
	}

	if (!empty($home['section3'])) {
		$blocks[] = ['type' => 'reviews_with_rating', 'data' => $home['section3']];
	}

	if (!empty($home['section4'])) {
		$blocks[] = ['type' => 'reviews_plain', 'data' => $home['section4']];
	}

	if (!empty($raw['about_author'])) {
		$blocks[] = ['type' => 'about_author', 'data' => $raw['about_author']];
	}
	if (!empty($raw['about_press'])) {
		$blocks[] = ['type' => 'about_press', 'data' => $raw['about_press']];
	}

	if (!empty($raw['gallery'])) {
		$blocks[] = ['type' => 'gallery', 'data' => $raw['gallery']];
	}

	return $blocks;
}

function gkp_template_simple(array $raw): array
{
	$blocks = [];

	foreach ($raw as $index => $section) {
		if (!is_array($section) || !array_filter($section)) {
			continue;
		}

		$blocks[] = [
			'type'  => 'simple_section',
			'index' => $index,
			'data'  => $section,
		];
	}

	return $blocks;
}


// Hide footer text
add_action('current_screen', function () {
	$screen = get_current_screen();
	if ($screen && strpos($screen->id, 'gkp-automation') !== false) {
		add_filter('admin_footer_text', '__return_empty_string');
		add_filter('update_footer', '__return_empty_string', 11);
	}
});
add_action('admin_post_gkp_clone_form_submit', 'gkp_handle_clone_form_submission');
