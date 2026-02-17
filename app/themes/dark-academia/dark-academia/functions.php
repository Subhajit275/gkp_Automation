<?php
/**
 * Dark Academia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dark Academia
 * @since Dark Academia 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------------
 * Theme Support
 * --------------------------------------------------------------------- */
if ( ! function_exists( 'dark_academia_support' ) ) :

	function dark_academia_support() {

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Load translations.
		load_theme_textdomain( 'dark-academia' );
	}

endif;
add_action( 'after_setup_theme', 'dark_academia_support' );

/* ------------------------------------------------------------------------
 * Enqueue Theme Styles
 * --------------------------------------------------------------------- */
if ( ! function_exists( 'dark_academia_styles' ) ) :

	function dark_academia_styles() {

		wp_enqueue_style(
			'dark-academia-style',
			get_stylesheet_directory_uri() . '/style.css',
			[],
			wp_get_theme()->get( 'Version' )
		);
	}

endif;
add_action( 'wp_enqueue_scripts', 'dark_academia_styles' );

/* ------------------------------------------------------------------------
 * Blog Section Shortcode
 * Usage: [blog_loop]
 * --------------------------------------------------------------------- */
add_shortcode( 'blog_loop', function () {

	ob_start();

	$query = new WP_Query( [
		'post_type'      => 'post',
		'posts_per_page' => 2,
		'post_status'    => 'publish',
	] );

	if ( $query->have_posts() ) : ?>

		<div class="blog-loop-wrapper wp-block-group alignfull has-background-background-color has-background">
			<div class="blog-loop-columns wp-block-columns alignfull is-layout-flex">

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<div class="blog-loop-column wp-block-column is-layout-flow">

						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="wp-block-image aligncenter size-full">
								<?php the_post_thumbnail( 'large' ); ?>
							</figure>
						<?php endif; ?>

						<h2 class="blog-loop-title wp-block-heading">
							<?php the_title(); ?>
						</h2>

						<p class="blog-loop-excerpt">
							<?php echo esc_html( wp_trim_words( get_the_excerpt(), 40 ) ); ?>
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
} );

/* ------------------------------------------------------------------------
 * Load Events Module (Shared)
 * --------------------------------------------------------------------- */
$events_module = WP_CONTENT_DIR . '/custom-event/events-module.php';
if ( file_exists( $events_module ) ) {
	require_once $events_module;
}

/* ------------------------------------------------------------------------
 * Load Blog Loop Minimal CSS (ONLY for Blog ID 6)
 * --------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function () {

	if ( function_exists( 'get_current_blog_id' ) && get_current_blog_id() === 6 ) {

		$version = defined( 'GKP_THEME_VERSION' )
			? GKP_THEME_VERSION
			: wp_get_theme()->get( 'Version' );

		wp_enqueue_style(
			'blog-loop-minimal-css',
			get_stylesheet_directory_uri() . '/assets/css/blog-loop-minimal.css',
			[],
			$version
		);
	}

} );
add_filter( 'template_include', function ( $template ) {

	if ( is_singular( 'event' ) ) {

		$custom = get_theme_file_path( 'single-event.html' );

		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}

	return $template;
}, 99 );
