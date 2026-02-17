<?php
if (! defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php

	$template = get_option('gkp_template_style');
	$template_name = $template;
	$blog_id = function_exists('get_current_blog_id') ? get_current_blog_id() : 0;

	/* ======================================================
 * SITE 4 → TEMPLATE CLEAN HEADER
 * ====================================================== */
	if ($template_name == 'clean') :
	?>
		<header class="site-header site-header-clean">
			<div class="container">

				<div class="site-branding">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
						<img src="https://msn.gatekeeperdashboard.com/template-clean/wp-content/uploads/sites/4/2026/01/author-3-768x49-1.png" alt="<?php bloginfo('name'); ?>">
					</a>
				</div>

				<nav class="primary-navigation">
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
						'container'      => false,
					]);
					?>
				</nav>

				<div class="header-social">
					<a href="#" class="social-icon instagram"></a>
					<a href="#" class="social-icon twitter"></a>
					<a href="#" class="social-icon facebook"></a>
					<a href="#" class="social-icon youtube"></a>
				</div>

			</div>
		</header>
	<?php endif; ?>


	<?php
	/* ======================================================
 * SITE 3 → TEMPLATE MINIMAL HEADER
 * ====================================================== */
	if ($template_name == 'minimal') :
	?>
		<header class="minimal-header">

			<div class="minimal-header-top">

				<div class="minimal-logo">
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<img src="https://msn.gatekeeperdashboard.com/template-minimal/wp-content/uploads/sites/3/2026/01/image-1.png" alt="Out of Luck">
					</a>
				</div>

				<nav class="minimal-navigation">
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'menu_class'     => 'minimal-menu',
						'container'      => false,
					]);
					?>
				</nav>

			</div>

			<div class="minimal-social-bar">
				<a href="#" class="social-circle instagram"></a>
				<a href="#" class="social-circle twitter"></a>
				<a href="#" class="social-circle facebook"></a>
				<a href="#" class="social-circle youtube"></a>
			</div>

		</header>
	<?php endif; ?>
	<?php
	/* ======================================================
 * SITE 2 → TEMPLATE SIMPLE HEADER
 * ====================================================== */
	if ($template_name == 'simple') :
	?>
		<header class="simple-header">

			<!-- TOP AREA -->
			<div class="simple-header-top">

				<!-- LOGO -->
				<div class="simple-logo">
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<img
							src="https://msn.gatekeeperdashboard.com/template-simple/wp-content/uploads/sites/2/2025/12/logo.png"
							alt="<?php bloginfo('name'); ?>">
					</a>
				</div>

				<!-- SOCIAL ICONS -->
				<div class="simple-social">
					<a href="#" class="social-icon instagram" aria-label="Instagram"></a>
					<a href="#" class="social-icon twitter" aria-label="X"></a>
					<a href="#" class="social-icon facebook" aria-label="Facebook"></a>
					<a href="#" class="social-icon youtube" aria-label="YouTube"></a>
				</div>

			</div>

			<!-- MENU BAR -->
			<nav class="simple-navigation">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'menu_class'     => 'simple-menu',
					'container'      => false,
				]);
				?>
			</nav>

		</header>
	<?php endif; ?>