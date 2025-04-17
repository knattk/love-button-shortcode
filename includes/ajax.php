<?php
// inc/ajax.php

// Handle AJAX request to update love count
function update_love_count() {
    $post_id = intval($_POST['post_id']);
    if (!$post_id) {
        wp_send_json_error('Invalid post ID');
    }
    
    $love_count = get_post_meta($post_id, 'love_count', true);
    $love_count = $love_count ? $love_count + 1 : 1;
    update_post_meta($post_id, 'love_count', $love_count);
    
    wp_send_json_success($love_count);
}
add_action('wp_ajax_nopriv_update_love_count', 'update_love_count');
add_action('wp_ajax_update_love_count', 'update_love_count');
