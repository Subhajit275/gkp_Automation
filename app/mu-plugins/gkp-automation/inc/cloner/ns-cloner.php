<?php
if (! defined('ABSPATH')) {
    exit;
}

/**
 * STEP 1: Trigger clone
 */
function gkp_clone_site_from_template(array $payload, string $template_style)
{

    if (! function_exists('ns_cloner_perform_clone')) {
        return new WP_Error(
            'ns_cloner_missing',
            'NS Cloner v4.4.1+ is required'
        );
    }
    // Save payload temporarily (used by hook)
    set_transient('gkp_last_clone_payload', $payload, 10);
    set_transient('gkp_last_clone_template', $template_style, 10);

    $template_map = [
        'simple'  => 2,
        'minimal' => 3,
        'elegant' => 4,
        'clean'   => 1,
        
    ];

    $source_id = $template_map[$template_style] ?? 1;
    $author_name = $payload['author']['name'] ?? 'site';
    $target_name = sanitize_title($author_name);
    $base_slug = $target_name;
    $host         = parse_url(network_home_url(), PHP_URL_HOST);
    $network_path = parse_url(network_home_url(), PHP_URL_PATH); // gives "/website/"
    $i    = 1;
    $slug = $base_slug;
    while (true) {
        // Build EXACT path like wp_blogs.path
        $slug_path = trailingslashit($network_path . $slug);
        $blog_id = get_blog_id_from_url($host, $slug_path);
        if ((int) $blog_id === 0) {
            break;
        }
        $slug = $base_slug . '-' . $i;
        $i++;
    }
    $response = ns_cloner_perform_clone([
        'clone_mode'     => 'core',
        'source_id'      => $source_id,
        'target_name'    => $slug,
        'target_title'   => sanitize_text_field($author_name),
        'do_copy_posts'  => 1,
        'do_copy_files'  => 1,
    ]);

    if (is_wp_error($response)) {
        return $response;
    }

    return [
        'success' => true,
        'message' => 'Clone started successfully'
    ];
}

/**
 * STEP 2: AFTER CLONE — GET REAL SITE ID
 */
add_action('ns_cloner_clone_complete', function ($cloner) {

    error_log('NS Cloner ERROR: target_id missing');
    error_log('New site ID: ' . $cloner);
    die();

    if (empty($cloner->target_id)) {
        error_log('NS Cloner ERROR: target_id missing');
        return;
    }

    /**
     * ✅ REAL NEW SITE ID (wp_blogs.blog_id)
     */
    $site_id = (int) $cloner->target_id;
    /**
     * Retrieve stored payload
     */
    $payload        = get_transient('gkp_last_clone_payload');
    $template_style = get_transient('gkp_last_clone_template');

    delete_transient('gkp_last_clone_payload');
    delete_transient('gkp_last_clone_template');

    /**
     * STORE site_id (YOUR REQUIREMENT)
     */
    // Network-level storage
    update_site_meta($site_id, 'site_id', $site_id);

    // Inside cloned site
    switch_to_blog($site_id);
    update_option('site_id', $site_id);
    restore_current_blog();

    /**
     * UPDATE ALL DATA ON NEW SITE
     */
    switch_to_blog($site_id);


    if (is_array($payload)) {

        update_option('gkp_template_style', $template_style);

        if (! empty($payload['author']['name'])) {
            update_option(
                'blogname',
                sanitize_text_field($payload['author']['name'])
            );
        }

        if (! empty($payload['author']['bio'])) {
            update_option(
                'blogdescription',
                sanitize_textarea_field($payload['author']['bio'])
            );
        }

        update_option(
            'gkp_enable_animations',
            ! empty($payload['enable_animations']) ? 1 : 0
        );
    }
    gkp_set_front_page();
    gkp_apply_intake_to_site();

    restore_current_blog();
}, 10, 1);

/**
 * STEP 3: Ensure valid site flags
 */
add_filter('ns_cloner_site_args', function ($args) {

    $args['public']   = $args['public']   ?? 1;
    $args['archived'] = $args['archived'] ?? 0;
    $args['mature']   = $args['mature']   ?? 0;
    $args['spam']     = $args['spam']     ?? 0;
    $args['deleted']  = $args['deleted']  ?? 0;
    $args['lang_id']  = $args['lang_id']  ?? 0;

    return $args;
});


add_filter('ns_cloner_site_tables', function ($tables) {
    global $wpdb;
    $base = $wpdb->base_prefix;
    $exclude = [
        $base . 'gkp_authors',
        $base . 'gkp_site_requests',
        $base . 'gkp_clone_submissions',
    ];
    return array_diff($tables, $exclude);
});


add_action('wp_delete_site', function ($site) {
    global $wpdb;

    $blog_id = $site->id;
    $prefix  = $wpdb->get_blog_prefix($blog_id);

    $wpdb->query("DROP TABLE IF EXISTS {$prefix}custom_table_name");
});


if (! function_exists('gkp_set_front_page')) :
    function gkp_set_front_page()
    {

        $home = get_page_by_path('home');

        if ($home) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home->ID);
        }
    }
endif;



if (! function_exists('gkp_apply_intake_to_site')) :
    function gkp_apply_intake_to_site()
    {

        $intake = get_option('gkp_intake_data');
        if (empty($intake) || ! is_array($intake)) {
            return;
        }

        $map = gkp_placeholder_map();

        $posts = get_posts([
            'post_type'      => ['page', 'post'],
            'post_status'    => 'any',
            'numberposts'    => -1,
            'suppress_filters' => false,
        ]);

        foreach ($posts as $post) {

            if (empty($post->post_content)) {
                continue;
            }

            $content = $post->post_content;
            $updated = $content;

            foreach ($map as $placeholder => $key) {

                if (isset($intake[$key]) && $intake[$key] !== '') {

                    $value = wp_kses_post($intake[$key]);

                    $updated = str_replace(
                        $placeholder,
                        $value,
                        $updated
                    );
                }
            }

            if ($updated !== $content) {

                remove_action('save_post', 'gkp_apply_intake_to_site');

                wp_update_post([
                    'ID'           => $post->ID,
                    'post_content' => $updated,
                ]);

                clean_post_cache($post->ID);
            }
        }

        flush_rewrite_rules(false);
    }
endif;
