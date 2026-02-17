<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Prepare payload for placeholder replacement
 *
 * - Unserializes socials if needed
 * - Flattens socials into deterministic keys
 */
function gkp_normalize_payload_for_placeholders( array $payload ) {

	$data = $payload;

	/* -------------------------------------------------
	 * Normalize socials (serialized or array)
	 * ------------------------------------------------- */
	if ( ! empty( $payload['socials'] ) ) {

		$socials = $payload['socials'];

		// If serialized string → unserialize
		if ( is_string( $socials ) && is_serialized( $socials ) ) {
			$socials = maybe_unserialize( $socials );
		}

		// Now process as array
		if ( is_array( $socials ) ) {

			foreach ( $socials as $url ) {

				if ( ! is_string( $url ) ) {
					continue;
				}

				if ( strpos( $url, 'instagram.com' ) !== false ) {
					$data['social_instagram'] = $url;
				}
				elseif ( strpos( $url, 'facebook.com' ) !== false ) {
					$data['social_facebook'] = $url;
				}
				elseif (
					strpos( $url, 'twitter.com' ) !== false ||
					strpos( $url, 'x.com' ) !== false
				) {
					$data['social_twitter'] = $url;
				}
				else {
					$data['social_website'] = $url;
				}
			}
		}
	}

	return $data;
}
