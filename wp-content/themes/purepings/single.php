<?php get_template_part('templates/page', 'header'); ?>
<main class="main <?php echo roots_main_class(); ?>" role="main">
    <div class="main-bg">
        <?php
        $image = get_bloginfo('template_directory') . '/assets/img/base-banner.jpg';
        if(has_post_thumbnail( $post->ID ) ) {
            $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
        }
        ?>
        <div class="banner" style="background-image: url('<?php echo $image; ?>')"></div>
        <?php get_template_part('templates/content', 'single'); ?>
    </div>
</main>