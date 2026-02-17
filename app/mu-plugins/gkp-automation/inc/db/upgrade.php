<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function gkp_upgrade_db_tables() {

	$current = get_site_option( 'gkp_db_version', '0.0.0' );

	if ( version_compare( $current, '1.0.0', '<' ) ) {
		gkp_install_db_tables();
	}

	// Example future upgrade:
	// if ( version_compare( $current, '1.1.0', '<' ) ) {
	//     global $wpdb;
	//     $wpdb->query(
	//         "ALTER TABLE {$wpdb->base_prefix}gkp_authors ADD COLUMN phone VARCHAR(50)"
	//     );
	//     update_site_option( 'gkp_db_version', '1.1.0' );
	// }
}
