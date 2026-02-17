<?php
if (! defined('ABSPATH')) exit;

add_action('rest_api_init', function () {

	register_rest_route('gkp/v1', '/authors', [
		'methods'  => 'GET',
		'callback' => 'gkp_api_get_authors',
		'permission_callback' => function () {
			return is_user_logged_in() && (
				current_user_can('manage_options') ||
				current_user_can('manage_sites')
			);
		}
	]);

	register_rest_route('gkp/v1', '/author/(?P<id>\d+)', [
		'methods'  => 'GET',
		'callback' => 'gkp_api_get_author',
		'permission_callback' => function () {
			return is_user_logged_in() && (
				current_user_can('manage_options') ||
				current_user_can('manage_sites')
			);
		}
	]);
});

function gkp_api_get_authors()
{
	global $wpdb;
	$table = $wpdb->base_prefix . 'gkp_authors';

	return $wpdb->get_results(
		"SELECT id, name FROM {$table} WHERE status = 'pending' ORDER BY name",
		ARRAY_A
	);
}

function gkp_api_get_author($request)
{
	global $wpdb;
	$table = $wpdb->base_prefix . 'gkp_authors';
	$id = (int) $request['id'];

	return $wpdb->get_row(
		$wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", $id),
		ARRAY_A
	);
}
