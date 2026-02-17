<?php
/**
 * Index Template
 *
 * Fallback template for displaying content when no other template matches.
 * Designed to be Gutenberg-first and layout-agnostic.
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main" role="main">

	<?php
	/**
	 * Main Content Loop
	 *
	 * Outputs block-based content.
	 * Layout and styling are handled via Gutenberg and theme styles.
	 */
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile;
	?>

</main><!-- #primary -->

<?php
get_footer();
