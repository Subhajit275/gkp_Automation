<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'rest_api_init', function () {

    register_rest_route( 'gkp/v1', '/intake', [
        'methods'             => 'POST',
        'callback'            => 'gkp_receive_intake',
        'permission_callback' => 'gkp_verify_secret',
    ] );

});

function gkp_verify_secret( WP_REST_Request $request ) {

    $auth = $request->get_header( 'authorization' );

    if ( ! $auth || ! str_starts_with( $auth, 'Bearer ' ) ) {
        return new WP_Error( 'gkp_auth_missing', 'Authorization header missing', [ 'status' => 401 ] );
    }

    $token  = trim( str_replace( 'Bearer', '', $auth ) );
    $secret = get_site_option( 'gkp_api_secret' );

    if ( ! hash_equals( $secret, $token ) ) {
        return new WP_Error( 'gkp_auth_invalid', 'Invalid API token', [ 'status' => 403 ] );
    }

    return true;
}

function gkp_receive_intake( WP_REST_Request $request ) {
    global $wpdb;

    $table = $wpdb->base_prefix . 'gkp_authors';

    $data = [
        'name'       => sanitize_text_field( $request['author_name'] ?? '' ),
        'book_title' => sanitize_text_field( $request['book_title'] ?? '' ),
        'template'   => sanitize_key( $request['template'] ?? 'clean' ),
        'socials'    => wp_json_encode( $request['socials'] ?? [] ),
        'created_at' => current_time( 'mysql' ),
    ];

    if ( empty( $data['name'] ) ) {
        return new WP_Error( 'gkp_invalid', 'Author name is required', [ 'status' => 422 ] );
    }

    // Prevent duplicates (by name for now)
    $existing_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id FROM {$table} WHERE name = %s",
            $data['name']
        )
    );

    if ( $existing_id ) {

        $wpdb->update(
            $table,
            $data,
            [ 'id' => $existing_id ]
        );

        $author_id = $existing_id;

    } else {

        $wpdb->insert( $table, $data );
        $author_id = $wpdb->insert_id;
    }

    do_action( 'gkp_intake_received', $author_id, $data );

    return [
        'success'   => true,
        'author_id'=> $author_id,
        'message'  => 'Intake received successfully',
    ];
}

// Example of sending intake data to this endpoint
// $entry = []; // Assume this is populated with Gravity Forms entry data
// wp_remote_post(
//     'https://msn.gatekeeperdashboard.com/wp-json/gkp/v1/intake',
//     [
//         'timeout' => 15,
//         'headers' => [
//             'Authorization' => 'Bearer YOUR_SECRET_KEY',
//         ],
//         'body' => [
//             'author_name' => rgar( $entry, '1' ),
//             'book_title'  => rgar( $entry, '2' ),
//             'template'    => rgar( $entry, '3' ),
//             'socials'     => [
//                 'twitter'  => rgar( $entry, '4' ),
//                 'website'  => rgar( $entry, '5' ),
//             ],
//         ],
//     ]
// );

// Example logging action
// add_action( 'gkp_intake_received', function ( $author_id, $data ) {
//     gkp_log( 'intake', 'Received intake for author ID ' . $author_id );
// }, 10, 2 );