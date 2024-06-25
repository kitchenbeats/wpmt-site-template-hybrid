<?php

namespace MHSP\Core;

use MHSP\Utils\API;

class Domain_Settings {

    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('update_option_mhsp_custom_domain', array($this, 'update_domain'), 10, 2);
    }

    public function register_settings() {
        register_setting('mhsp_settings_group', 'mhsp_custom_domain', array(
            'sanitize_callback' => array($this, 'sanitize_domain')
        ));
    }

    public function sanitize_domain($domain) {
        // Basic domain validation
        return filter_var($domain, FILTER_SANITIZE_URL);
    }

    public function update_domain($old_value, $new_value) {
        if ($old_value !== $new_value) {
            // Make an API call to update the domain
            $response = API::make_request('/domains/update', 'POST', array(
                'old_domain' => $old_value,
                'new_domain' => $new_value
            ));

            if ($response['success']) {
                update_option('mhsp_domain_update_status', 'Domain updated successfully.');
                add_settings_error(
                    'mhsp_messages',
                    'mhsp_domain_update_success',
                    __($response['message'], 'mhsp'),
                    'success'
                );
            } else {
                // Handle error
                add_settings_error(
                    'mhsp_messages',
                    'mhsp_domain_update_failed',
                    __($response['message'], 'mhsp'),
                    'error'
                );
            }
        }
    }
}

