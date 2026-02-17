<?php

/**
 * Theme Assets
 *
 * Handles frontend styles, global styles,
 * brand typography, brand colors,
 * editor panels, and animations.
 *
 * @package Gatekeeper_Press
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ------------------------------------------------------------------------
 * FRONTEND STYLES + GLOBAL STYLES + BRAND COLORS
 * --------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', function () {

    /*
    |--------------------------------------------------------------------------
    | Main Theme Stylesheet
    |--------------------------------------------------------------------------
    */
    wp_enqueue_style(
        'gatekeeper-press-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    /*
    |--------------------------------------------------------------------------
    | Inject theme.json Generated CSS (for classic themes)
    |--------------------------------------------------------------------------
    */
    $global_css = wp_get_global_stylesheet();

    if (! empty($global_css)) {
        wp_register_style('gkp-global-styles', false);
        wp_add_inline_style('gkp-global-styles', $global_css);
        wp_enqueue_style('gkp-global-styles');
    }

    /*
    |--------------------------------------------------------------------------
    | Inject Branding Colors
    |--------------------------------------------------------------------------
    */
    $branding = get_option('gkp_branding');

    if (! empty($branding)) {

        $css = '';

        /* -------------------------
         * Secondary Color (Body Text)
         * ---------------------- */
        if (! empty($branding['secondary_color'])) {
            $css .= "
                body,
                .wp-site-blocks,
                .entry-content,
                p,
                li {
                    color: {$branding['secondary_color']};
                }
            ";
        }

        /* -------------------------
         * Primary Color (Headings + Links)
         * ---------------------- */
        if (! empty($branding['primary_color'])) {
            $css .= "
                h1, h2, h3, h4, h5, h6 {
                    color: {$branding['primary_color']};
                }

                a {
                    color: {$branding['primary_color']};
                }
            ";
        }

        if (! empty($css)) {
            wp_add_inline_style('gatekeeper-press-style', $css);
        }
    }

}, 20);



/* ------------------------------------------------------------------------
 * BRAND FONTS (Frontend + Editor)
 * --------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', 'gkp_enqueue_brand_fonts');
add_action('enqueue_block_editor_assets', 'gkp_enqueue_brand_fonts');

if (! function_exists('gkp_enqueue_brand_fonts')) :

function gkp_enqueue_brand_fonts() {

    $branding = get_option('gkp_branding');
    if (empty($branding)) return;

    $families = [];

    foreach (['heading_font', 'body_font'] as $key) {

        if (empty($branding[$key]['family'])) continue;

        $family = str_replace(' ', '+', $branding[$key]['family']);

        if (! empty($branding[$key]['weights'])) {
            $weights = implode(';', array_map('intval', $branding[$key]['weights']));
            $families[] = "{$family}:wght@{$weights}";
        } else {
            $families[] = $family;
        }
    }

    if (empty($families)) return;

    $url = 'https://fonts.googleapis.com/css2?family=' .
        implode('&family=', array_unique($families)) .
        '&display=swap';

    wp_enqueue_style('gkp-brand-fonts', esc_url($url), [], null);
}

endif;



/* ------------------------------------------------------------------------
 * EDITOR UI - Page Settings Panel
 * --------------------------------------------------------------------- */
add_action('enqueue_block_editor_assets', function () {

    wp_enqueue_script(
        'gkp-page-settings',
        get_template_directory_uri() . '/assets/editor/page-settings.js',
        [
            'wp-plugins',
            'wp-edit-post',
            'wp-element',
            'wp-components',
            'wp-data'
        ],
        wp_get_theme()->get('Version'),
        true
    );

});


/* ------------------------------------------------------------------------
 * EDITOR UI — ANIMATIONS PANEL
 * --------------------------------------------------------------------- */
add_action('enqueue_block_editor_assets', function () {

    if (! get_option('gkp_enable_animations')) {
        return;
    }

    wp_enqueue_script(
        'gkp-animations-panel',
        get_template_directory_uri() . '/assets/editor/animations-panel.js',
        [
            'wp-hooks',
            'wp-element',
            'wp-components',
            'wp-block-editor',
            'wp-editor',
        ],
        wp_get_theme()->get('Version'),
        true
    );

});


/* ------------------------------------------------------------------------
 * ANIMATION LIBRARY (AOS)
 * --------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', function () {

    if (! get_option('gkp_enable_animations')) {
        return;
    }

    // AOS CSS
    wp_enqueue_style(
        'aos',
        'https://unpkg.com/aos@2.3.4/dist/aos.css',
        [],
        '2.3.4'
    );

    // AOS JS
    wp_enqueue_script(
        'aos',
        'https://unpkg.com/aos@2.3.4/dist/aos.js',
        [],
        '2.3.4',
        true
    );

    // Initialize AOS
    wp_add_inline_script(
        'aos',
        'document.addEventListener("DOMContentLoaded", function(){ 
            AOS.init({ 
                once: true, 
                duration: 700, 
                easing: "ease-out-cubic" 
            }); 
        });'
    );

}, 30);
