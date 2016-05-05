<?php
/**
 * Register sidebars and widgets
 */
function roots_widgets_init()
{
    // Sidebars
	register_sidebar(array(
        'name' => __('Primary Sidebar', 'roots'),
        'id' => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));

	register_sidebar(array(
        'name' => __('Events', 'roots'),
        'id' => 'upcoming-events',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<span class="hidden">',
        'after_title' => '</span>',
    ));

    register_sidebar(array(
        'name' => __('Footer Menus', 'roots'),
        'id' => 'sidebar-footer',
        'before_widget' => '<div class="col-xs-6 col-sm-3 col-md-2">',
        'after_widget' => '</div>',
        'before_title' => '<p class="hidden">',
        'after_title' => '</p>',
    ));
}

add_action('widgets_init', 'roots_widgets_init');