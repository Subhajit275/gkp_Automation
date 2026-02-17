<?php

/**
 * Branding Runtime Overrides
 *
 * Applies branding colors and fonts dynamically from intake data.
 *
 * @package Gatekeeper_Press
 */

if (! defined('ABSPATH')) {
	exit;
}

/* ------------------------------------------------------------------------
 * Runtime Color Palette (theme.json)
 * --------------------------------------------------------------------- */
add_filter('wp_theme_json_data_theme', function ($theme_json) {

	$branding = get_option('gkp_branding');
	// print_r($branding);
	// die();
	if (empty($branding)) {
		return $theme_json;
	}

	return $theme_json->update_with(
		[
			'settings' => [
				'color' => [
					'palette' => [
						[
							'slug'  => 'primary',
							'color' => $branding['primary_color'],
							'name'  => 'Primary',
						],
						[
							'slug'  => 'secondary',
							'color' => $branding['secondary_color'],
							'name'  => 'Secondary',
						],
					],
				],
			],
		]
	);
});

/* ------------------------------------------------------------------------
 * Runtime Font Variables
 * --------------------------------------------------------------------- */
add_action('wp_head', function () {

	$branding = get_option('gkp_branding');
	if (empty($branding)) {
		return;
	}

	$heading_font = isset($branding['title_font'])
		? gkp_normalize_font($branding['title_font'])
		: null;

	$body_font = isset($branding['body_font'])
		? gkp_normalize_font($branding['body_font'])
		: null;

	if (! $heading_font && ! $body_font) return;

	echo '<style>:root{';

	if ($heading_font) {
		echo '--gkp-heading-font:"' . esc_attr($heading_font['family']) . '";';
	}

	if ($body_font) {
		echo '--gkp-body-font:"' . esc_attr($body_font['family']) . '";';
	}

	echo '}</style>';
});

if (! function_exists('gkp_normalize_font')) :
	/**
	 * Normalize font config (supports legacy + new formats)
	 *
	 * @since Gatekeeper Press 1.0
	 *
	 * @return void
	 */
	function gkp_normalize_font($font)
	{

		// Legacy string format
		if (is_string($font)) {
			return [
				'family'  => $font,
				'weights' => []
			];
		}

		// New structured format
		if (is_array($font) && ! empty($font['family'])) {
			return [
				'family'  => $font['family'],
				'weights' => isset($font['weights']) && is_array($font['weights'])
					? $font['weights']
					: []
			];
		}

		return null;
	}
endif;
