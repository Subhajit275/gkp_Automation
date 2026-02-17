<?php

/**
 * Gatekeeper Press Theme Bootstrap
 *
 * Loads all core theme functionality in a controlled, modular way.
 * This file should contain NO business logic — only includes.
 *
 * @package Gatekeeper_Press
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Theme constants
 */
define('GKP_THEME_VERSION', wp_get_theme()->get('Version'));
define('GKP_THEME_PATH', get_template_directory());
define('GKP_THEME_URI', get_template_directory_uri());

/**
 * Helper function to safely load files
 *
 * @param string $relative_path
 */
function gkp_require($relative_path)
{
  $file = GKP_THEME_PATH . '/' . ltrim($relative_path, '/');

  if (file_exists($file)) {
    require_once $file;
  }
}

/* ------------------------------------------------------------------------
 * Core Theme Setup (NO dependencies)
 * --------------------------------------------------------------------- */
gkp_require('inc/theme-setup.php');
gkp_require('inc/block-patterns.php');

/* ------------------------------------------------------------------------
 * Dependency Checks (Admin only, non-fatal)
 * --------------------------------------------------------------------- */
if (is_admin()) {
  gkp_require('inc/dependencies.php');
}

/* ------------------------------------------------------------------------
 * Assets & Styling
 * --------------------------------------------------------------------- */
gkp_require('inc/assets.php');
gkp_require('inc/branding.php');
gkp_require('inc/template-style.php');

/* ------------------------------------------------------------------------
 * Page Settings (Header/Footer visibility)
 * --------------------------------------------------------------------- */
gkp_require('inc/page-settings.php');




/* ------------------------------------------------------------------------
 * Enqueue Blog Loop CSS
 * --------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style(
    'blog-loop-css',
    get_stylesheet_directory_uri() . '/assets/css/blog-loop.css',
    [],
    '1.0'
  );
});


/* ------------------------------------------------------------------------
 * Blog Section Shortcode
 * --------------------------------------------------------------------- */
add_shortcode('blog_loop', function () {
  ob_start();

  $q = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 2,
    'post_status'    => 'publish'
  ]);

  if ($q->have_posts()) : ?>

    <div class="blog-loop-wrapper wp-block-group alignfull has-background-background-color has-background">
      <div class="blog-loop-columns wp-block-columns alignfull is-layout-flex">

        <?php while ($q->have_posts()) : $q->the_post(); ?>

          <div class="blog-loop-column wp-block-column is-layout-flow">

            <figure class="wp-block-image aligncenter size-full">
              <?php if (has_post_thumbnail()) {
                the_post_thumbnail('large');
              } ?>
            </figure>

            <h1 class="blog-loop-title wp-block-heading">
              <?php the_title(); ?>
            </h1>

            <p class="blog-loop-excerpt">
              <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
            </p>

            <div class="wp-block-buttons">
              <div class="wp-block-button">
                <a class="blog-loop-button wp-block-button__link"
                  href="<?php the_permalink(); ?>">
                  Read More
                </a>
              </div>
            </div>

          </div>

        <?php endwhile; ?>

      </div>
    </div>

<?php
    wp_reset_postdata();
  endif;

  return ob_get_clean();
});

/* ------------------------------------------------------------------------
 * Template Minimal – Header CSS (Site ID = 3 ONLY)
 * --------------------------------------------------------------------- */


add_action('wp_enqueue_scripts', function () {


  $template = get_option('gkp_template_style');
  $template_name = $template;

  if ($template_name == 'minimal') {

    wp_enqueue_style(
      'minimal-header-css',
      get_template_directory_uri() . '/assets/css/minimal-header.css',
      [],
      GKP_THEME_VERSION
    );
  }
});
add_action('wp_enqueue_scripts', function () {


  $template = get_option('gkp_template_style');
  $template_name = $template;

  if ($template_name == 'simple') {

    wp_enqueue_style(
      'simple-footer-css',
      get_template_directory_uri() . '/assets/css/header-footer.css',
      [],
      GKP_THEME_VERSION
    );
  }
});
add_action('wp_enqueue_scripts', function () {


  $template = get_option('gkp_template_style');
  $template_name = $template;

  if ($template_name == 'minimal') {

    wp_enqueue_style(
      'blog-loop-minimal-css',
      get_template_directory_uri() . '/assets/css/blog-loop-minimal.css',
      [],
      GKP_THEME_VERSION
    );
  }
});
add_action('wp_enqueue_scripts', function () {
  $template = get_option('gkp_template_style');
  $template_name = $template;
  if ($template_name == 'simple') {

    wp_enqueue_style(
      'simple-header-css',
      get_template_directory_uri() . '/assets/css/simple-header.css',
      [],
      GKP_THEME_VERSION
    );
  }
});
add_action('wp_enqueue_scripts', function () {

  $template = get_option('gkp_template_style');
  $template_name = $template;
  if ($template_name == 'minimal') {

    wp_enqueue_style(
      'blog-loop-minimal-css',
      get_template_directory_uri() . '/assets/css/blog-loop-minimal.css',
      [],
      GKP_THEME_VERSION
    );
  }
});
add_action('wp_enqueue_scripts', function () {

  if (function_exists('get_current_blog_id') && get_current_blog_id() === 1) {

    wp_enqueue_style(
      'blog-loop-minimal-css',
      get_template_directory_uri() . '/assets/css/blog-loop-minimal.css',
      [],
      GKP_THEME_VERSION
    );
  }
});


function mytheme_enqueue_scripts() {

    // First JS file
    wp_enqueue_script(
        'custom-js',
        get_template_directory_uri() . '/assets/editor/animations-panel.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Second JS file
    wp_enqueue_script(
        'extra-js',
        get_template_directory_uri() . '/assets/editor/page-settings.js',
        array('jquery'),
        '1.0.0',
        true
    );

}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');






require_once WP_CONTENT_DIR . '/custom-event/events-module.php';
add_filter('template_include', function ($template) {
  if (is_singular('event')) {
    $custom = WP_CONTENT_DIR . '/plugins/event-templates/single-event.php';
    if (file_exists($custom)) {
      return $custom;
    }
  }
  return $template;
});
