<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function gkp_parse_sections_from_entry( $entry ) {
    
    if ( empty( $entry['35'] ) ) {
        return [];
    }

    $raw = maybe_unserialize( $entry['35'] );
    if ( ! is_array( $raw ) ) {
        return [];
    }

    $sections = [];

	foreach ( $raw as $row_id => $row ) {

        $sections[] = [
            'background' => $row[ "input_33__{$row_id}" ] ?? '',
            'media'      => $row[ "input_20__{$row_id}" ] ?? '',
            'title'      => $row[ "input_16__{$row_id}" ] ?? '',
            'content'    => $row[ "input_21__{$row_id}" ] ?? '',
            'cta_primary'=> [
                'label' => $row[ "input_22__{$row_id}" ] ?? '',
                'url'   => $row[ "input_23__{$row_id}" ] ?? '',
            ],
            'cta_secondary'=> [
                'label' => $row[ "input_24__{$row_id}" ] ?? '',
                'url'   => $row[ "input_25__{$row_id}" ] ?? '',
            ],
        ];
    }

	return $sections;
}
