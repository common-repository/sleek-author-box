<?php
/**
 * Plugin helper trait.
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

if ( ! trait_exists( 'Sleek_Author_Box_Helper' ) ) {
	/**
	 * Plugin helper trait.
	 */
	trait Sleek_Author_Box_Helper {


		/**
		 * Get plugin options.
		 *
		 * @uses get_option()
		 *
		 * @param string $options_key Unique options key for plugin.
		 *
		 * @return mixed
		 */
		public static function get_options( $options_key = null ) {
			return get_option( $options_key );
		}

		/**
		 * List of supported social media.
		 *
		 * @return array
		 */
		public static function get_supported_social_media() {
			return array(
				'500px'          => '500px',
				'behance'        => 'Behance',
				'delicious'      => 'Delicious',
				'dev'            => 'Dev',
				'deviantart'     => 'Deviantart',
				'digg'           => 'Digg',
				'discord'        => 'Discord',
				'dribbble'       => 'Dribbble',
				'email'          => 'Email',
				'etsy'           => 'Etsy',
				'facebook'       => 'Facebook',
				'flickr'         => 'Flickr',
				'foursquare'     => 'Foursquare',
				'github'         => 'Github',
				'goodreads'      => 'Goodreads',
				'instagram'      => 'Instagram',
				'linkedin'       => 'Linkedin',
				'mastodon'       => 'Mastodon',
				'medium'         => 'Medium',
				'meetup'         => 'Meetup',
				'mixcloud'       => 'Mixcloud',
				'pinterest'      => 'Pinterest',
				'quora'          => 'Quora',
				'reddit'         => 'Reddit',
				'skype'          => 'Skype',
				'slack'          => 'Slack',
				'snapchat'       => 'Snapchat',
				'soundcloud'     => 'Soundcloud',
				'spotify'        => 'Spotify',
				'stack-overflow' => 'Stack Overflow',
				'steam'          => 'Steam',
				'stumbleupon'    => 'Stumbleupon',
				'telegram'       => 'Telegram',
				'tumblr'         => 'Tumblr',
				'twitch'         => 'Twitch',
				'twitter'        => 'Twitter',
				'unsplash'       => 'Unsplash',
				'vimeo'          => 'Vimeo',
				'vk'             => 'VK',
				'website'        => 'Website',
				'whatsapp'       => 'Whatsapp',
				'wordpress'      => 'WordPress',
				'xing'           => 'Xing',
				'yelp'           => 'Yelp',
				'youtube'        => 'Youtube',
			);
		}

		/**
		 * Sanitize form field values as per the field type.
		 *
		 * @param mixed  $val Settings value.
		 * @param string $form_ele Form element type.
		 *
		 * @return mixed
		 */
		public static function sanitize_control( $val, $form_ele = 'text' ) {

			$sanitized_val;

			switch ( $form_ele ) {
				case 'text':
					$sanitized_val = sanitize_text_field( $val );
					break;
				case 'textarea':
					$sanitized_val = wp_kses_post( $val );
					break;
				case 'checkbox':
				case 'radio':
					$sanitized_val = rest_sanitize_boolean( $val );
					break;
				case 'url':
					$sanitized_val = esc_url_raw( $val );
					break;
				case 'file':
				case 'number':
					$sanitized_val = absint( $val );
					break;
				case 'select':
					$sanitized_val = sanitize_text_field( $val );
					break;
				default:
					$sanitized_val = sanitize_text_field( $val );
					break;
			};

			return $sanitized_val;
		}
	}
}
