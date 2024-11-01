<?php
/**
 * Plugin Name: Sleek Author Box
 * Description: Sleek author box is a fully responsive author box plugin with 40+ social media icons and supports dark mode.
 * Version:     1.0.0
 * Author:      Kantbtrue
 * Author URI:  https://twitter.com/kantbtrue
 * Text Domain: sleek-author-box
 * Domain Path: languages
 */

// If direct access this file, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin constants.
define( 'SLEEK_AUTHOR_BOX_FILE', __FILE__ );
define( 'SLEEK_AUTHOR_BOX_URL', plugin_dir_url( SLEEK_AUTHOR_BOX_FILE ) );
define( 'SLEEK_AUTHOR_BOX_PATH', plugin_dir_path( SLEEK_AUTHOR_BOX_FILE ) );
define( 'SLEEK_AUTHOR_BOX_VERSION', '1.0.0' );

// Plugin default settings.
add_option(
	'sleek_author_box_settings',
	array(
		'position'   => 'below', // above or below the post.
		'post_types' => array( 'post' ), // Post types to display the author box.
		'skin_type'  => 'default',
		'icon_pack'  => 'default',
	)
);

// On plugin activation.
require SLEEK_AUTHOR_BOX_PATH . 'inc/activate.php';
register_activation_hook( __FILE__, 'sleek_author_box_activate' );

/**
 * Run plugin.
 */
function run_sleek_author_box() {
	// Load core plugin files.
	include_once SLEEK_AUTHOR_BOX_PATH . 'inc/sleek-author-box-helper-trait.php';
	include_once SLEEK_AUTHOR_BOX_PATH . 'inc/class-sleek-author-box.php';

	// Instantiate plugin class.
	$sleek_author_box = new Sleek_Author_Box();
	$sleek_author_box->run();
}

run_sleek_author_box();
