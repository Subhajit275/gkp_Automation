<?php
/**
 * Front Page Template
 *
 * Template for the site homepage when a static front page is configured.
 * Fully controlled via Gutenberg blocks.
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
	 * Front Page Content
	 *
	 * Enables block-based hero sections, CTAs, and layouts.
	 */
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile;
	?>


</main><!-- #primary -->

<?php
get_footer();