<?php
// inc/shortcodes.php

// Add the Love Button shortcode
function love_button_shortcode() {
    global $post;
    $post_id = $post->ID;
    $love_count = get_post_meta($post_id, 'love_count', true);
    $love_count = $love_count ? $love_count : 0;
    
    return '<button class="love-button" data-post-id="' . esc_attr($post_id) . '">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M240,102c0,70-103.79,126.66-108.21,129a8,8,0,0,1-7.58,0C119.79,228.66,16,172,16,102A62.07,62.07,0,0,1,78,40c20.65,0,38.73,8.88,50,23.89C139.27,48.88,157.35,40,178,40A62.07,62.07,0,0,1,240,102Z"></path></svg>
                <span class="love-count">' . esc_html($love_count) . '</span>
            </button>';
}
add_shortcode('love_button', 'love_button_shortcode');
