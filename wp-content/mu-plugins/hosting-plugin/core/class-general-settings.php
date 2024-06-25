<?php

namespace MHSP\Core;

class General_Settings {

    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_general_settings_section'));
    }

    public function register_settings() {
        register_setting('mhsp_settings_group', 'mhsp_general_settings', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
    }

    public function add_general_settings_section() {
        add_settings_section(
            'mhsp_general_settings_section', 
            __('General Settings', 'mhsp'), 
            array($this, 'render_general_settings_section'), 
            'mhsp_settings_group'
        );
    }

    public function render_general_settings_section() {
        $general_settings = get_option('mhsp_general_settings', 'Unknown');
        echo '<p>' . sprintf(__('Current General Settings: %s', 'mhsp'), esc_html($general_settings)) . '</p>';
    }
}

