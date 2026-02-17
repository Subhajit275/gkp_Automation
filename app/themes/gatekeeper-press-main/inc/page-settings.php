<?php
/**
 * Branding Runtime Overrides
 *
 * Applies branding colors and fonts dynamically from intake data.
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register page display meta
 */
add_action('init', function () {

    register_post_meta('page', 'gkp_hide_header', [
        'type'              => 'boolean',
        'single'            => true,
        'show_in_rest'      => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'auth_callback'     => function () {
            return current_user_can('edit_pages');
        },
        'default' => false,
    ]);

    register_post_meta('page', 'gkp_hide_footer', [
        'type'              => 'boolean',
        'single'            => true,
        'show_in_rest'      => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'auth_callback'     => function () {
            return current_user_can('edit_pages');
        },
        'default' => false,
    ]);
});