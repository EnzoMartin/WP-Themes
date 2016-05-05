<div class="sidebar">
    <div class="sidebar-bg">
        <div id="games-sidebar" class="games-sidebar widget-area" role="complementary">
            <?php
            $features = new WP_Query(
                array(
                    'post_type' => 'feature',
                    'meta_key' => 'features_text_order',
                    'order' => 'ASC',
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                            'key' => 'features_gameservers_checkbox',
                            'value' => 'on',
                            'compare' => '='
                        )
                    ),
                    'nopaging' => true
                )
            );
            if ( $features->have_posts() ) { ?>
                <div id="locations">
                    <h4><?php echo get_option('purepings_sidebarfeatures'); ?></h4>
                    <ul>
                        <?php
                        while($features->have_posts()): $features->the_post();
                            echo do_shortcode('[feature
                                icon="' . get_post_meta(get_the_ID(),'features_icon',true) . '"
                                link="' . get_the_permalink() . '"
                                title="' . get_the_title() . '"][/feature]');
                        endwhile;
                        ?>
                    </ul>
                </div>
            <?php
            }
            wp_reset_query();
            ?>
        </div>
        <?php
        $locations = new WP_Query(
            array(
                'post_type' => 'location',
                'meta_key' => 'location_gameservers_checkbox',
                'meta_value' => 'on',
                'order' => 'ASC',
                'orderby' => 'title',
                'nopaging' => true
            )
        );
        if ( $locations->have_posts() ) { ?>
            <div id="locations">
                <h4><?php echo get_option('purepings_sidebarlocations'); ?></h4>
                <ul>
                    <?php
                    while($locations->have_posts()): $locations->the_post();
                        echo '<li><a href="' . get_the_permalink() . '"><i class="f16 flag ' . get_post_meta(get_the_ID(),'location_flag',true) . '"></i>' . get_the_title() . '</a></li>';
                    endwhile;
                    ?>
                </ul>
            </div>
        <?php
        }
        wp_reset_query();
        ?>
        <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-primary'); ?>
        </div>
    </div>
</div>
<?php get_template_part('templates/sidebar-support'); ?>