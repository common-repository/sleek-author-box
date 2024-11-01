<?php
/**
 * Run on WordPress uninstall.
 *
 * @package    Sleek_Author_Box
 * @subpackage Core
 * @since      1.0.0
 * @version    1.0.0
 * @author     kantbtrue
 * @license    GPL-2.0-or-later
 */

// If this file not called by WordPress, abort.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

delete_option( 'sleek_author_box_settings' );
delete_site_option( 'sleek_author_box_settings' );
