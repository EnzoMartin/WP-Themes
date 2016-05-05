<?php get_template_part( 'templates/page', 'header' ); ?>
<main class="main <?php echo roots_main_class(); ?>" role="main">
	<div class="main-bg">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post(); ?>
				<article>
					<a href="<?php echo get_permalink() ?>"><h2><?php echo get_the_title() ?></h2></a>
					<p><?php echo get_the_content() ?></p>
					<small><?php get_template_part('templates/entry-meta'); ?></small>
				</article>
		<?php
			endwhile;
		else :
			get_template_part( 'content', 'none' );
		endif;
		?>
	</div>
</main>
