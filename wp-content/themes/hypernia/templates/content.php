<article <?php post_class(); ?>>
	<header>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<?php get_template_part( 'templates/entry-meta' ); ?>
		</h2>
	</header>
	<div class="entry-summary">
		<?php echo get_the_excerpt() . '...'; ?>
		<a class="read-more" href="<?php echo get_the_permalink(); ?>">READ MORE <i class="fa fa-chevron-right"></i></a>
	</div>
</article>
