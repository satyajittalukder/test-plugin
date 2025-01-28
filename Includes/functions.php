<?php 

if ( ! function_exists( 'sgsb_modules_url' ) ) {
	/**
	 * Get Modules url.
	 *
	 * @param string $path Module internal path.
	 */
	function sgsb_modules_url( $path ) {
		return USERTEST_PLUGIN_DIR_URL . 'Includes/Modules/' . $path;
	}
}

if ( ! function_exists( 'sgsb_modules_path' ) ) {
	/**
	 * Get Modules path.
	 *
	 * @param string $path Module internal path.
	 */
	function sgsb_react_src_path( $path ) {
		return USERTEST_PLUGIN_DIR_PATH . 'Includes/Modules/' . $path;
	}
}

?>