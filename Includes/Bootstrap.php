<?php

namespace UserTestPlugin;

use UserTestPlugin\Traits\Singleton;
use UserTestPlugin\Admin\AdminMenu;
use UserTestPlugin\Database\UserDatabase;
use UserTestPlugin\Assets;

class Bootstrap
{

  use Singleton;

  private function __construct()
  {
    // error_log('Bootstrap is working perfectly');
    // $this->load_ajax_classes();
    // $this->load_admin_classes();

    // Load necessary classes
    UserDatabase::instance();
    AdminMenu::instance();
    Assets::instance();
  }

  // private function load_ajax_classes()
  // {
  //   error_log('Loader for ajax');
  // }

  // private function load_admin_classes()
  // {
  //   error_log('Loader for admin class');
  // }
  public static function onActivate()
  {
      UserDatabase::instance()->createTable();
  }
  
}
