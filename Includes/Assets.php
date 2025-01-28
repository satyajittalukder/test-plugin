<?php

namespace UserTestPlugin;

use UserTestPlugin\Traits\Singleton;

if (! defined('ABSPATH')) {
  exit;
}


class Assets
{
  // If this file is called directly, abort.

  use Singleton;


  private function __construct()
  {
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    // add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'));
  }

  private $setting_page_hook = 'user-test-plugin';

  /**
   * Add JS scripts to admin.
   *
   * @param string $hook page slug.
   */
  public function admin_enqueue_scripts($hook)
  {
    error_log($hook);
    if ('toplevel_page_' . $this->setting_page_hook === $hook) {
      $settings_file = require USERTEST_PLUGIN_DIR_PATH.'react-src/build/index.asset.php';
      $settings_url = USERTEST_PLUGIN_DIR_URL."react-src/build/index.js";

      // error_log( $settings_file);
      error_log($settings_url);

      error_log("loaded assets");
      wp_enqueue_script(
        'usertest-settings-script',
        $settings_url,
        $settings_file['dependencies'],
        $settings_file['version'],
        true
      );

      wp_localize_script(
        'usertest-settings-script',
        'usertestAdmin',
        array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'nonce'    => wp_create_nonce('usertest_ajax_nonce'),
        )
      );
    }
  }
}
?>