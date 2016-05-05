<?php

function admin(){
    wp_enqueue_script('admin', get_template_directory_uri() . '/assets/js/admin/admin.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'admin');


function afn_customize_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'afn_customize_excerpt_more');

function addStyles(){
    add_editor_style( 'assets/css/styles.min.css' );
}
add_action( 'init', 'addStyles', 0 );

function adminStyles(){
    wp_enqueue_style('customadmin', get_template_directory_uri() . '/assets/css/admin.min.css');
}

add_action('admin_head', 'adminStyles');

// [rule]
function rule(){
    return '
    <div class="rule">
        <div class="wing-wpr">
	        <div class="left wing"></div>
	        <img src="' . get_template_directory_uri() . '/assets/img/rule-logo.jpg"/>
	        <div class="right wing"></div>
        </div>
    </div>';
}
add_shortcode( 'rule', 'rule' );

// [bubble title="Test" url="http://google.com/" image="http://imgur.com/"]Content[/bubble]
function bubble( $atts, $content = ''){
    $values = shortcode_atts( array(
        'title' => false,
	    'url' => false,
	    'image' => false
    ), $atts );

	$title = '';
	if($values['title']){
		$title = '<h3>' . $values['title'] . '</h3>';
	}

	$image = '';
	if($values['image']){
		$image = '<td class="bubble-image">';

		if($values['url']){
			$image .= '<a href="' . $values['url'] . '" target="_blank">';
		}

		$image .= '<img src="' . $values['image'] . '"/>';

		if($values['url']){
			$image .= '</a>';
		}

		$image .= '</td>';
	}

    return '<table class="bubble"><tr>' . $image . '<td class="bubble-wrapper"><div class="bubble-content">' . $title  . '<div class="bubble-text">' . $content . '</div></div></td></tr></table>';
}
add_shortcode( 'bubble', 'bubble' );

// [quote caption="Name of person" image="http://imgur.com/"]Content[/quote]
function quote( $atts, $content = ''){
    $values = shortcode_atts( array(
        'caption' => false,
	    'url' => false,
	    'image' => false
    ), $atts );

	$title = '';
	if($values['caption']){
		$title = '<h6>' . $values['caption'] . '</h6>';
	}

	$image = '';
	if($values['image']){
		$image = '<td class="bubble-image">';

		if($values['url']){
			$image .= '<a href="' . $values['url'] . '" target="_blank">';
		}

		$image .= '<img src="' . $values['image'] . '"/>';

		if($values['url']){
			$image .= '</a>';
		}

		$image .= '</td>';
	}

    return '<table class="bubble quote"><tr>' . $image . '<td class="bubble-wrapper"><div class="bubble-content"><div class="bubble-text"><i class="fa fa-quote-left"></i>' . $content . '<i class="fa fa-quote-right"></i></div></div>' . $title  . '</td></tr></table>';
}
add_shortcode( 'quote', 'quote' );



// Register logo Post Type
if ( ! function_exists('custom_logos') ) {
    function custom_logos() {
        $labels = array(
            'name'                => _x( 'Logos', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Logo', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Logos', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Logo', 'text_domain' ),
            'view_item'           => __( 'View Logo', 'text_domain' ),
            'add_new_item'        => __( 'Add New Logo', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Logo', 'text_domain' ),
            'update_item'         => __( 'Update Logo', 'text_domain' ),
            'search_items'        => __( 'Search Logos', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'Logo', 'text_domain' ),
            'description'         => __( 'A logo', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'logo' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-admin-links',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => array('slug' => 'sites', 'with_front' => false, 'pages' => false, 'feeds' => false),
            'capability_type'     => 'page',
        );
        register_post_type( 'logo', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_logos', 0 );
}

// Register client Post Type
if ( ! function_exists('custom_clients') ) {
    function custom_clients() {
        $labels = array(
            'name'                => _x( 'Clients', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Client', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Clients', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Client', 'text_domain' ),
            'view_item'           => __( 'View Client', 'text_domain' ),
            'add_new_item'        => __( 'Add New Client', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Client', 'text_domain' ),
            'update_item'         => __( 'Update Client', 'text_domain' ),
            'search_items'        => __( 'Search Clients', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'Client', 'text_domain' ),
            'description'         => __( 'A client', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', ),
            'taxonomies'          => array( 'client' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 6,
            'menu_icon'           => 'dashicons-businessman',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => array('slug' => 'client', 'with_front' => false, 'pages' => false, 'feeds' => false),
            'capability_type'     => 'page',
        );
        register_post_type( 'client', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_clients', 0 );
}

function hypernia_styles( $init_array ) {
	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title' => 'Heading 1',
			'items' => array(
				array(
					'title' => 'Normal',
					'selector' => 'h1',
					'classes' => ''
				),
				array(
					'title' => 'Oswald',
					'selector' => 'h1',
					'classes' => 'oswald'
				)
			)
		),
		array(
			'title' => 'Heading 2',
			'items' => array(
				array(
					'title' => 'Normal',
					'selector' => 'h2',
					'classes' => ''
				),
				array(
					'title' => 'Oswald',
					'selector' => 'h2',
					'classes' => 'oswald'
				)
			)
		),
		array(
			'title' => 'Heading 3',
			'items' => array(
				array(
					'title' => 'Normal',
					'selector' => 'h3',
					'classes' => ''
				),
				array(
					'title' => 'Oswald',
					'selector' => 'h3',
					'classes' => 'oswald'
				)
			)
		),
		array(
			'title' => 'Heading 4',
			'items' => array(
				array(
					'title' => 'Normal',
					'selector' => 'h4',
					'classes' => ''
				),
				array(
					'title' => 'Oswald',
					'selector' => 'h4',
					'classes' => 'oswald'
				)
			)
		),
		array(
			'title' => 'Heading 5',
			'items' => array(
				array(
					'title' => 'Normal',
					'selector' => 'h5',
					'classes' => ''
				),
				array(
					'title' => 'Oswald',
					'selector' => 'h5',
					'classes' => 'oswald'
				)
			)
		),
		array(
			'title' => 'Heading 6',
			'items' => array(
				array(
					'title' => 'Normal',
					'selector' => 'h6',
					'classes' => ''
				),
				array(
					'title' => 'Oswald',
					'selector' => 'h6',
					'classes' => 'oswald'
				)
			)
		),
	);

	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;
}

add_filter( 'tiny_mce_before_init', 'hypernia_styles' );

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
        update_option('hypernia_'.$name, $value);
    }
}

// [info_btn url="http://google.com/"]Order Now[/info_btn]
function thumbBox( $atts, $content = false) {
    $values = shortcode_atts( array(
        'title' => false,
        'link' => false
    ), $atts );


	if($content){
		$title = '';
		if($content && $values['link']){
			$title = '<a href="' . $values['url'] . '">' . $title . '</a>';
		}
	}

    return $content . ($values['title'])? '<h6 class="script">' . $values['title'] . '</h6>' : '';
}
add_shortcode( 'image', 'thumbBox' );

add_filter( 'mce_buttons_2', 'fb_mce_editor_buttons' );
function fb_mce_editor_buttons( $buttons ) {

    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter('mce_css', 'editor_style');
function editor_style($url) {
    if ( !empty($url) )
        $url .= ',';

    //$url .= get_bloginfo('template_directory') . '/assets/css/admin.css';
	$url .= get_bloginfo('template_directory') . '/assets/css/styles.min.css';
	return $url;
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
            <h3>General</h3>
            <p><input type="text" name="headerfacebook" id="headerfacebook" value="<?php echo get_option('hypernia_headerfacebook'); ?>"/> URL to link the header "Facebook" button to</p>
            <p><input type="text" name="headertwitter" id="headertwitter" value="<?php echo get_option('hypernia_headertwitter'); ?>"/> URL to link the header "Twitter" button to</p>
            <p><input type="text" name="headerclients" id="headerclients" value="<?php echo get_option('hypernia_headerclients'); ?>"/> Text to display above the Clients ribbon</p>
	        <p><input type="submit" name="search" value="Update Options" class="button" /></p>
        </form>
    </div>
<?php
}



add_action('admin_menu', 'themeoptions_admin_menu');