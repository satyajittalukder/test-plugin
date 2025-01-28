<?php
/**
 * Singleton trait.
 *
 * @package WPBP
 */

namespace UserTestPlugin\Traits;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Trait to make a class singleton.
 */
trait Singleton {


	/**
	 * Create object of this class.
	 *
	 * @return self
	 */
	private static $instance;

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	/**
	 * Cloning is forbidden.
	 *
	 * @since 2.1
	 */
	public function __clone() {
		wp_die( 'Cloning is forbidden.' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 2.1
	 */
	public function __wakeup() {
		wp_die( 'Unserializing instances of this class is forbidden.' );
	}
}