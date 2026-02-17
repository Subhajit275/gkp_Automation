<?php
/**
 * Animations
 *
 * Registers custom Gutenberg block pattern categories
 * used by Gatekeeper Press templates and automation flows.
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom block styles for animations
 *
 * These styles can be applied to Group blocks
 * to enable scroll-based animations via AOS.
 */
add_filter( 'render_block', function ( $block_content, $block ) {

	if ( ! get_option( 'gkp_enable_animations' ) ) {
		return $block_content;
	}

	if ( empty( $block['attrs']['gkpAnimation'] ) ) {
		return $block_content;
	}

	$anim = $block['attrs']['gkpAnimation'];

	if ( empty( $anim['enabled'] ) ) {
		return $block_content;
	}

	$attrs = sprintf(
		' data-aos="%s"%s%s',
		esc_attr( $anim['type'] ),
		! empty( $anim['delay'] ) ? ' data-aos-delay="' . intval( $anim['delay'] ) . '"' : '',
		! empty( $anim['once'] ) ? ' data-aos-once="true"' : ''
	);

	return preg_replace(
		'/(<[^>]+)(>)/',
		'$1' . $attrs . '$2',
		$block_content,
		1
	);

}, 10, 2 );
