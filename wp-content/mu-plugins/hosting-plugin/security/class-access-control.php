<?php

namespace MHSP\Security;

class Access_Control {

    public function __construct() {
        add_action('admin_init', array($this, 'check_user_permissions'));
    }

    public function check_user_permissions() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
    }
}

