<?php
/**
 * Plugin admin functionality class.
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

if ( ! class_exists( 'Sleek_Author_Box_Admin' ) ) {
	/**
	 * Plugin admin functionalities.
	 */
	class Sleek_Author_Box_Admin {


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
		 */
		public function __construct( $plugin_uid, $version ) {
			// Set plugin unique identifier.
			$this->plugin_uid = $plugin_uid;

			// Set plugin version.
			$this->version = $version;
		}

		/**
		 * Custom fields for user profile.
		 *
		 * @uses add_action()
		 * @uses get_the_author_meta()
		 *
		 * @param WP_User $user User object.
		 *
		 * @return void
		 */
		public function custom_fields_user_profile( $user ) {
			?>
			<div id="sleekathrbox-admin-social-wrap">
				<h2><?php esc_html_e( 'Sleek Author Box', 'sleek-author-box' ); ?></h2>
				<table class="form-table">
					<tr>
						<th>
							<?php wp_nonce_field( 'sleek-author-box', 'sleek-author-box-nonce' ); ?>
						</th>
					</tr>
					<?php
					$sleek_author_box_social = self::get_supported_social_media();
					foreach ( $sleek_author_box_social as $social_media => $social_media_name ) {
						if ( is_object( $user ) ) {
							$social_media_value = get_the_author_meta( $social_media, $user->ID );
						} else {
							$social_media_value = '';
						}
						if ( 'website' === $social_media || 'email' === $social_media ) {
							continue;
						}
						?>
						<tr>
							<th><label for="<?php echo esc_attr( 'sleekathrbox-' . $social_media ); ?>"><?php echo esc_html( $social_media_name ); ?></label></th>
							<td>
								<input type="url" name="<?php echo esc_attr( $social_media ); ?>" id="<?php echo esc_attr( 'sleekathrbox-' . $social_media ); ?>" value="<?php echo esc_attr( $social_media_value ); ?>" class="regular-text" /><br />
								<span class="description"><?php echo wp_sprintf( __( 'Please enter your %s profile URL.' ), $social_media ); ?></span>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}

		/**
		 * Custom fields for user profile.
		 *
		 * @uses update_user_meta()
		 *
		 * @param int $user_id User ID.
		 *
		 * @return void
		 */
		public function save_fields_user_profile( $user_id ) {
			$sleek_author_box_social = self::get_supported_social_media();
			if ( ! isset( $_POST['sleek-author-box-nonce'] ) || ! wp_verify_nonce( $_POST['sleek-author-box-nonce'], 'sleek-author-box' ) ) {
				return;
			}
			foreach ( $sleek_author_box_social as $social_media => $social_media_name ) {
				// Sanitize user input.
				$social_media_value = self::sanitize_control( $_POST[ $social_media ], 'url' );

				// Check social media value, if empty or for `website` and `email` do not add in database.
				if ( '' === $social_media_value || ( 'website' === $social_media || 'email' === $social_media ) ) {
					delete_user_meta( $user_id, $social_media );
					continue;
				}

				update_user_meta( $user_id, $social_media, $social_media_value );
			}
		}
	}
}
