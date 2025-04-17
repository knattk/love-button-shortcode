<?php
// inc/love-count.php

function generate_init_number() {
    // Get the user-defined min and max values, or use default values if not set
    $min = get_option('love_button_min_random', 200); // Default to 230 if not set
    $max = get_option('love_button_max_random', 500); // Default to 430 if not set

    // Ensure min is less than max
    if ($min >= $max) {
        $min = 200;
        $max = 500;
    }

    return rand($min, $max); // Generate the random number within the range
}

function transition_init($new_status, $old_status, $post) {
    if (!empty($post->ID)) {
        // Only proceed when a post transitions from 'draft' or 'auto-draft' to 'publish'
        if ($new_status === 'publish' && ($old_status === 'draft' || $old_status === 'auto-draft')) {
            $post_id = $post->ID;
    
            // Get current love count
            $love_count = get_post_meta($post_id, 'love_count', true);
            
            // If love count doesn't exist, generate a new one
            if (empty($love_count)) {
                $love_count = generate_init_number();
                $update_success = update_post_meta($post_id, 'love_count', $love_count);
    
                // Optionally, you could log if the update failed
                if (!$update_success) {
                    error_log('Failed to update love count for post ID ' . $post_id);
                }
            }
        }
    }
}

add_action('transition_post_status', 'transition_init', 10, 3);
