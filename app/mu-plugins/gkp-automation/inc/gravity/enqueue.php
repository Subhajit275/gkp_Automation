<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function () {

	if ( ! is_page( 'build-your-site' ) ) {
		return;
	}

	wp_enqueue_script(
		'gkp-gravity-autofill',
		GKP_AUTOMATION_URL . 'inc/assets/gravity-author-autofill.js',
		[],
		'1.0.0',
		true
	);

	wp_localize_script(
		'gkp-gravity-autofill',
		'GKP_API',
		[
			'root' => esc_url_raw( rest_url( 'gkp/v1/' ) ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
		]
	);

    wp_enqueue_style(
        'gkp-gravity-style',
        GKP_AUTOMATION_URL . 'inc/assets/gravity.css',
        [],
        '1.0.0'
    );

	wp_enqueue_script(
		'gkp-gravity-color-picker',
		GKP_AUTOMATION_URL . 'inc/assets/gravity-color-picker.js',
		[],
		'1.0.0',
		true
	);

});
