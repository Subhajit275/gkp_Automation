<?php
/**
 * Block Patterns
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
 * Register custom block pattern categories
 *
 * Categories are used to organize reusable patterns
 * such as landing sections, author bios, CTAs, etc.
 */
add_action( 'init', function () {

	if ( function_exists( 'register_block_pattern_category' ) ) {

		register_block_pattern_category(
			'gatekeeper',
			[
				'label' => __( 'Gatekeeper Press', 'gatekeeper-press' ),
			]
		);
	}
} );
