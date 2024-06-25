<?php
/*
Plugin Name: Hosting Settings
Description: Allows store customers to manage their domain, SSL status, and other hosting settings.
Version: 1.0.0
Author: J Hanlon
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants.
define('MHSP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MHSP_PLUGIN_URL', plugin_dir_url(__FILE__));
if(!empty(WP_ENVIRONMENT_TYPE) && WP_ENVIRONMENT_TYPE === 'local'){
    define('MHSP_API_URL', 'http://localhost:3000/api');
} else {
    define('MHSP_API_URL', 'https://wpmt.wptooljunkie.com/api');
}

// Include necessary files.
require_once MHSP_PLUGIN_DIR . 'admin/class-admin-settings-page.php';
require_once MHSP_PLUGIN_DIR . 'core/class-domain-settings.php';
require_once MHSP_PLUGIN_DIR . 'core/class-ssl-status.php';
require_once MHSP_PLUGIN_DIR . 'core/class-subscription-details.php';
require_once MHSP_PLUGIN_DIR . 'core/class-general-settings.php';
require_once MHSP_PLUGIN_DIR . 'security/class-data-validation.php';
require_once MHSP_PLUGIN_DIR . 'security/class-access-control.php';
require_once MHSP_PLUGIN_DIR . 'utils/class-helper-functions.php';
require_once MHSP_PLUGIN_DIR . 'utils/class-api.php';
require_once MHSP_PLUGIN_DIR . 'core/class-suspend-site.php';

// Autoload classes using PSR-4 standard
spl_autoload_register(function ($class) {
    $prefix = 'MHSP\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Initialize the plugin.
function mhsp_init() {
    // Initialize admin settings page.
    if (is_admin()) {
        new MHSP\Admin\Admin_Settings_Page();
    }
    
    // Initialize other components as needed.
    new MHSP\Core\Domain_Settings();
    new MHSP\Core\SSL_Status();
    new MHSP\Core\Subscription_Details();
    new MHSP\Core\General_Settings();
    new MHSP\Core\Suspend_Site();

}
add_action('plugins_loaded', 'mhsp_init');
