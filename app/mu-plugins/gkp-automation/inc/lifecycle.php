<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ------------------------------------------------------------------------
 * 1. Scheduler – background queue bootstrap
 * --------------------------------------------------------------------- */
add_action( 'init', function () {

	if ( ! wp_next_scheduled( 'gkp_process_site_requests' ) ) {
		wp_schedule_event( time() + 60, 'minute', 'gkp_process_site_requests' );
	}

});

/* ------------------------------------------------------------------------
 * 2. Automation Lifecycle – runs AFTER site creation
 * --------------------------------------------------------------------- */

/**
 * Applies network defaults to a newly created site.
 *
 * IMPORTANT:
 * - Does NOT clone
 * - Does NOT replace content
 * - SAFE to run multiple times
 */
function gkp_run_automation_lifecycle() {

	$settings = get_site_option(
		'gkp_automation_settings',
		gkp_default_network_settings()
	);

	if ( empty( $settings['enabled'] ) ) {
		return;
	}

	/* ----------------------------------------
	 * Template style
	 * ------------------------------------- */
	if ( ! empty( $settings['default_template'] ) ) {
		update_option(
			'gkp_template_style',
			$settings['default_template']
		);
	}

	/* ----------------------------------------
	 * Animations
	 * ------------------------------------- */
	update_option(
		'gkp_enable_animations',
		! empty( $settings['enable_animations'] )
	);

	/* ----------------------------------------
	 * Fonts (theme bridge)
	 * ------------------------------------- */
	if ( function_exists( 'gkp_apply_font_presets_if_empty' ) ) {
		gkp_apply_font_presets_if_empty();
	}
}