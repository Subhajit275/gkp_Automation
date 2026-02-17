<?php
/**
 * Template Style Handler
 *
 * Applies selected template style as a body class.
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gkp_get_template_style' ) ) :
	/**
	 * Get selected template style
	 *
	 * @return string
	 */
	function gkp_get_template_style() {
		return get_option( 'gkp_template_style', 'clean' );
	}
endif;

add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'template-' . esc_attr( gkp_get_template_style() );
	return $classes;
} );
