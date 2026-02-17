<?php

/**
 * Plugin Name: Gatekeeper Press – Automation Engine
 * Description: Network-level automation engine for site provisioning, intake processing, branding, animations, and NS Cloner integration. (Always-on provisioning & automation logic.)
 * Version: 1.0.0
 * Author: IkshuDigital LLC
 * Author URI: https://ikshudigital.com/
 * Network: true
 * Requires PHP: 8.0
 */

if (! defined('ABSPATH')) exit;

define('GKP_AUTOMATION_PATH', WPMU_PLUGIN_DIR . '/gkp-automation/');
define(
	'GKP_AUTOMATION_URL',
	content_url('mu-plugins/gkp-automation/')
);
/**
 * Safe require helper
 */
function gkp_mu_require($file)
{
	$path = GKP_AUTOMATION_PATH . '/inc/' . ltrim($file, '/');
	if (file_exists($path)) {
		require_once $path;
	}
}

/* Core */
gkp_mu_require('helpers/socials.php');
gkp_mu_require('helpers.php');
gkp_mu_require('lifecycle.php');

/* Database */
gkp_mu_require('db/tables.php');
gkp_mu_require('db/install.php');
gkp_mu_require('db/upgrade.php');

/* APIs */
gkp_mu_require('api/authors.php');
gkp_mu_require('api/intake.php');

/* Gravity Form Support */
gkp_mu_require('gravity/enqueue.php');
gkp_mu_require('gravity/hooks.php');
gkp_mu_require('gravity/parser.php');

/* Background Queue */
gkp_mu_require('queue/worker.php');
gkp_mu_require('queue/processor.php');
gkp_mu_require('cloner/ns-cloner.php');

/* Automation */
gkp_mu_require('animations.php');
gkp_mu_require('ns-cloner.php');

/* Network UI */
gkp_mu_require('network-menu.php');
gkp_mu_require('network-settings-page.php');
gkp_mu_require('network-settings-handler.php');
gkp_mu_require('logs.php');

gkp_mu_require('network-clone-form.php');   
gkp_mu_require('network-clone-submission.php');

add_action('init', function () {

	static $checked = false;
	if ($checked) {
		return;
	}
	$checked = true;
	$current_version = get_site_option('db_version');

	if (! $current_version) {
		gkp_install_db_tables();
	} else {
		gkp_upgrade_db_tables();
	}
});


require_once __DIR__ . '/gkp-automation/inc/placeholders/map.php';
