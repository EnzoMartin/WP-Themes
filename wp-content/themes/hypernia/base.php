<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

<!--[if lt IE 10]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
    browser</a> to improve your experience.', 'roots'); ?>
</div>
<![endif]-->

<div id="purepings-alert" class="alert alert-warning center">
	<div class="container">
        <strong>ATTENTION:</strong> If you’re looking for <strong>Game and Voice Servers</strong>, please <strong><a href="http://purepings.com/">click here</a></strong> to visit our other site <strong><a href="http://purepings.com/">PurePings.com</a></strong> - Thank you!
	</div>
</div>

<?php
do_action('get_header');
get_template_part('templates/header-top-navbar');
$isHome = false;
$bgClass = 'internal';
if(is_front_page()){
	$isHome = true;
	$bgClass = '';
}
?>

<div id="page">
    <div class="wrap container" role="document">
        <div class="row">
	        <div id="page-bg" class="col-xs-12">
		        <div class="content">
	                <?php include roots_template_path(); ?>
		        </div>
	        </div>
        </div>
    </div>
	<?php if($isHome){ ?>
		<div class="container">
			<div class="row">
			    <div class="col-xs-12 separator"></div>
		    </div>
		</div>
		<div class="wrap container container-sm-height">
		    <div id="home-widgets" class="row row-sm-height">
			    <div id="events" class="col-sm-5 col-md-4 col-sm-height home-widget">
				    <h4>UPCOMING <span>EVENTS</span></h4>
				    <?php dynamic_sidebar('upcoming-events'); ?>
			    </div>
			    <div id="news" class="col-sm-7 col-md-8 col-sm-height home-widget">
					<h4>LATEST <span>NEWS</span></h4>
					<?php
					$posts = new WP_Query('showposts=4');
					$hasPosts = $posts -> have_posts();
					if($hasPosts){
					?>
						<ul>
							<?php
							while ($hasPosts) : $posts -> the_post();
								$hasPosts = $posts -> have_posts();
					            $image = get_bloginfo('template_directory') . '/assets/img/base-banner.jpg';
					            if(has_post_thumbnail( $post->ID ) ) {
					                $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
					            }

			                    $title = get_the_title();
			                    $excerpt = get_the_content();
								$link = get_the_permalink();

								$maxChars = 300;
			                    if(strlen($excerpt) > $maxChars) $excerpt = trim(substr($excerpt, 0, $maxChars)).'...';
							?>
									<li>
										<div class="post">
											<div class="text">
												<h3>
													<a href="<?php echo $link; ?>" title="<?php echo esc_attr($title); ?>"><?php echo $title; ?></a>
													<?php get_template_part( 'templates/entry-meta' ); ?>
												</h3>
												<p>
													<?php echo $excerpt; ?>
													<a class="read-more" href="<?php echo $link; ?>">READ MORE <i class="fa fa-chevron-right"></i></a>
												</p>
											</div>
										</div>
									</li>

							<?php endwhile;?>
						</ul>
					<?php
					} else {

					}
					?>
			    </div>
		    </div>
	    </div>
	<?php }?>
</div>

<?php get_template_part('templates/footer'); ?>
</body>
</html>