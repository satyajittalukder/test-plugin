<?php

namespace UserTestPlugin;

use UserTestPlugin\Traits\Singleton;
use UserTestPlugin\Admin\AdminMenu;
use UserTestPlugin\Database\UserDatabase;
use UserTestPlugin\Assets;
use UserTestPlugin\AjaxHandler;

class Bootstrap {
    use Singleton;

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        UserDatabase::instance();

        if (is_admin()) {
            $this->init_admin();
        }
        register_activation_hook(USERTEST_PLUGIN_FILE, [__CLASS__, 'onActivate']);
    }

    private function init_admin() {
        Assets::instance();        
        AdminMenu::instance();     
        AjaxHandler::instance();   
    }

    public static function onActivate() {
        UserDatabase::instance()->createTable();
        
        flush_rewrite_rules();
    }
}