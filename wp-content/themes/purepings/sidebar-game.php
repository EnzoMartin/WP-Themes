<div class="sidebar">
    <div class="sidebar-bg">
        <?php
        $features = get_post_meta($post->ID, 'game_features', false);
        if ( !empty($features) ) { ?>
            <div id="features">
                <h4><?php echo get_option('purepings_sidebarfeatures'); ?></h4>
                <?php
                $features = new WP_Query(
                    array(
                        'post_type' => 'feature',
                        'post__in' => $features,
                        'order' => 'ASC',
                        'orderby' => 'meta_value_num',
                        'meta_key' => 'features_text_order',
                        'nopaging' => true
                    )
                );
                while($features->have_posts()): $features->the_post();
                    echo do_shortcode('[feature
                                icon="' . get_post_meta(get_the_ID(),'features_icon',true) . '"
                                link="' . get_the_permalink() . '"
                                title="' . get_the_title() . '"][/feature]');
                endwhile;
                wp_reset_query();
                ?>
            </div>
        <?php }
        $locations = get_post_meta($post->ID, 'game_locations', false);
        if ( !empty($locations) ) { ?>
            <div id="locations">
                <h4><?php echo get_option('purepings_sidebarlocations'); ?></h4>
                <ul>
                    <?php
                    $locations = new WP_Query(
                        array(
                            'post_type' => 'location',
                            'post__in' => $locations,
                            'order' => 'ASC',
                            'orderby' => 'title',
                            'nopaging' => true
                        )
                    );
                    while($locations->have_posts()): $locations->the_post();
                        echo '<li><a href="' . get_the_permalink() . '"><i class="f16 flag ' . get_post_meta(get_the_ID(),'location_flag',true) . '"></i>' . get_the_title() . '</a></li>';
                    endwhile;
                    wp_reset_query();
                    ?>
                </ul>
            </div>
        <?php } ?>
        <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-primary'); ?>
        </div>
    </div>
</div>
<?php get_template_part('templates/sidebar-support'); ?>