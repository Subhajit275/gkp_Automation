<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'gkp_process_site_requests', 'gkp_process_pending_sites' );

function gkp_process_pending_sites() {
	gkp_process_next_site_request();
}