<?php
if (!defined('ABSPATH')) exit;

/**
 * Handle Clone Form Submission (Network Admin)
 */
function gkp_handle_clone_form_submission()
{
    // Security: nonce
    if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'gkp_clone_form_submit')
    ) {
        wp_die('Invalid request. Nonce verification failed.');
    }

    // Security: capability
    if (!current_user_can('manage_network_options')) {
        wp_die('Unauthorized access.');
    }

    global $wpdb;
    $table = $wpdb->base_prefix . 'gkp_clone_submissions';

    /**
     * -------------------------------------------------
     * STEP 1: Basic Fields
     * -------------------------------------------------
     */
    $author_id    = sanitize_text_field($_POST['author_id'] ?? '');
    $author_name  = sanitize_text_field($_POST['author_name'] ?? '');
    $author_email = sanitize_email($_POST['author_email'] ?? '');

    $book_titles = [];
    if (!empty($_POST['book_titles']) && is_array($_POST['book_titles'])) {
        foreach ($_POST['book_titles'] as $title) {
            $title = sanitize_text_field($title);
            if ($title !== '') {
                $book_titles[] = $title;
            }
        }
    }
    $template     = sanitize_text_field($_POST['template'] ?? '');

    /**
     * -------------------------------------------------
     * STEP 2: Social Links
     * -------------------------------------------------
     */
    $social_links = [];

    if (!empty($_POST['social_links']) && is_array($_POST['social_links'])) {
        foreach ($_POST['social_links'] as $platform => $url) {
            if ($url) {
                $social_links[sanitize_key($platform)] = esc_url_raw($url);
            }
        }
    }

    /**
     * -------------------------------------------------
     * STEP 3: Template Content (Simple / Minimal)
     * -------------------------------------------------
     */
    $template_content = [];

    if ($template === 'simple' && isset($_POST['simple'])) {
        $template_content = gkp_sanitize_template_data($_POST['simple']);
    }

    if ($template === 'minimal' && isset($_POST['minimal'])) {
        $template_content = gkp_sanitize_template_data($_POST['minimal']);
    }

    /**
     * -------------------------------------------------
     * STEP 4: Branding
     * -------------------------------------------------
     */
    $branding = [];

    if (isset($_POST['branding']) && is_array($_POST['branding'])) {
        $branding = [
            'site_title'      => sanitize_text_field($_POST['branding']['site_title'] ?? ''),
            'site_tagline'    => sanitize_text_field($_POST['branding']['site_tagline'] ?? ''),
            'logo'            => $_POST['branding']['logo'] ?? '',
            'primary_color'   => sanitize_hex_color($_POST['branding']['primary_color'] ?? '#2271b1'),
            'secondary_color' => sanitize_hex_color($_POST['branding']['secondary_color'] ?? '#72aee6'),
            'title_font'      => sanitize_text_field($_POST['branding']['title_font'] ?? ''),
            'body_font'       => sanitize_text_field($_POST['branding']['body_font'] ?? ''),
        ];
    }

    /**
     * -------------------------------------------------
     * STEP 5: Insert into DB
     * -------------------------------------------------
     */
    $insert_data = [
        'author_id'        => $author_id,
        'author_name'      => $author_name,
        'author_email'     => $author_email,
        'book_title'       => wp_json_encode($book_titles),
        'social_links'     => wp_json_encode($social_links),
        'template'         => $template,
        'template_content' => wp_json_encode($template_content),
        'branding'         => wp_json_encode($branding),
        'status'           => 'completed',
        'created_at'       => current_time('mysql'),
    ];

    $formats = [
        '%s', // author_id
        '%s', // author_name
        '%s', // author_email
        '%s', // book_title
        '%s', // social_links
        '%s', // template
        '%s', // template_content
        '%s', // branding
        '%s', // status
        '%s', // created_at
    ];

    $result = $wpdb->insert($table, $insert_data, $formats);

    if ($result === false) {
        wp_die(
            '<strong>Database error:</strong><br>' .
                esc_html($wpdb->last_error)
        );
    }

    // insert into site request table
    $entry_id = $wpdb->insert_id;
    $payload = [
        'author' => [
            'id'    => $author_id,
            'name'  => $author_name,
            'email' => $author_email,
        ],
        'book' => [
            'title' => $book_titles,
        ],
        'template' => [
            'style'   => $template,
            'content' => $template_content,
        ],
        'branding' => $branding,
        'social_links' => $social_links,
        'meta' => [
            'submitted_by' => get_current_user_id(),
            'submitted_at' => current_time('mysql'),
            'ip'           => $_SERVER['REMOTE_ADDR'] ?? null,
        ],
    ];
    $payload_json = wp_json_encode($payload, JSON_UNESCAPED_UNICODE);

    $site_requests_table = $wpdb->base_prefix . 'gkp_site_requests';
    $site_request_data = [
        'entry_id'       => $entry_id,
        'template_style' => sanitize_text_field($template),
        'payload'        => $payload_json,
        'status'         => 'pending',
        'created_at'     => current_time('mysql'),
    ];

    $site_request_formats = [
        '%d', // entry_id
        '%s', // template_style
        '%s', // payload
        '%s', // status
        '%s', // created_at
    ];

    $site_request_result = $wpdb->insert(
        $site_requests_table,
        $site_request_data,
        $site_request_formats
    );

    if ($site_request_result === false) {
        wp_die(
            '<strong>Site request insert failed:</strong><br>' .
                esc_html($wpdb->last_error)
        );
    } else {
        // Schedule next job (queue continues)
        wp_schedule_single_event(time(), 'gkp_process_site_requests');
    }
    // insert into site request table

    //  STEP 6: Redirect back (success)

    wp_redirect(
        network_admin_url('admin.php?page=gkp-automation-clone-form&success=1')
    );
    exit;
}

/**
 * -------------------------------------------------
 * Recursive Template Sanitizer
 * (Handles gallery images + captions safely)
 * -------------------------------------------------
 */
function gkp_sanitize_template_data($data)
{
    if (!is_array($data)) {
        return sanitize_text_field($data);
    }

    $clean = [];

    foreach ($data as $key => $value) {

        if (is_array($value)) {
            $clean[$key] = gkp_sanitize_template_data($value);
            continue;
        }

        // URLs (images, links, media)
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $clean[$key] = esc_url_raw($value);
            continue;
        }

        // Text / captions / titles
        $clean[$key] = sanitize_text_field($value);
    }

    return $clean;
}
