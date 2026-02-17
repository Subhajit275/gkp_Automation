<?php

/**
 * Template Name: Clean Template
 */
get_header();

wp_head();


// Load block-based header
block_template_part('header');
?>

<!-- Hero Section -->
<section class="single-hero" style="padding-left:10vh; padding-right:10vh;">
    <div style="max-width:1200px;margin:auto;">
        <?php the_post_thumbnail('full', [
            'style' => 'width:100%; height:400px; object-fit:cover;'
        ]); ?>
    </div>
</section>

<section class="single-content" style="padding-left:10vh; padding-right:10vh;">
    <div style="max-width:1200px;margin:auto;">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</section>

<?php
// Load block-based footer
block_template_part('footer');
wp_footer();
get_footer();
?>