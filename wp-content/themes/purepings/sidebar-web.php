<div class="sidebar">
    <div class="sidebar-bg">
        <?php
        $locations = new WP_Query(
            array(
                'post_type' => 'location',
                'meta_key' => 'location_webhosting_checkbox',
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
        <div id="secondary-sidebar" class="secondary-sidebar widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-secondary'); ?>
        </div>
        <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-primary'); ?>
        </div>
    </div>
</div>
<?php get_template_part('templates/sidebar-support'); ?>