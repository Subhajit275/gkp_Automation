<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'network_admin_edit_gkp_automation_settings', function () {

	check_admin_referer( 'gkp_automation_settings' );

	update_site_option(
		'gkp_automation_settings',
		[
			'enabled'           => ! empty( $_POST['enabled'] ),
			'ns_cloner'         => ! empty( $_POST['ns_cloner'] ),
			'placeholders'      => ! empty( $_POST['placeholders'] ),
			'enable_animations' => ! empty( $_POST['enable_animations'] ),
			'default_template'  => sanitize_text_field( $_POST['default_template'] ),
		]
	);

	wp_redirect(
		add_query_arg(
			'updated',
			'true',
			network_admin_url( 'admin.php?page=gkp-automation' )
		)
	);
	exit;
});
