<?php
// Add the Meta Box
function game_meta_box() {
    add_meta_box(
        'game_meta_box', // $id
        'Game Details', // $title
        'show_game_meta_box', // $callback
        'game', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'game_meta_box');

$locations = [];
$loop = new WP_Query(array('post_type' => 'location','nopaging' => true));
while($loop->have_posts()): $loop->the_post();
    $value = get_the_ID();
    $location = array (
        'label' => get_the_title(),
        'value' => $value
    );
    $locations[$value] = $location;
endwhile;
wp_reset_query();


$faqs = [];
$loop = new WP_Query(array('post_type' => 'faq','nopaging' => true));
while($loop->have_posts()): $loop->the_post();
    $value = get_the_ID();
    $faq = array (
        'label' => get_the_title(),
        'value' => $value
    );
    $faqs[$value] = $faq;
endwhile;
wp_reset_query();

$features = [];
$loop = new WP_Query(array('post_type' => 'feature','nopaging' => true));
while($loop->have_posts()): $loop->the_post();
    $value = get_the_ID();
    $feature = array (
        'label' => get_the_title(),
        'value' => $value
    );
    $features[$value] = $feature;
endwhile;
wp_reset_query();


// Field Array
$prefix = 'game_';
$game_meta_fields = array(
    array(
        'label'  => 'Banner',
        'desc'  => 'Image to display below the name (MAKE SURE TO CLICK "INSERT INTO POST" and "FULLSIZE" to select the image)',
        'id'    => $prefix.'image',
        'type'  => 'image'
    ),
    array(
        'label'  => 'Icon',
        'desc'  => 'Small icon to show on the Game Server list page (16x16 px)',
        'id'    => $prefix.'icon',
        'type'  => 'image'
    ),
    array(
        'label'=> 'Price',
        'desc'  => 'Price to display on server list page',
        'id'    => $prefix.'text_price',
        'type'  => 'text'
    ),
    array(
        'label'=> 'WHMCS URL',
        'desc'  => 'URL to send the user to when they click on Order',
        'id'    => $prefix.'text_url',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Heading',
        'desc'  => 'Text on bottom left of the banner',
        'id'    => $prefix.'text_heading',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Sub-Heading',
        'desc'  => 'Text on bottom left of the banner, next to the heading',
        'id'    => $prefix.'text_subheading',
        'type'  => 'text'
    ),
    array(
        'label' => 'Release Date',
        'desc'  => 'Game release date ex: Released on 01/20/12',
        'id'    => $prefix.'date',
        'type'  => 'date'
    ),
    array(
        'label'=> 'Locations',
        'desc'  => 'Available locations',
        'id'    => $prefix.'locations',
        'type'  => 'select',
        'options' => $locations
    ),
    array(
        'label'=> 'Features',
        'desc'  => 'Available features',
        'id'    => $prefix.'features',
        'type'  => 'select',
        'options' => $features
    ),
    array(
        'label'=> 'FAQs',
        'desc'  => 'FAQs to display',
        'id'    => $prefix.'faqs',
        'type'  => 'select',
        'options' => $faqs
    ),
    array(
        'label'=> 'Additional Information',
        'desc'  => 'Description box near bottom of page',
        'id'    => $prefix.'textarea_info',
        'type'  => 'wysiwyg'
    ),
);

// The Callback
function show_game_meta_box() {
    global $game_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="game_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($game_meta_fields as $field) {
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
            // textarea
            case 'textarea':
                echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;
            // select
            case 'select':
                $locations = get_post_meta($post->ID, $field['id'], false);
                echo '<select name="'.$field['id'].'[]" id="'.$field['id'].'" multiple="multiple" >';
                foreach ($field['options'] as $option) {
                    $selected = false;
                    foreach($locations as $location){
                        if($location == $option['value']){
                            $selected = true;
                            break;
                        }
                    }
                    echo '<option', $selected ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                }
                echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                break;
            // date
            case 'date':
                echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
			        <br /><span class="description">'.$field['desc'].'</span>';
                break;
            case 'wysiwyg':
                wp_editor( $meta, $field['id'], $settings = array() );
                echo '<span class="description">'.$field['desc'].'</span>';
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
function save_game_meta($post_id) {
    global $game_meta_fields;

    // verify nonce
    if (!isset($_POST['game_meta_box_nonce']) || !wp_verify_nonce($_POST['game_meta_box_nonce'], basename(__FILE__)))
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
    foreach ($game_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($field['id'] == 'game_locations' || $field['id'] == 'game_features' || $field['id'] == 'game_faqs') {
            $new = isset ( $_POST[$field['id']] )  ? $_POST[$field['id']] : array();
            $old = get_post_meta($post_id, $field['id'], false);
            $already = array();
            if ( ! empty($old) ) {
                foreach ($old as $value) {
                    if ( ! in_array($value, $new) ) {
                        // this value was selected, but now it isn't so delete it
                        delete_post_meta($post_id, $field['id'], $value);
                    } else {
                        // this value already saved, we can skip it from saving
                        $already[] = $value;
                    }
                }
            }
            // we don't save what already saved
            $to_save = array_diff($new, $already);
            if ( ! empty($to_save) ) {
                foreach ( $to_save as $location ) {
                    add_post_meta( $post_id, $field['id'], $location);
                }
            }
        //}
        } else {
            if($new == '' && !$old && array_key_exists('default',$field)){
                $new = $field['default'];
            }

            if ($new != '' && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ($new == '' && $old != '') {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    } // end foreach
}
add_action('save_post', 'save_game_meta');