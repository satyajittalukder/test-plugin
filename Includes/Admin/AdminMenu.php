<?php

namespace UserTestPlugin\Admin;

use UserTestPlugin\Traits\Singleton;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add admin menus inside this class.
 */
class AdminMenu {

	use Singleton;

	/**
	 * Constructor of Admin_Menu class.
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
	}

	/**
	 * Register a custom menu page.
	 */
	public function register_admin_menu() {
		add_menu_page(
			__( 'UserTest', 'user-test-plugin' ),
			__( 'UserTest', 'user-test-plugin' ),
			'manage_options',
			'user-test-plugin',
			array( $this, 'dashboard_callback' ),
			'',
			58
		);

	}

	/**
	 * Display settings page content.
	 */
	public function dashboard_callback() {
		echo '<div class="wrap"><div id="user-test-setings"></div></div>';
	}

}
