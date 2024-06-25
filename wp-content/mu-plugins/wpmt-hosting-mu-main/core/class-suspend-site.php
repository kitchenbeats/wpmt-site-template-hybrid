<?php

namespace MHSP\Core;

class Suspend_Site {

    public function __construct() {
        add_action('template_redirect', [$this, 'check_if_site_suspended']);
        add_action('admin_notices', [$this, 'suspension_admin_notice']);
    }

    public function check_if_site_suspended() {
        if (get_option('site_suspended')) {
            include plugin_dir_path(__FILE__) . 'suspended-template.php';
            exit();
        }
    }

    public function suspension_admin_notice() {
        if (get_option('site_suspended')) {
            echo '<div class="notice notice-error"><p><strong>Warning:</strong> This site is suspended. Visitors will see a suspension page.</p></div>';
        }
    }

    public static function suspend_site() {
        update_option('site_suspended', true);
    }

    public static function unsuspend_site() {
        update_option('site_suspended', false);
    }
}