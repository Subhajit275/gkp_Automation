<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function gkp_default_network_settings() {
	$template_data = get_option('gkp_template_data');
	$content_data = json_encode($template_data, JSON_PRETTY_PRINT);
	$array_data = json_decode($content_data, true);
	$theme_template = $array_data['style'];
	//error_log($theme_template);
	return [
		'enabled'           => true,
		'ns_cloner'         => true,
		'placeholders'      => true,
		'enable_animations' => true,
		'default_template'  => $theme_template ?? 'No Temp',
	];
}

/* Silence Gravity Forms logging during automation */
add_filter( 'gform_enable_logging', '__return_false' );

