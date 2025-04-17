<?php

// Class to handle the Love Button plugin settings
class Love_Button_Settings {

    // Constructor to initialize hooks
    public function __construct() {
        add_action('admin_menu', array($this, 'love_button_settings_page'));
        add_action('admin_init', array($this, 'love_button_register_settings'));
    }

    // Add the settings page under the "Settings" menu
    public function love_button_settings_page() {
        add_options_page(
            'Love Button Settings', // Page title
            'Love Button',          // Menu title
            'manage_options',       // Capability required to access
            'love-button-settings', // Menu slug
            array($this, 'love_button_settings_page_callback') // Callback function
        );
    }

    // Callback function to display the settings page
    public function love_button_settings_page_callback() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                // Output settings fields and security fields
                settings_fields('love_button_options_group');
                do_settings_sections('love-button-settings');
                ?>
                <div> 
                <!-- Shortcode Info Section -->
                    <h2>Use the Love Button Shortcode</h2>
                    <p>Copy and paste the shortcode below into any post, page, or widget to display the Love Button:</p>
                    <input type="text" readonly value="[love-button]" id="love-button-shortcode" class="large-text code" onclick="this.select();" style="max-width: 400px;">
                    <br>
                    <br>
                    <h2>Random number</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="min_random">Minimum Random Number</label></th>
                            <td><input name="love_button_min_random" type="number" id="min_random" value="<?php echo esc_attr(get_option('love_button_min_random', 200)); ?>" placeholder="200" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="max_random">Maximum Random Number</label></th>
                            <td><input name="love_button_max_random" type="number" id="max_random" value="<?php echo esc_attr(get_option('love_button_max_random', 500)); ?>" placeholder="500" class="regular-text" /></td>
                        </tr>
                    </table>
                   

                </div>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    // Register the settings for the plugin
    public function love_button_register_settings() {
        register_setting('love_button_options_group', 'love_button_min_random');
        register_setting('love_button_options_group', 'love_button_max_random');
    }
}

// Initialize the class
new Love_Button_Settings();
