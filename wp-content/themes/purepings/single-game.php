<?php get_template_part('templates/page', 'header'); ?>
<main class="main <?php echo roots_main_class(); ?>" role="main">
    <div class="main-bg">
        <?php get_template_part('templates/header', 'game'); ?>
        <h2><?php echo get_option('purepings_contentdescription'); ?>
            <small class="hidden-xs pull-right"><?php echo get_post_meta($post->ID, 'game_date', true); ?></small>
        </h2>
        <?php get_template_part('templates/content', 'page'); ?>
        <?php
        $faqs = get_post_meta($post->ID, 'game_faqs', false);
        if ( !empty($faqs) ) {
            $leftColumn = [];
            $rightColumn = [];
            $i = 0;
            ?>
            <h2><?php echo get_option('purepings_contentfaq'); ?>
                <small class="hidden-xs pull-right">Don't see your question? <a href="<?php echo get_option('purepings_contentfaqcontactus'); ?>">Contact Us</a>.</small>
            </h2>
            <div class="row">
                <?php $faqs = new WP_Query(
                    array(
                        'post_type' => 'faq',
                        'post__in' => $faqs,
                        'order' => 'ASC',
                        'orderby' => 'meta_value_num',
                        'meta_key' => 'faqs_text_order',
                        'nopaging' => true
                    )
                );

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
        <?php }

        $gameInfo = get_post_meta($post->ID, 'game_textarea_info', true);
        if($gameInfo){
            $gameInfo = apply_filters( 'the_content', $gameInfo );
            $gameInfo = str_replace( ']]>', ']]&gt;', $gameInfo );
        ?>
            <h2><?php echo get_option('purepings_contentadditional'); ?></h2>
            <div class="content"><?php echo $gameInfo ?></div>
        <?php } ?>
    </div>
</main>