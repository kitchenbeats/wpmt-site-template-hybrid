<?php

namespace MHSP\Core;

class Subscription_Details {

    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_subscription_details_section'));
    }

    public function register_settings() {
        register_setting('mhsp_settings_group', 'mhsp_subscription_details', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
    }

    public function add_subscription_details_section() {
        add_settings_section(
            'mhsp_subscription_details_section', 
            __('Subscription Details', 'mhsp'), 
            array($this, 'render_subscription_details_section'), 
            'mhsp_settings_group'
        );
    }

    public function render_subscription_details_section() {
        $subscription_details = get_option('mhsp_subscription_details', 'Unknown');
        echo '<p>' . sprintf(__('Current Subscription Details: %s', 'mhsp'), esc_html($subscription_details)) . '</p>';
    }
}

