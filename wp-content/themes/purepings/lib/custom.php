<?php

function admin(){
    wp_enqueue_script('admin', get_template_directory_uri() . '/assets/js/admin/admin.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'admin');


function afn_customize_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'afn_customize_excerpt_more');

// [order_btn url="http://google.com/"]Order Now[/order_btn]
function orderBtn( $atts, $content = 'Order Now' ) {
    $values = shortcode_atts( array(
        'url' => '#'
    ), $atts );

    return '<a class="btn btn-order" href="' . $values['url'] .'">' . $content . '</a>';
}
add_shortcode( 'order_btn', 'orderBtn' );

// [info_btn url="http://google.com/"]Order Now[/info_btn]
function infoBtn( $atts, $content = 'LEARN MORE' ) {
    $values = shortcode_atts( array(
        'url' => '#'
    ), $atts );

    return '<a class="btn btn-info" href="' . $values['url'] .'">' . $content . '</a>';
}
add_shortcode( 'info_btn', 'infoBtn' );

// [homebox icon="fa-gear" title="Heading" url="http://google.com/"]Some text to display[/homebox]
function homeBox( $atts, $content = '' ) {
    $values = shortcode_atts( array(
        'title' => '',
        'icon' => 'fa-gear',
        'url' => ''
    ), $atts );

    return '<div class="col-xs-6 col-md-3">
        <div class="home-box panel panel-default">
            <a href="' . $values['url'] . '" class="panel-heading">
                <h3 class="panel-title">' . $values['title'] . '<i class="hidden-xs pull-right fa ' . $values['icon'] . '"></i></h3>
            </a>
            <div class="panel-body">' . $content . '</div>
            <div class="panel-footer">
                <a href="' . $values['url'] . '">Learn More Information</a>
                <a class="side-arrow" href="' . $values['url'] . '"><i class="fa fa-mail-forward"></i></a>
            </div>
        </div>
    </div>';
}
add_shortcode( 'homebox', 'homeBox' );

// [row]
function makeRow( $atts, $content = '') {
    return '<div class="row">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'row', 'makeRow' );

// [banner title="Mumble Voice Servers" count="1" caption="Prices start at blah" link="http://google.com" image="http://blahlblahlhah.com"]
function makeBanner( $atts ) {
    $values = shortcode_atts( array(
        'title' => '',
        'image' => '',
        'count' => '1',
	    'button' => 'Order your server',
        'caption' => '',
        'link' => ''
    ), $atts );

    $banner = '<div class="banner" style="background-image: url(' . $values['image'] . ')">
        <a href="' . $values['link'] . '" class="bg-link"></a>
        <div class="bottom">
            <a href="' . $values['link'] . '">
	            <div class="heading pull-left">
	                <h2>' . $values['title'] . '</h2>
	            </div>
            </a>
            <div class="subheading">
                <a href="' . $values['link'] . '">
                    <h3 class="pull-left hidden-xs">' .  $values['caption'] . '</h3>
                </a>';

    $out = '</div>
        </div>
    </div>';

    if($values['count'] == '1'){
        $button = '<a href="' . $values['link'] . '" class="btn btn-order pull-right">' . $values['button'] . '</a>';
        $html = '<div class="col-xs-12">' . $banner . $button . $out . '</div>';
    } else {
        $button = '<a href="' . $values['link'] . '" class="btn btn-order btn-half pull-right"><i class="fa fa-mail-forward"></i></a>';
        $html = '<div class="col-xs-12 col-sm-6">' . $banner . $button . $out . '</div>';
    }

    return $html;
}
add_shortcode( 'banner', 'makeBanner' );


// [image url=""]
function makeInternalBanner( $atts ) {
    $values = shortcode_atts( array(
        'url' => ''
    ), $atts );

    return '<div class="banner" style="background-image: url(' . $values['url'] . ')"></div>';
}
add_shortcode( 'image', 'makeInternalBanner' );


// [icon name="fa-gear"]
function makeIcon( $atts ) {
    $values = shortcode_atts( array(
        'name' => 'fa-gear'
    ), $atts );

    return '<i class="fa ' . $values['name'] . '" ></i>';
}
add_shortcode( 'icon', 'makeIcon' );


// [homefeature icon="fa-cog" title="Headline"]Content[/homefeature]
function makeHomeFeature( $atts, $content = '' ) {
    $values = shortcode_atts( array(
        'icon' => 'fa-cog',
        'wrap' => false,
        'title' => ''
    ), $atts );

    return '<div class="col-xs-12 col-sm-6 col-lg-4">' . featureBox($values,$content) . '</div>';
}
add_shortcode( 'homefeature', 'makeHomeFeature' );

// [feature icon="fa-cog" title="Headline" wrap="false"]Content[/feature]
function featureBox( $atts, $content = ''){
    $values = shortcode_atts( array(
        'icon' => 'fa-cog',
        'wrap' => 'true',
	    'link' => false,
        'title' => ''
    ), $atts );

	$classes = $content == ''? 'single' : '';
    $html = '<div class="feature-box ' . $classes . '">';

	if($values['link']){
		$html .= '<a href="' .  $values['link'] . '">';
	}

	$html .=       '<div class="icon pull-left">
	                    <div class="icon-bg"><i class="fa ' . $values['icon'] . '"></i></div>
	                </div>
	                <div class="text">' .
                        (($values['title'] != '')? '<h4>'. $values['title'] . '</h4>' : '') . '<p>'. $content . '</p>
                    </div>';

	if($values['link']){
		$html .= '</a>';
	}

    $html .=   '</div>';

    if($values['wrap'] == true){
        $html = '<div class="feature-box-wpr col-xs-6">' . $html . '</div>';
    }


    return $html;
}
add_shortcode( 'feature', 'featureBox' );

// [faq title="Headline"]Content[/faq]
function faqBox( $atts, $content = ''){
    $id = str_replace('.','',uniqid('accordion',true));
    $id2 = str_replace('.','',uniqid('collapse',true));

    $values = shortcode_atts( array(
        'title' => 'Item'
    ), $atts );

    return '<div class="faq-item panel-group" id="' . $id . '">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="panel-title collapsed" data-toggle="collapse" data-parent="#' . $id . '" href="#' . $id2 . '">
                            <span>'. $values['title'] . '</span>
                            <span class="fa-stack pull-right">
                                <i class="fa fa-square-o fa-stack-2x"></i>
                                <i class="fa fa-plus fa-stack-1x"></i>
                            </span>
                        </a>
                    </div>
                    <div id="' . $id2 . '" class="panel-collapse collapsed collapse">
                        <div class="panel-body">'. $content . '</div>
                    </div>
                </div>
            </div>';
}
add_shortcode( 'faq', 'faqBox' );

add_filter('widget_text', 'do_shortcode');

// Register Game Post Type
if ( ! function_exists('custom_games') ) {
    function custom_games() {
        $labels = array(
            'name'                => _x( 'Games', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Game', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Games', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Games', 'text_domain' ),
            'view_item'           => __( 'View Game', 'text_domain' ),
            'add_new_item'        => __( 'Add New Game', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Game', 'text_domain' ),
            'update_item'         => __( 'Update Game', 'text_domain' ),
            'search_items'        => __( 'Search Games', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'game', 'text_domain' ),
            'description'         => __( 'A game', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'game' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-desktop',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => array('slug' => 'game-servers', 'with_front' => false, 'pages' => false, 'feeds' => false),
            'capability_type'     => 'page',
        );
        register_post_type( 'game', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_games', 0 );
}

// Register Voice Post Type
if ( ! function_exists('custom_voice') ) {
    function custom_voice() {
        $labels = array(
            'name'                => _x( 'Voice Servers', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Voice Server', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Voice Servers', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Voice Servers', 'text_domain' ),
            'view_item'           => __( 'View Voice Server', 'text_domain' ),
            'add_new_item'        => __( 'Add New Voice Server', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Voice Server', 'text_domain' ),
            'update_item'         => __( 'Update Voice Server', 'text_domain' ),
            'search_items'        => __( 'Search Voice Servers', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'voice', 'text_domain' ),
            'description'         => __( 'A voice server', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'voice' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-megaphone',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => array('slug' => 'voice-servers', 'with_front' => false, 'pages' => false, 'feeds' => false),
            'capability_type'     => 'page',
        );
        register_post_type( 'voice', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_voice', 0 );
}

// Register FAQ Post Type
if ( ! function_exists('custom_faq') ) {
    function custom_faq() {
        $labels = array(
            'name'                => _x( 'FAQs', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'FAQs', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All FAQs', 'text_domain' ),
            'view_item'           => __( 'View FAQ', 'text_domain' ),
            'add_new_item'        => __( 'Add New FAQ', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit FAQ', 'text_domain' ),
            'update_item'         => __( 'Update FAQ', 'text_domain' ),
            'search_items'        => __( 'Search FAQs', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'faq', 'text_domain' ),
            'description'         => __( 'A FAQ', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'faq' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-list-view',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( 'faq', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_faq', 0 );
}

// Register Location Post Type
if ( ! function_exists('custom_locations') ) {
    function custom_locations() {
        $labels = array(
            'name'                => _x( 'Locations', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Locations', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Locations', 'text_domain' ),
            'view_item'           => __( 'View Location', 'text_domain' ),
            'add_new_item'        => __( 'Add New Location', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Location', 'text_domain' ),
            'update_item'         => __( 'Update Location', 'text_domain' ),
            'search_items'        => __( 'Search Locations', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'location', 'text_domain' ),
            'description'         => __( 'A location', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'location' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-location-alt',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( 'location', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_locations', 0 );
}

// Register Feature Post Type
if ( ! function_exists('custom_features') ) {
    function custom_features() {
        $labels = array(
            'name'                => _x( 'Features', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Feature', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Features', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Features', 'text_domain' ),
            'view_item'           => __( 'View Feature', 'text_domain' ),
            'add_new_item'        => __( 'Add New Feature', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Feature', 'text_domain' ),
            'update_item'         => __( 'Update Feature', 'text_domain' ),
            'search_items'        => __( 'Search Features', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'feature', 'text_domain' ),
            'description'         => __( 'A feature', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'feature' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-exerpt-view',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( 'feature', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_features', 0 );
}

// Register Banner Post Type
if ( ! function_exists('custom_banners') ) {
    function custom_banners() {
        $labels = array(
            'name'                => _x( 'Banners', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Banner', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Banners', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Banners', 'text_domain' ),
            'view_item'           => __( 'View Banner', 'text_domain' ),
            'add_new_item'        => __( 'Add New Banner', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Banner', 'text_domain' ),
            'update_item'         => __( 'Update Banner', 'text_domain' ),
            'search_items'        => __( 'Search Banners', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'banner', 'text_domain' ),
            'description'         => __( 'A banner', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'banner' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-images-alt',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'banner', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_banners', 0 );
}


function addStyles(){
    add_editor_style( 'assets/css/styles.min.css' );
}
add_action( 'init', 'addStyles', 0 );

function adminStyles(){
    wp_enqueue_style('customadmin', get_template_directory_uri() . '/assets/css/admin.min.css');
}

add_action('admin_head', 'adminStyles');


// Options Page Functions

function themeoptions_admin_menu()
{
    // here's where we add our theme options page link to the dashboard sidebar
    add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'themeoptions_page');
}

function themeoptions_update()
{
    $_POST = array_map('stripslashes_deep', $_POST);

    // this is where validation would go
    foreach($_POST as $name => $value) {
        update_option('purepings_'.$name, $value);
    }
}

function themeoptions_page()
{
    if ($_POST && $_POST['update_themeoptions'] == 'true' ) { themeoptions_update(); }
    // here's the main function that will generate our options page
    ?>
    <div class="wrap">
        <div id="icon-themes" class="icon32"><br /></div>
        <h2>Theme Options</h2>
        <form id="custom-options" method="POST" action="">
            <input type="hidden" name="update_themeoptions" value="true" />
            <h3>Header</h3>
            <p>Sites in the log in dropdown (format: http://url.com/login.aspx|Site name|Username field name|Password field name):<br/>
            <textarea name="headerloginsites" id="headerloginsites"><?php echo get_option('purepings_headerloginsites'); ?></textarea></p>
            <h3>Content</h3>
            <p><input type="text" name="contentfaq" id="contentfaq" value="<?php echo get_option('purepings_contentfaq'); ?>"/> Heading for FAQs</p>
            <p><input type="text" name="contentfaqcontactus" id="contentfaqcontactus" value="<?php echo get_option('purepings_contentfaqcontactus'); ?>"/> URL for the "Contact Us" link in FAQ title</p>
            <p><input type="text" name="contentdescription" id="contentdescription" value="<?php echo get_option('purepings_contentdescription'); ?>"/> Heading for Description (Game detail page only)</p>
            <p><input type="text" name="contentadditional" id="contentadditional" value="<?php echo get_option('purepings_contentadditional'); ?>"/> Heading for Additional Info (Game detail page only)</p>
            <p><input type="text" name="contentgames" id="contentgames" value="<?php echo get_option('purepings_contentgames'); ?>"/> Heading for All Games Servers (Game List page only)</p>
            <p><input type="text" name="contentgamessubheading" id="contentgamessubheading" value="<?php echo get_option('purepings_contentgamessubheading'); ?>"/> Small heading text for All Game Servers (Game List page only)</p>
            <h3>Homepage</h3>
            <p><input type="text" name="homeadvantages" id="homeadvantages" value="<?php echo get_option('purepings_homeadvantages'); ?>"/> Heading for Advantages</p>
            <p><input type="text" name="homeadvantagescaption" id="homeadvantagescaption" value="<?php echo get_option('purepings_homeadvantagescaption'); ?>"/> Subheading for Advantages</p>
            <p><input type="text" name="homenewsheading" id="homenewsheading" value="<?php echo get_option('purepings_homenewsheading'); ?>"/> Heading for News</p>
            <p><input type="text" name="homenewscaption" id="homenewscaption" value="<?php echo get_option('purepings_homenewscaption'); ?>"/> Subheading for News</p>
            <h3>Sidebar</h3>
            <p><input type="text" name="sidebarfeatures" id="sidebarfeatures" value="<?php echo get_option('purepings_sidebarfeatures'); ?>"/> Heading for server features</p>
            <p><input type="text" name="sidebarlocations" id="sidebarlocations" value="<?php echo get_option('purepings_sidebarlocations'); ?>"/> Heading for server locations</p>
            <p><input type="text" name="sidebarheading" id="sidebarheading" value="<?php echo get_option('purepings_sidebarheading'); ?>"/> Top Text</p>
            <p><input type="text" name="sidebarsubheading" id="sidebarsubheading" value="<?php echo get_option('purepings_sidebarsubheading'); ?>"/> Bottom Text</p>
            <p><input type="text" name="sidebarurl" id="sidebarurl" value="<?php echo get_option('purepings_sidebarurl'); ?>"/> Button URL</p>
            <p><input type="text" name="sidebarurltext" id="sidebarurltext" value="<?php echo get_option('purepings_sidebarurltext'); ?>"/> Button Text</p>
            <hr/>
            <h3>Bottom Banner</h3>
            <p><input type="text" name="bannerheading" id="bannerheading" value="<?php echo get_option('purepings_bannerheading'); ?>"/> Top Text</p>
            <p><input type="text" name="bannersubheading" id="bannersubheading" value="<?php echo get_option('purepings_bannersubheading'); ?>"/> Bottom Text</p>
            <p><input type="text" name="bannerurl" id="bannerurl" value="<?php echo get_option('purepings_bannerurl'); ?>"/> Button URL</p>
            <p><input type="text" name="bannerurltext" id="bannerurltext" value="<?php echo get_option('purepings_bannerurltext'); ?>"/> Button Text</p>
            <p><input type="submit" name="search" value="Update Options" class="button" /></p>
        </form>
    </div>
<?php
}



add_action('admin_menu', 'themeoptions_admin_menu');