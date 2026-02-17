<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

function gkp_install_db_tables() {

	$tables = gkp_get_db_tables();

	foreach ( $tables as $table_name => $sql ) {
		dbDelta( $sql );
	}

	update_site_option( 'gkp_db_version', '1.0.0' );
}
