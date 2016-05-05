<?php
// Add the Meta Box
function location_meta_box() {
    add_meta_box(
        'location_meta_box', // $id
        'Details', // $title
        'show_location_meta_box', // $callback
        'location', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'location_meta_box');


// Field Array
$prefix = 'location_';
$location_meta_fields = array(
    array(
        'label'=> 'Game Servers',
        'desc'  => 'Display this location in the Game Servers List page sidebar',
        'id'    => $prefix.'gameservers_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Voice Servers',
        'desc'  => 'Display this location in the Voice Servers List page sidebar',
        'id'    => $prefix.'voiceservers_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'VPS Hosting',
        'desc'  => 'Display this location in the VPS Hosting sidebar',
        'id'    => $prefix.'vpshosting_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Web Hosting',
        'desc'  => 'Display this location in the Web Hosting sidebar',
        'id'    => $prefix.'webhosting_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Flag Icon',
        'desc'  => 'Write the country\'s abbreviation (ex: us, fr, it, gb, etc.)',
        'id'    => $prefix.'flag',
        'type'  => 'text'
    )
);

// The Callback
function show_location_meta_box() {
    global $location_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="location_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($location_meta_fields as $field) {
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
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_location_meta($post_id) {
    global $location_meta_fields;

    // verify nonce
    if (!isset($_POST['location_meta_box_nonce']) || !wp_verify_nonce($_POST['location_meta_box_nonce'], basename(__FILE__)))
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
    foreach ($location_meta_fields as $field) {
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
add_action('save_post', 'save_location_meta');