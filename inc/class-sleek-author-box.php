<?php
/**
 * The main plugin class.
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

if ( ! class_exists( 'Sleek_Author_Box' ) ) {
	/**
	 * Core plugin class.
	 */
	class Sleek_Author_Box {


		/**
		 * Plugin unique identifier.
		 *
		 * @var string $plugin_uid The ID of this plugin.
		 */
		protected $plugin_uid;

		/**
		 * Plugin version.
		 *
		 * @var string $version Current version of this plugin.
		 */
		protected $version;

		/**
		 * Author box skin type.
		 *
		 * @var string $skin_type Skin type.
		 */
		protected $skin_type;

		/**
		 * Author box icon pack.
		 *
		 * @var string $icon_pack Icon pack.
		 */
		protected $icon_pack;

		/**
		 * Author box position.
		 *
		 * @var string $positon Position.
		 */
		protected $position;

		/**
		 * List of supported post types.
		 *
		 * @var array $post_types Post types.
		 */
		protected $post_types;

		/**
		 * Helper functions.
		 *
		 * @trait Sleek_Author_Box_Helper
		 */
		use Sleek_Author_Box_Helper;

		/**
		 * Run when class instantiated.
		 *
		 * @uses defined()
		 */
		public function __construct() {

			// Get plugin settings.
			$settings = self::get_options( 'sleek_author_box_settings' );

			// Set plugin uniquie identifier.
			$this->plugin_uid = 'sleek-author-box';

			// Set plugin version.
			if ( defined( 'SLEEK_AUTHOR_BOX_VERSION' ) ) {
				// Plugin version defined in plugin header.
				$this->version = SLEEK_AUTHOR_BOX_VERSION;
			} else {
				$this->version = '1.0.0';
			}

			// Set skin type.
			if ( $settings['skin_type'] ) {
				$this->skin_type = $settings['skin_type'];
			} else {
				$this->skin_type = 'default';
			}

			// Set icon pack.
			if ( $settings['icon_pack'] ) {
				$this->icon_pack = $settings['icon_pack'];
			} else {
				$this->icon_pack = 'default';
			}

			// Set position.
			if ( $settings['position'] ) {
				$this->position = $settings['position'];
			} else {
				$this->position = 'below';
			}

			// Set post types.
			if ( $settings['post_types'] ) {
				$this->post_types = $settings['post_types'];
			} else {
				$this->post_types = array( 'post' );
			}

			// Load plugin dependencies.
			$this->load_dependencies();
		}

		/**
		 * Load plugin dependencies.
		 */
		public function load_dependencies() {
			include_once SLEEK_AUTHOR_BOX_PATH . 'admin/class-sleek-author-box-admin.php';
			include_once SLEEK_AUTHOR_BOX_PATH . 'frontend/class-sleek-author-box-frontend.php';
			include_once SLEEK_AUTHOR_BOX_PATH . 'inc/class-sleek-author-box-templ.php';
		}

		/**
		 * Define admin functionalities.
		 *
		 * @uses add_action()
		 * @uses Sleek_Author_Box_Admin
		 * @uses Sleek_Author_Box_Admin::add_menu_pages()
		 * @uses Sleek_Author_Box_Admin::enqueue_styles_scripts()
		 * @uses Sleek_Author_Box_Admin::custom_fields_user_profile()
		 *
		 * @return bool
		 */
		public function define_admin() {
			if ( ! class_exists( 'Sleek_Author_Box_Admin' ) ) {
				return false;
			}

			// Instantiate the admin class.
			$admin = new Sleek_Author_Box_Admin( $this->plugin_uid, $this->version );

			// Add fields to the user profile and new user profile form admin page.
			add_action( 'show_user_profile', array( $admin, 'custom_fields_user_profile' ) );
			add_action( 'edit_user_profile', array( $admin, 'custom_fields_user_profile' ) );
			add_action( 'user_new_form', array( $admin, 'custom_fields_user_profile' ) );
			add_action( 'personal_options_update', array( $admin, 'save_fields_user_profile' ) );
			add_action( 'edit_user_profile_update', array( $admin, 'save_fields_user_profile' ) );
			add_action( 'user_register', array( $admin, 'save_fields_user_profile' ) );

			return true;
		}

		/**
		 * Define frontend functionalities.
		 *
		 * @uses add_action()
		 * @uses add_filter()
		 * @uses Sleek_Author_Box_Frontend
		 * @uses Sleek_Author_Box_Frontend::enqueue_styles_scripts()
		 * @uses Sleek_Author_Box_Frontend::author_box_before_post_content()
		 * @uses Sleek_Author_Box_Frontend::author_box_after_post_content()
		 * @uses Sleek_Author_Box_Frontend::author_box_html_start()
		 * @uses Sleek_Author_Box_Frontend::author_box_html_end()
		 * @uses Sleek_Author_Box_Frontend::author_box_html_content()
		 * @uses Sleek_Author_Box_Frontend::author_box_html_social_links()
		 *
		 * @return bool
		 */
		public function define_front() {
			if ( ! class_exists( 'Sleek_Author_Box_Frontend' ) ) {
				return false;
			}

			// Instantiate the front class.
			$front = new Sleek_Author_Box_Frontend( $this->plugin_uid, $this->version, $this->skin_type, $this->icon_pack, $this->post_types );

			// Enqueuing scripts and styles that are meant to appear on the frontend.
			add_action( 'wp_enqueue_scripts', array( $front, 'enqueue_styles_scripts' ) );

			// Add author box as per the position in post.
			if ( 'below' === $this->position ) {
				add_filter( 'the_content', array( $front, 'author_box_after_post_content' ) );
			} else {
				add_filter( 'the_content', array( $front, 'author_box_before_post_content' ) );
			}

			// Author box template hooks.
			add_action( 'sleek_author_box_start', array( $front, 'author_box_html_start' ) );
			add_action( 'sleek_author_box_content', array( $front, 'author_box_html_content' ), 10, 2 );
			add_action( 'sleek_author_box_end', array( $front, 'author_box_html_end' ) );
			add_action( 'sleek_author_box_social_links', array( $front, 'author_box_html_social_links' ) );

			return true;
		}

		/**
		 * Run the plugin.
		 */
		public function run() {
			// Calling admin functionalities.
			$this->define_admin();

			// Calling frontend functionalities.
			$this->define_front();
		}
	}
}
