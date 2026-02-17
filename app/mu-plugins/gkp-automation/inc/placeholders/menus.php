<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Replace placeholders inside WordPress menus
 *
 * @param array $intake Normalized payload (author, socials, etc)
 * @return void
 */
function gkp_replace_placeholders_in_menus( array $intake ) {

	if ( empty( $intake ) ) {
		return;
	}

	$map = gkp_placeholder_map();

	// Add social placeholders dynamically
	foreach ( $intake as $key => $value ) {
		if ( str_starts_with( $key, 'social_' ) ) {
			$map[ '{{GKP_' . strtoupper( $key ) . '}}' ] = $key;
		}
	}

	$menus = wp_get_nav_menus();
	if ( empty( $menus ) ) {
		return;
	}

	foreach ( $menus as $menu ) {

		$items = wp_get_nav_menu_items( $menu->term_id );
		if ( empty( $items ) ) {
			continue;
		}

		foreach ( $items as $item ) {

			$updated = false;

			$title = $item->title;
			$url   = $item->url;

			foreach ( $map as $placeholder => $key ) {

				if ( empty( $intake[ $key ] ) ) {
					continue;
				}

				if ( strpos( $title, $placeholder ) !== false ) {
					$title   = str_replace( $placeholder, esc_html( $intake[ $key ] ), $title );
					$updated = true;
				}

				if ( strpos( $url, $placeholder ) !== false ) {
					$url     = str_replace( $placeholder, esc_url_raw( $intake[ $key ] ), $url );
					$updated = true;
				}
			}

			if ( $updated ) {
				wp_update_post( [
					'ID'         => $item->ID,
					'post_title' => $title,
					'post_name'  => sanitize_title( $title ),
					'meta_input' => [
						'_menu_item_url' => $url,
					],
				] );
			}
		}
	}
}
