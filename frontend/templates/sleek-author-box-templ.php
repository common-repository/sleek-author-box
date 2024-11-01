<?php
/**
 * Template - Author box core template.
 *
 * @package    Sleek_Author_Box
 * @subpackage Core
 * @since      1.0.0
 * @version    1.0.0
 * @author     kantbtrue
 * @license    GPL-2.0-or-later
 */

global $post;

/**
 * Add custom functionality before the sleek author box.
 *
 * This can be used to add custom elements before the
 * sleek author box.
 */
do_action( 'sleek_author_box_before' );

/**
 * Sleek author box opening tag.
 */
do_action( 'sleek_author_box_start' );

	// Get author id.
	$author_id = $post->post_author;

	/**
	 * Add content/skin to sleek author box.
	 *
	 * @param int $author_id Author ID.
	 */
	do_action( 'sleek_author_box_content', $author_id );

/**
 * Sleek author box closing tag.
 */
do_action( 'sleek_author_box_end' );

/**
 * Add custom functionality after the sleek author box.
 *
 * This can be used to add custom elements after the
 * sleek author box.
 */
do_action( 'sleek_author_box_after' );
