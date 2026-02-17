<?php
if (! defined('ABSPATH')) exit;

add_action('network_admin_menu', function () {

	add_menu_page(
		'GKP Automation',
		'GKP Automation',
		'manage_network_options',
		'gkp-automation',
		'gkp_render_network_settings_page',
		'dashicons-randomize',
		3
	);

	// add_submenu_page(
	// 	'gkp-automation',
	// 	'Logs',
	// 	'Logs',
	// 	'manage_network_options',
	// 	'gkp-automation-logs',
	// 	'gkp_render_network_logs_page'
	// );

	add_submenu_page(
		'gkp-automation',
		'Build Site',
		'Build Site',
		'manage_network_options',
		'gkp-automation-clone-form',
		'gkp_render_network_clone_form_page'
	);

	add_submenu_page(
		'gkp-automation',
		'Submission Logs',
		'Submission Logs',
		'manage_network_options',
		'gkp-clone-submissions',
		'gkp_render_clone_submissions_page'
	);

	add_submenu_page(
		'Clone Submission Details',
		'Clone Submission Details',
		'Clone Submission Details',
		'manage_network_options',
		'gkp-clone-view',
		'gkp_render_clone_view_page'
	);
});
