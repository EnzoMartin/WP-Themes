<?php
// Add the Meta Box
function logo_meta_box() {
    add_meta_box(
        'logo_meta_box', // $id
        'Extras', // $title
        'show_logo_meta_box', // $callback
        'logo', // $logo
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'logo_meta_box');


// Field Array
$prefix = 'logos_';
$logo_meta_fields = array(
    array(
        'label'=> 'Order',
        'default' => '0',
        'desc'  => 'Number by which to order by',
        'id'    => $prefix.'text_order',
        'type'  => 'text'
    ),
	array(
        'label'=> 'Link',
        'default' => '',
        'desc'  => 'URL logo should go to (otherwise goes to a content page)',
        'id'    => $prefix.'text_link',
        'type'  => 'text'
    )
);

// The Callback
function show_logo_meta_box() {
    global $logo_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="logo_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($logo_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_logo_meta($post_id) {
    global $logo_meta_fields;

    // verify nonce
    if (!isset($_POST['logo_meta_box_nonce']) || !wp_verify_nonce($_POST['logo_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_page', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ($logo_meta_fields as $field) {
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
add_action('save_post', 'save_logo_meta');