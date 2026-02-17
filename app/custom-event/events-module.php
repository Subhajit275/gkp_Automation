<?php

/**
 * Custom Events Module for Twenty Twenty-Five Theme
 *
 * This file handles the registration of the 'Event' custom post type,
 * its meta fields, and any specific functionality related to events.
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Register the 'Event' Custom Post Type.
 */
function register_events_cpt()
{
    $labels = array(
        'name'                  => _x('Events', 'Post Type General Name', 'gatekeeper'),
        'singular_name'         => _x('Event', 'Post Type Singular Name', 'gatekeeper'),
        'menu_name'             => __('Events', 'gatekeeper'),
        'name_admin_bar'        => __('Event', 'gatekeeper'),
        'archives'              => __('Event Archives', 'gatekeeper'),
        'attributes'            => __('Event Attributes', 'gatekeeper'),
        'parent_item_colon'     => __('Parent Event:', 'gatekeeper'),
        'all_items'             => __('All Events', 'gatekeeper'),
        'add_new_item'          => __('Add New Event', 'gatekeeper'),
        'add_new'               => __('Add New', 'gatekeeper'),
        'new_item'              => __('New Event', 'gatekeeper'),
        'edit_item'             => __('Edit Event', 'gatekeeper'),
        'update_item'           => __('Update Event', 'gatekeeper'),
        'view_item'             => __('View Event', 'gatekeeper'),
        'view_items'            => __('View Events', 'gatekeeper'),
        'search_items'          => __('Search Event', 'gatekeeper'),
        'not_found'             => __('Not found', 'gatekeeper'),
        'not_found_in_trash'    => __('Not found in Trash', 'gatekeeper'),
        'featured_image'        => __('Event Image', 'gatekeeper'),
        'set_featured_image'    => __('Set event image', 'gatekeeper'),
        'remove_featured_image' => __('Remove event image', 'gatekeeper'),
        'use_featured_image'    => __('Use as event image', 'gatekeeper'),
        'insert_into_item'      => __('Insert into event', 'gatekeeper'),
        'uploaded_to_this_item' => __('Uploaded to this event', 'gatekeeper'),
        'items_list'            => __('Events list', 'gatekeeper'),
        'items_list_navigation' => __('Events list navigation', 'gatekeeper'),
        'filter_items_list'     => __('Filter events list', 'gatekeeper'),
    );

    $args = array(
        'label'                 => __('Event', 'gatekeeper'),
        'description'           => __('Post Type for Events', 'gatekeeper'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Important for Gutenberg editor support
    );

    register_post_type('event', $args);
}
add_action('init', 'register_events_cpt');

/**
 * Add Meta Box for Event Date
 */
function add_event_meta_box()
{
    add_meta_box(
        'event_date_meta_box',       // Unique ID
        __('Event Date', 'gatekeeper'), // Box title
        'event_meta_box_html', // Content callback
        'event',                     // Post type
        'side'                       // Context (side, normal, advanced)
    );
}
add_action('add_meta_boxes', 'add_event_meta_box');

function event_meta_box_html($post)
{
    $value = get_post_meta($post->ID, '_event_date', true);
?>
    <label for="gatekeeper_event_date"><?php _e('Select the date for this event:', 'gatekeeper'); ?></label>
    <input type="date" name="gatekeeper_event_date" id="gatekeeper_event_date" class="postbox" value="<?php echo esc_attr($value); ?>" style="width:100%; margin-top:5px;">
<?php
}

function save_event_meta_box($post_id)
{
    if (array_key_exists('gatekeeper_event_date', $_POST)) {
        update_post_meta(
            $post_id,
            '_event_date',
            $_POST['gatekeeper_event_date']
        );
    }
}
add_action('save_post', 'save_event_meta_box');

/**
 * Shortcode to display events.
 * Use [events_list] in your "Events / Appearances" page.
 */
function gatekeeper_events_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => -1, // Show all by default
    ), $atts, 'events_list');

    $args = array(
        'post_type'      => 'event',
        'posts_per_page' => $atts['limit'],
        'post_status'    => 'publish',
        'meta_key'       => '_event_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC', // Ascending order by date
    );

    $events_query = new WP_Query($args);

    if (! $events_query->have_posts()) {
        return '<p>' . __('No upcoming events at this time.', 'gatekeeper') . '</p>';
    }

    ob_start();
?>
    <div class="events-list-container">
        <?php while ($events_query->have_posts()) : $events_query->the_post();
            $event_date_raw = get_post_meta(get_the_ID(), '_event_date', true);
            $event_date = $event_date_raw ? date_i18n(get_option('date_format'), strtotime($event_date_raw)) : '';
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('event-item mb-4 pb-4 border-bottom'); ?> style="margin-bottom: 2rem;">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="event-image wp-block-post-featured-image" style="margin-bottom: 1rem;">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large', array('style' => 'width:100%; height:auto;')); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <header class="event-header">
                    <h2 class="event-title wp-block-post-title" style="margin-top: 0;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <?php if ($event_date) : ?>
                        <div class="event-meta" style="margin-bottom: 0.5rem; color: var(--wp--preset--color--contrast); font-weight: 500;">
                            <span class="dashicons dashicons-calendar-alt" style="line-height: inherit;"></span>
                            <?php echo esc_html($event_date); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="event-content wp-block-post-excerpt">
                    <?php the_excerpt(); ?>
                    <p><a href="<?php the_permalink(); ?>" class="wp-block-button__link"><?php _e('Read More', 'twentytwentyfive'); ?></a></p>
                </div>
            </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('events_list', 'gatekeeper_events_shortcode');
