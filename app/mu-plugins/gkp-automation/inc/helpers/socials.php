<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Normalize social URLs into keyed array
 *
 * @param array|string $raw_socials
 * @return array
 */
function gkp_normalize_socials( $raw_socials ) {

	if ( empty( $raw_socials ) ) {
		return [];
	}

	$socials = is_string( $raw_socials )
		? maybe_unserialize( $raw_socials )
		: $raw_socials;

	if ( ! is_array( $socials ) ) {
		return [];
	}

	$map = [
		'instagram' => '',
		'facebook'  => '',
		'twitter'   => '',
		'linkedin'  => '',
		'youtube'   => '',
		'website'   => '',
	];

	foreach ( $socials as $url ) {

		if ( ! is_string( $url ) ) continue;

		if ( strpos( $url, 'instagram.com' ) !== false ) {
			$map['instagram'] = $url;
		} elseif ( strpos( $url, 'facebook.com' ) !== false ) {
			$map['facebook'] = $url;
		} elseif ( strpos( $url, 'twitter.com' ) !== false || strpos( $url, 'x.com' ) !== false ) {
			$map['twitter'] = $url;
		} elseif ( strpos( $url, 'linkedin.com' ) !== false ) {
			$map['linkedin'] = $url;
		} elseif ( strpos( $url, 'youtube.com' ) !== false ) {
			$map['youtube'] = $url;
		} else {
			$map['website'] = $url;
		}
	}

	return array_filter( $map );
}
