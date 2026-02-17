<?php
/**
 * Block Styles
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
add_action( 'init', function () {

    $blocks = [
        'core/group',
        'core/paragraph',
        'core/heading',
        'core/image',
        'core/button',
        'core/columns',
        'core/column',
    ];

    $animations = [
        'fade-up'    => 'Animate: Fade Up',
        'fade-down'  => 'Animate: Fade Down',
        'fade-left'  => 'Animate: Fade Left',
        'fade-right' => 'Animate: Fade Right',
        'zoom-in'    => 'Animate: Zoom In',
    ];

    foreach ( $blocks as $block ) {
        foreach ( $animations as $slug => $label ) {
            register_block_style(
                $block,
                [
                    'name'  => 'aos-' . $slug,
                    'label' => __( $label, 'gatekeeper-press' ),
                ]
            );
        }
    }
});
