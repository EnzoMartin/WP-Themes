<?php
// Add the Meta Box
function banner_meta_box() {
    add_meta_box(
        'banner_meta_box', // $id
        'Details', // $title
        'show_banner_meta_box', // $callback
        'banner', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'banner_meta_box');


// Field Array
$prefix = 'banners_';
$banner_meta_fields = array(
    array(
        'label'=> 'Order',
        'default' => '0',
        'desc'  => 'Number by which to order by',
        'id'    => $prefix.'text_order',
        'type'  => 'text'
    ),
    array(
        'label'  => 'Banner',
        'desc'  => 'Image to display 1440x430px (MAKE SURE TO CLICK "INSERT INTO POST" and "FULLSIZE" to select the image)',
        'id'    => $prefix.'image',
        'type'  => 'image'
    ),
    array(
        'label'=> 'Subheading',
        'desc'  => 'Subheading to display under the title <em>(optional)</em>',
        'id'    => $prefix.'text_subheading',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Caption',
        'desc'  => 'Caption text to display under the title and subheading <em>(optional)</em>',
        'id'    => $prefix.'text_caption',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Link',
        'desc'  => 'Where the banner should link to <em>(optional)</em>',
        'id'    => $prefix.'text_link',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Link text',
        'desc'  => 'The button\'s text <em>(optional)</em>',
        'id'    => $prefix.'text_link_text',
        'type'  => 'text'
    )
);

// The Callback
function show_banner_meta_box() {
    global $banner_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="banner_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($banner_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
            // image
            case 'image':
                $image = get_template_directory_uri().'/assets/img/placeholder.jpg';
                echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
                if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }
                echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
                    <img src="'.$image.'" class="custom_preview_image" alt="" /><br />
                    <input class="custom_upload_image_button button" type="button" value="Choose Image" />
                    <small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
                    <br clear="all" /><span class="description">'.$field['desc'].'';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_banner_meta($post_id) {
    global $banner_meta_fields;

    // verify nonce
    if (!isset($_POST['banner_meta_box_nonce']) || !wp_verify_nonce($_POST['banner_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ($banner_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if($new == '' && !$old && array_key_exists('default',$field)){
            $new = $field['default'];
        }

        if ($new != '' && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ($new == '' && $old != '') {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_banner_meta');