<?php
/**
 * Plugin frontend functionality class.
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

if ( ! class_exists( 'Sleek_Author_Box_Frontend' ) ) {
	/**
	 * Plugin front functionalities.
	 */
	class Sleek_Author_Box_Frontend {


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
		 * Skin type.
		 *
		 * @var string $skin_type Skin type.
		 */
		protected $skin_type;

		/**
		 * Icon pack.
		 *
		 * @var string $icon_pack Icon pack.
		 */
		protected $icon_pack;

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
		 * @param string $plugin_uid Plugin unique identifier.
		 * @param string $version    Plugin version.
		 * @param string $skin_type  Skin type.
		 * @param string $icon_pack  Icon pack.
		 * @param array  $post_types Supported post types.
		 */
		public function __construct( $plugin_uid, $version, $skin_type, $icon_pack, $post_types ) {
			// Set plugin unique identifier.
			$this->plugin_uid = $plugin_uid;

			// Set plugin version.
			$this->version = $version;

			// Set skin type.
			$this->skin_type = $skin_type;

			// Set icon pack.
			$this->icon_pack = $icon_pack;

			// Set supported post types.
			$this->post_types = $post_types;
		}

		/**
		 * Enqueue front end styles and scripts.
		 *
		 * @return bool
		 */
		public function enqueue_styles_scripts() {
			wp_enqueue_style( 'sleek-author-box', SLEEK_AUTHOR_BOX_URL . 'frontend/assets/css/style.css', array(), time(), 'all' );
			wp_enqueue_style( 'sleek-author-box-' . $this->skin_type . '-skin', SLEEK_AUTHOR_BOX_URL . 'skins/' . $this->skin_type . '/style.css', array(), time(), 'all' );

			return true;
		}

		/**
		 * Author box HTML markup.
		 *
		 * @return string
		 */
		public function author_box_templ() {
			$output = '';
			ob_start();
			Sleek_Author_Box_Templ::get_template_part( 'frontend/templates/sleek-author-box-templ' );
			$output .= ob_get_clean();
			return $output;
		}

		/**
		 * Add author box before post content.
		 *
		 * @param  string $content Content of the current post.
		 * @return string
		 */
		public function author_box_before_post_content( $content ) {
			if ( is_singular( $this->post_types ) ) {
				$content = $this->author_box_templ() . $content;
			}
			return $content;
		}

		/**
		 * Add author box after post content.
		 *
		 * @param  string $content Content of the current post.
		 * @return string
		 */
		public function author_box_after_post_content( $content ) {
			if ( is_singular( $this->post_types ) ) {
				$content = $content . $this->author_box_templ();
			}
			return $content;
		}

		/**
		 * Get icon pack urls.
		 *
		 * @param  string $icon_pack              Icon pack.
		 * @param  array  $supported_social_media Supported social media.
		 * @return array
		 */
		public function get_icon_pack_urls( $icon_pack, $supported_social_media ) {
			// Set icon pack urls.
			$icon_pack_urls = array();
			foreach ( $supported_social_media as $key => $value ) {
				$icon_pack_urls[ $key ] = SLEEK_AUTHOR_BOX_URL . 'icon-packs/' . $icon_pack . '/' . $key . '.svg';
			}

			return $icon_pack_urls;
		}

		/**
		 * Author box HTML start hook function.
		 *
		 * @return void|false
		 */
		public function author_box_html_start() {
			Sleek_Author_Box_Templ::get_template_part( 'frontend/templates/partials/start' );
		}

		/**
		 * Author box HTML end hook function.
		 *
		 * @return void|false
		 */
		public function author_box_html_end() {
			Sleek_Author_Box_Templ::get_template_part( 'frontend/templates/partials/end' );
		}

		/**
		 * Author box HTML content hook function.
		 *
		 * @param  int $author_id Author id.
		 * @return void|false
		 */
		public function author_box_html_content( $author_id ) {
			// Get supported social media.
			$supported_social_media = self::get_supported_social_media();

			// Get current author information.
			$curr_author = get_userdata( $author_id );

			// Get author information.
			$author_info = array(
				'id'           => $curr_author->ID,
				'nickname'     => $curr_author->nickname,
				'display_name' => $curr_author->display_name,
				'bio'          => get_user_meta( $curr_author->ID )['description'][0],
				'avatar_url'   => get_avatar_url(
					$curr_author->ID,
					array(
						'size' => 160,
					)
				),
				'social'       => array(
					'website' => $curr_author->user_url,
					'email'   => 'mailto:' . $curr_author->user_email,
				),
			);

			// Add custom social media.
			foreach ( $supported_social_media as $social_media => $social_media_name ) {
				// Check social media value, if empty or for `website` and `email` do not add in database.
				if ( '' === get_user_meta( $curr_author->ID, $social_media, true ) || ( 'website' === $social_media || 'email' === $social_media ) ) {
					continue;
				}

				$author_info['social'][ $social_media ] = get_user_meta( $curr_author->ID, $social_media, true );
			}

			// Add icon pack.
			$author_info['icon_pack_urls'] = $this->get_icon_pack_urls( $this->icon_pack, $supported_social_media );

			Sleek_Author_Box_Templ::get_template_part( 'skins/' . $this->skin_type . '/index', '', $author_info );
		}

		/**
		 * Author box HTML social links hook function.
		 *
		 * @param  array $social_info Author social information.
		 * @return void|false
		 */
		public function author_box_html_social_links( $social_info ) {
			Sleek_Author_Box_Templ::get_template_part( 'frontend/templates/partials/social-links', '', $social_info );
		}
	}
}
