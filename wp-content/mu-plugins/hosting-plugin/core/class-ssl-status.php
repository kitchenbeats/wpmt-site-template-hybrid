<?php

namespace MHSP\Core;

class SSL_Status {

    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_ssl_status_section'));
    }

    public function register_settings() {
        register_setting('mhsp_settings_group', 'mhsp_ssl_status', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
    }

    public function add_ssl_status_section() {
        add_settings_section(
            'mhsp_ssl_status_section', 
            __('SSL Status', 'mhsp'), 
            array($this, 'render_ssl_status_section'), 
            'mhsp_settings_group'
        );
    }

    public function render_ssl_status_section() {
        $ssl_status = get_option('mhsp_ssl_status', 'Unknown');
        echo '<p>' . sprintf(__('Current SSL Status: %s', 'mhsp'), esc_html($ssl_status)) . '</p>';
    }
}

