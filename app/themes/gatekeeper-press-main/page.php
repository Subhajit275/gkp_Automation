<?php
/**
 * Page Template
 *
 * Default template for displaying standard WordPress pages.
 * Compatible with Gutenberg blocks and multisite automation.
 *
 * Responsibilities:
 * - Load global header and footer
 * - Render page content using the WordPress Loop
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

get_header();
?>

<main id="primary" class="site-main" role="main">

	<?php
	/**
	 * Main Page Loop
	 *
	 * Loads the content created via the Gutenberg editor.
	 * This keeps layout control inside blocks and theme styles.
	 */
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile;
	?>

</main><!-- #primary -->

<?php
get_footer();
