<?php

/**
 * Footer Template – Multisite Safe
 *
 * Site 2 → Template Simple (copyright only)
 * Site 3 → Template Minimal (logo + credit)
 * Site 4 → Template Clean (logo + credit)
 *
 * @package Gatekeeper_Press
 */

if (! defined('ABSPATH')) {
	exit;
}

$blog_id = function_exists('get_current_blog_id') ? get_current_blog_id() : 0;
$template = get_option('gkp_template_style');
$template_name = $template;

/* ======================================================
 * SITE 2 → TEMPLATE SIMPLE FOOTER
 * ====================================================== */
if ($template_name == 'simple') :
?>
	<footer class="simple-footer">
		<div class="simple-footer-inner">
			<p class="simple-footer-text">
				Copyright © <?php echo date('Y'); ?>
			</p>
		</div>
	</footer>

	<?php wp_footer(); ?>
	</body>

	</html>
<?php
	return;
endif;


/* ======================================================
 * SITE 3 & 4 → TEMPLATE MINIMAL / CLEAN
 * ====================================================== */
if (! in_array($blog_id, [3, 4], true)) {
	wp_footer();
	echo '</body></html>';
	return;
}

/* Logo per site */
$footer_logo = '';

if ($template_name == 'clean') {
	// Clean template logo
	$footer_logo = 'https://msn.gatekeeperdashboard.com/template-clean/wp-content/uploads/sites/4/2026/01/author-3-768x49-1.png';
}

if ($template_name == 'minimal') {
	// Minimal template logo
	$footer_logo = 'https://msn.gatekeeperdashboard.com/template-minimal/wp-content/uploads/sites/3/2026/01/image-1.png';
}
?>

<footer class="site-footer">
	<div class="footer-inner">

		<?php if ($footer_logo) : ?>
			<div class="footer-logo">
				<img
					src="<?php echo esc_url($footer_logo); ?>"
					alt="Footer Logo"
					loading="lazy">
			</div>
		<?php endif; ?>

		<p class="footer-credit">
			Designed by
			<a href="https://gatekeeperpress.com/" target="_blank" rel="noopener noreferrer">
				Gatekeeper Press
			</a>
		</p>

	</div>
</footer>

<?php wp_footer(); ?>
</body>

</html>