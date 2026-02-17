<?php
/**
 * Theme Setup
 *
 * Registers theme supports, editor features, and navigation menus.
 * Designed for Gutenberg-first usage and multisite automation.
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {

	// Let WordPress manage <title>
	add_theme_support( 'title-tag' );

	// Featured images support
	add_theme_support( 'post-thumbnails' );

	// Adds theme support for post formats.
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

	/* ------------------------------------------------------------------
	 * Gutenberg / Block Editor Support
	 * ------------------------------------------------------------------ */
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	/* ------------------------------------------------------------------
	 * Navigation Menus
	 * ------------------------------------------------------------------ */
	register_nav_menus(
		[
			'primary' => __( 'Primary Menu', 'gatekeeper-press' ),
		]
	);
});
