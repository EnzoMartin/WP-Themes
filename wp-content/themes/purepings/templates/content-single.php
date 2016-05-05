<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        <header>
            <small><?php get_template_part('templates/entry-meta'); ?></small>
        </header>
    </article>
<?php endwhile; ?>