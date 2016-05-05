<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php eo_get_template_part('event-meta','event-single'); ?>
		<?php the_content(); ?>
	</div>
	</article>
<?php endwhile; ?>