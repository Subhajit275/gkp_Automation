<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Replace placeholders across all site content
 *
 * @param array $payload Gravity payload
 */
function gkp_apply_placeholders_to_site( array $payload ) {

	if ( empty( $payload ) ) {
		return;
	}

	$map = gkp_placeholder_map();

	// Normalize payload (flatten socials, safe strings)
	$intake = gkp_normalize_payload_for_placeholders( $payload );

	$posts = get_posts( [
		'post_type'   => [ 'page', 'post' ],
		'post_status' => 'any',
		'numberposts' => -1,
	] );

	foreach ( $posts as $post ) {

		if ( empty( $post->post_content ) ) {
			continue;
		}

		$content = $post->post_content;

		foreach ( $map as $placeholder => $key ) {
			if ( ! empty( $intake[ $key ] ) ) {
				$content = str_replace(
					$placeholder,
					wp_kses_post( $intake[ $key ] ),
					$content
				);
			}
		}

		if ( $content !== $post->post_content ) {
			wp_update_post( [
				'ID'           => $post->ID,
				'post_content' => $content,
			] );
		}
	}
}
