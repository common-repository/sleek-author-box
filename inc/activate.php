<?php
/**
 * The code that runs during plugin activation.
 *
 * @package    Sleek_Author_Box
 * @subpackage Core
 * @since      1.0.0
 * @version    1.0.0
 * @author     kantbtrue
 * @license    GPL-2.0-or-later
 */

// If direct access this file, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'sleek_author_box_activate' ) ) {
	/**
	 * The code that runs during plugin activation.
	 */
	function sleek_author_box_activate() {
		// Check the WordPress version.
		if ( ! is_wp_version_compatible( '5.8' ) ) {
			wp_die(
				esc_html__( 'To use this plugin, upgrade your WordPress version', 'sleek-author-box' ),
				esc_html__( '500 Error: WordPress Compatibility issue', 'sleek-author-box' ),
				500
			);
		}
	}
}
