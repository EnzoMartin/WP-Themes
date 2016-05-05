<div id="content-panels" class="row">
    <?php dynamic_sidebar('home-boxes'); ?>
</div>
<div id="advantages">
    <div class="row">
        <div class="col-xs-12">
            <header>
                <p><?php echo get_option('purepings_homeadvantages'); ?></p>
                <?php echo get_option('purepings_homeadvantagescaption'); ?>
            </header>
        </div>
    </div>
    <?php dynamic_sidebar('home-features'); ?>
</div>
<div id="news">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <header>
                <p><?php echo get_option('purepings_homenewsheading'); ?></p>
                <?php echo get_option('purepings_homenewscaption'); ?>
            </header>
        </div>
        <div class="col-xs-12 col-sm-6 hidden">
            <header class="pull-right">
                <form role="form">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Enter your email for special deals..." />
                    </div>
                </form>
            </header>
        </div>
    </div>
    <div class="row">
        <?php
        $the_query = new WP_Query('showposts=4');

        while ($the_query -> have_posts()) : $the_query -> the_post();
            $image = get_bloginfo('template_directory') . '/assets/img/base-banner.jpg';
            if(has_post_thumbnail( $post->ID ) ) {
                $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
            }
            ?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="<?php the_permalink() ?>"><img src="<?php echo $image; ?>"/></a></div>
                    <div class="panel-body">
	                    <?php
                        $title = get_the_title();
						if(strlen($title) > 25) $title = trim(substr($title, 0, 22)).'...';

                        $excerpt = get_the_content();
                        if(strlen($excerpt) > 270) $excerpt = trim(substr($excerpt, 0, 270)).'...';
	                    ?>
                        <a href="<?php the_permalink() ?>"><h3><?php echo $title; ?></h3></a>
	                    <div class="panel-content"><?php echo $excerpt; ?></div>
                    </div>
                    <div class="panel-footer">
                        <a href="<?php the_permalink() ?>">Read the Full Story</a>
                    </div>
                </div>
            </div>
        <?php endwhile;?>
    </div>
</div>