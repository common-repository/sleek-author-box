<?php
/**
 * Load and display template files in plugin.
 *
 * @package    Sleek_Author_Box
 * @subpackage Ingredient
 * @since      1.0.0
 * @version    1.0.0
 * @author     WidgetStack
 * @license    GPL-2.0-or-later
 */

// If direct access this file, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sleek_Author_Box_Templ' ) ) {
	/**
	 * Loads and display template part into a plugin.
	 */
	class Sleek_Author_Box_Templ {


		/**
		 * Retrieve the name of the highest priority template file that exists.
		 *
		 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
		 * inherit from a parent theme can just overload one file. If the template is
		 * not found in either of those, it looks in the theme-compat folder last.
		 *
		 * Taken from bbPress
		 *
		 * @param string|array $template_names Template file(s) to search for, in order.
		 * @param bool         $load           Optional. If true the template file will be loaded if it is found.
		 * @param bool         $require_once   Optional. Whether to require_once or require. Default true. Has no effect if $load is false.
		 * @param array        $args           Optional. Additional arguments passed to the template.
		 *
		 * @uses get_stylesheet_directory()
		 * @uses get_template_directory()
		 * @uses load_template()
		 *
		 * @return string|bool The template filename if one is located, otherwise false.
		 */
		protected static function locate_template( $template_names, $load = false, $require_once = true, $args = array() ) {
			// No file found yet.
			$located = false;

			// Try to find a template file.
			foreach ( (array) $template_names as $template_name ) {

				// Continue if template is empty.
				if ( empty( $template_name ) ) {
					continue;
				}

				// Trim off any slashes from the template name.
				$template_name = ltrim( $template_name, '/' );

				// Check child theme first.
				if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'sleek-author-box/' . $template_name ) ) {
					$located = trailingslashit( get_stylesheet_directory() ) . 'sleek-author-box/' . $template_name;
					break;

					// Check parent theme next.
				} elseif ( file_exists( trailingslashit( get_template_directory() ) . 'sleek-author-box/' . $template_name ) ) {
					$located = trailingslashit( get_template_directory() ) . 'sleek-author-box/' . $template_name;
					break;

					// Check theme compatibility last.
				} elseif ( file_exists( trailingslashit( SLEEK_AUTHOR_BOX_PATH ) . $template_name ) ) {
					$located = trailingslashit( SLEEK_AUTHOR_BOX_PATH ) . $template_name;
					break;
				}
			}

			if ( ( true === $load ) && ! empty( $located ) ) {
				load_template( $located, $require_once, $args );
			}

			return $located;
		}

		/**
		 * Retrieves a template part.
		 *
		 * NOTE: It similar to WP core `get_template_part()` function but lacks the `arguments` parameter.
		 * Which is used to pass variables to the template.
		 *
		 * NOTE: functionality of this function are borrowed from bbPress.
		 *
		 * @param string $slug Template file slug.
		 * @param string $name Optional. Default null.
		 * @param array  $args Optional. Additional arguments passed to the template.
		 *
		 * @uses do_action()
		 * @uses apply_filters()
		 *
		 * @return string|bool
		 */
		public static function get_template_part( $slug, $name = null, $args = array() ) {
			// Execute code for this part.
			do_action( 'sleek_author_box_get_template_part_' . $slug, $slug, $name, $args );

			// Setup possible parts.
			$templates = array();
			$name      = (string) $name;
			if ( '' !== $name ) {
				$templates[] = $slug . '-' . $name . '.php';
			}
			$templates[] = $slug . '.php';

			// Allow template parts to be filtered.
			$templates = apply_filters( 'sleek_author_box_get_template_part', $templates, $slug, $name, $args );

			// Return the part that is found.
			return self::locate_template( $templates, true, false, $args );
		}
	};
}
