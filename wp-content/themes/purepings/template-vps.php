<?php
/*
Template Name: VPS Hosting Template
*/
?>

<?php get_template_part('templates/page', 'header'); ?>
<main class="main <?php echo roots_main_class(); ?>" role="main">
    <div class="main-bg">
        <?php get_template_part('templates/content', 'page'); ?>
        <?php
        $key = '_vpshosting_checkbox';
        $features = new WP_Query(
            array(
                'post_type' => 'feature',
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'features_text_order',
                'meta_query' => array(
                    array(
                        'key' => 'features'.$key,
                        'value' => 'on',
                        'compare' => '='
                    )
                ),
                'nopaging' => true
            )
        );
        if($features->have_posts()) {
            $leftColumn = [];
            $rightColumn = [];
            $i = 0;
            ?>
	        <div class="clear">
	            <h2><?php echo get_option('purepings_sidebarfeatures'); ?></h2>
	            <div class="row">
	                <?php
	                while($features->have_posts()): $features->the_post();
	                    $html = do_shortcode('[feature
	                            wrap="false"
	                            icon="' . get_post_meta(get_the_ID(),'features_icon',true) . '"
	                            title="' . get_the_title() . '"][/feature]');

	                    if($i % 2 == 0){
	                        array_push($leftColumn,$html);
	                    } else {
	                        array_push($rightColumn,$html);
	                    }
	                    $i++;
	                endwhile;
	                wp_reset_query(); ?>
	                <div class="col-xs-12 col-sm-6">
	                    <?php
	                    foreach($leftColumn as $item){
	                        echo $item;
	                    }
	                    ?>
	                </div>
	                <div class="col-xs-12 col-sm-6">
	                    <?php
	                    foreach($rightColumn as $item){
	                        echo $item;
	                    }
	                    ?>
	                </div>
                </div>
            </div>
        <?php
        }

        $faqs = new WP_Query(
            array(
                'post_type' => 'faq',
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'faqs_text_order',
                'meta_query' => array(
                    array(
                        'key' => 'faqs'.$key,
                        'value' => 'on',
                        'compare' => '='
                    )
                ),
                'nopaging' => true
            )
        );
        if($faqs->have_posts()) {
            $leftColumn = [];
            $rightColumn = [];
            $i = 0;
            ?>
	        <div class="clear">
	            <h2><?php echo get_option('purepings_contentfaq'); ?>
	                <small class="hidden-xs pull-right">Don't see your question? <a href="<?php echo get_option('purepings_contentfaqcontactus'); ?>">Contact Us</a>.</small>
	            </h2>
	            <div class="row">

	                <?php
	                while ($faqs->have_posts()): $faqs->the_post();
	                    $html = do_shortcode('[faq title="' . get_the_title() . '"]' . get_the_content() . '[/faq]');

	                    if($i % 2 == 0){
	                        array_push($leftColumn,$html);
	                    } else {
	                        array_push($rightColumn,$html);
	                    }

	                    $i++;
	                endwhile;
	                wp_reset_query();
	                ?>
	                <div class="col-xs-12 col-sm-6">
	                    <?php
	                    foreach($leftColumn as $item){
	                        echo $item;
	                    }
	                    ?>
	                </div>
	                <div class="col-xs-12 col-sm-6">
	                    <?php
	                    foreach($rightColumn as $item){
	                        echo $item;
	                    }
	                    ?>
	                </div>
	            </div>
		        <div class="visible-xs row">
			        <div class="col-xs-12 center">
			            <small>Don't see your question? <a href="<?php echo get_option('purepings_contentfaqcontactus'); ?>">Contact Us</a>.</small>
			        </div>
		        </div>
	        </div>
        <?php } ?>
    </div>
</main>