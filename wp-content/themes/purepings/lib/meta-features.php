<?php
// Add the Meta Box
function feature_meta_box() {
    add_meta_box(
        'feature_meta_box', // $id
        'Details', // $title
        'show_feature_meta_box', // $callback
        'feature', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'feature_meta_box');


// Field Array
$prefix = 'features_';
$feature_meta_fields = array(
    array(
        'label'=> 'Order',
        'desc'  => 'Number by which to order by',
        'default' => '0',
        'id'    => $prefix.'text_order',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Game Servers',
        'desc'  => 'Display this feature in the Game Servers List page sidebar',
        'id'    => $prefix.'gameservers_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Web Servers',
        'desc'  => 'Display this feature in the Web Servers page content',
        'id'    => $prefix.'webhosting_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'VPS Servers',
        'desc'  => 'Display this feature in the VPS Servers page content',
        'id'    => $prefix.'vpshosting_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Voice Servers',
        'desc'  => 'Display this feature in the Voice Servers page content',
        'id'    => $prefix.'voiceservers_checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Feature Icon',
        'desc'  => 'You can use any icon from <a href="http://fortawesome.github.io/Font-Awesome/icons/">FontAwesome</a> ex: fa-coffee',
        'id'    => $prefix.'icon',
        'type'  => 'text'
    )
);

// The Callback
function show_feature_meta_box() {
    global $feature_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="feature_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($feature_meta_fields as $field) {
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
function save_feature_meta($post_id) {
    global $feature_meta_fields;

    // verify nonce
    if (!isset($_POST['feature_meta_box_nonce']) || !wp_verify_nonce($_POST['feature_meta_box_nonce'], basename(__FILE__)))
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
    foreach ($feature_meta_fields as $field) {
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
add_action('save_post', 'save_feature_meta');