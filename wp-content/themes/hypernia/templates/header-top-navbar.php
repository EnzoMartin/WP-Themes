<header class="banner navbar navbar-default navbar-static-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hidden-sm" href="<?php echo home_url(); ?>/"><img alt="Hypernia - The Game Hosting Specialists" src="<?php bloginfo('template_directory'); ?>/assets/img/logo.jpg"/></a>
        </div>

        <nav class="collapse navbar-collapse" role="navigation">
            <?php
            if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
            endif;
            ?>
            <ul class="nav navbar-nav navbar-right">
	            <li class="visible-xs">
		            <table class="table">
			            <tr>
				            <td class="center">
					            <a target="_blank" href="<?php echo get_option('hypernia_headerfacebook'); ?>">
									<i class="fa fa-facebook"></i> Facebook
				                </a>
				            </td>
				            <td class="center">
					            <a target="_blank" href="<?php echo get_option('hypernia_headertwitter'); ?>">
									<i class="fa fa-twitter"></i> Twitter
				                </a>
				            </td>
			            </tr>
		            </table>
	            </li>
                <li class="hidden-xs">
	                <a target="_blank" href="<?php echo get_option('hypernia_headerfacebook'); ?>">
						<i class="fa fa-facebook"></i>
	                </a>
                </li>
	            <li class="hidden-xs">
	                <a target="_blank" href="<?php echo get_option('hypernia_headertwitter'); ?>">
						<i class="fa fa-twitter"></i>
	                </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<header class="ribbon">
	<div class="background">
		<div class="orange"></div>
		<div class="grey"></div>
	</div>
	<div class="content container">
		<div class="row">
			<div class="col-xs-12">
				<?php
				if(is_front_page() || get_the_title() == 'Customers'){
				?>
					<div class="orange">
						<div class="corner corner-left"></div>
						<?php echo get_option('hypernia_headerclients'); ?>
						<div class="corner corner-right"></div>
					</div>
					<div class="grey">
						<div class="corner corner-left"></div>
						<div id="client-logos">
							<table id="slides">
								<tr>
									<?php
						            $logos = new WP_Query(
						                array(
						                    'post_type' => 'client',
						                    'order' => 'ASC',
						                    'orderby' => 'title',
						                    'nopaging' => true
						                )
						            );

									$i = 0;
									$hasNext = true;
						            while($hasNext): $logos->the_post();
							            $hasNext = $logos->have_posts();
							            $title = get_the_title();
							            $id = get_post_thumbnail_id();
							            $meta = wp_get_attachment_metadata($id,true);
							            $image = wp_get_attachment_url($id, 'single-post-thumbnail');
							            //$href = get_the_permalink();
							            $href = 'customers';
							            echo '<td><a href="' . $href . '" class="client-logo" title="' . $title . '" style="width:' . $meta['width'] .'px;height:' . ($meta['height'] / 2) .'px;background-image:url(' . $image .');"></a></td>';
						                $i++;
						            endwhile;
						            wp_reset_query();
						            ?>
								</tr>
							</table>
						</div>
						<div class="corner corner-right"></div>
					</div>
				<?php } else { ?>
					<div class="orange">
						<div class="corner corner-left"></div>
						<div class="corner corner-right"></div>
					</div>
					<div class="grey">
						<div class="corner corner-left"></div>
						<?php echo roots_title(); ?>
						<div class="corner corner-right"></div>
					</div>
				<?php } ?>
				<?php
				$meta = get_post_meta(get_the_ID());
				if(isset($meta['pages_sub_heading'])){
				?>
					<div id="page-subheading">
						<h2><?php echo $meta['pages_sub_heading'][0]; ?></h2>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</header>