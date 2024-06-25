<?php

namespace MHSP\Admin;

class Admin_Settings_Page {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_notices', array($this, 'display_admin_notices'));
    }

    public function add_settings_page() {
        add_options_page(
            'Hosting', // Page title
            'Hosting', // Menu title
            'manage_options',   // Capability
            'hosting-settings', // Menu slug
            array($this, 'render_settings_page'), // Callback function
        );
    }

    public function register_settings() {
        register_setting('mhsp_settings_group', 'mhsp_custom_domain');
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Hosting Settings', 'mhsp'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('mhsp_settings_group');
                do_settings_sections('mhsp_settings_group');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Custom Domain', 'mhsp'); ?></th>
                        <td><input type="text" name="mhsp_custom_domain" value="<?php echo esc_attr(get_option('mhsp_custom_domain')); ?>" /></td>
                    </tr>
                    <!-- Add other settings fields here -->
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function display_admin_notices() {
        $errors = get_settings_errors('mhsp_messages');
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $type = $error['type'] === 'error' ? 'notice-error' : 'notice-success';
                echo '<div class="' . esc_attr($type) . ' notice is-dismissible"><p>' . esc_html($error['message']) . '</p></div>';
            }
        }
    }
}

