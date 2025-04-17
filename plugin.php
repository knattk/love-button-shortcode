<?php
/**
 * Plugin Name: Love Button for Posts
 * Description: Adds a love button to WordPress posts that visitors can click without logging in.
 * Version: 1.0.1
 * Author: khwaaan.com
 * Text Domain: love-button-shortcode
 */

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax.php';
require_once plugin_dir_path(__FILE__) . 'includes/generator.php';
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';

// Enqueue scripts and styles
function love_button_enqueue_scripts_styles() {
    wp_enqueue_script('love-button-script', plugin_dir_url(__FILE__) . 'assets/love-button.js', array('jquery'), null, true);
    wp_localize_script('love-button-script', 'loveButtonAjax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
    wp_enqueue_style('love-button-style', plugin_dir_url(__FILE__) . 'assets/love-button.css');
}
add_action('wp_enqueue_scripts', 'love_button_enqueue_scripts_styles');