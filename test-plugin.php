<?php 
/**
 * Plugin Name: Test Plugin
 * Plugin URI: ""
 * Description: A starter plugin for WordPress complete with inline documentation and working admin options page.
 * Author: Satyajit Talukder
 * Version: 1.0
 * Text Domain: starter-plugin
 * Domain Path: /languages
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
use UserTestPlugin\Bootstrap;
use UserTestPlugin\Database\UserDatabase;

defined('ABSPATH') || exit;

// Include the autoloader.
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define plugin __FILE__
 */
if ( ! defined( 'USERTEST_PLUGIN_FILE' ) ) {
	define( 'USERTEST_PLUGIN_FILE', __FILE__ );
}

/**
 * Define plugin directory URL.
 */
if ( ! defined( 'USERTEST_PLUGIN_DIR_URL' ) ) {
	define( 'USERTEST_PLUGIN_DIR_URL', plugin_dir_url( USERTEST_PLUGIN_FILE ) );
}

/**
 * Define plugin directory path.
 */
if ( ! defined( 'USERTEST_PLUGIN_DIR_PATH' ) ) {
	define( 'USERTEST_PLUGIN_DIR_PATH', plugin_dir_path( USERTEST_PLUGIN_FILE ) );
}

 /**
 * Initialize the plugin functionality.
 *
 * @since  1.0.0
 *
 * @return Bootstrap
 */
function ust_plugin(): Bootstrap {
	return Bootstrap::instance();
}

/**
 * Register plugin activation hook.
 */
register_activation_hook(__FILE__, function () {
  Bootstrap::instance()->onActivate();
});

// Call initialization function.
ust_plugin();
?>