<?php
/**
 * Partials - Author box social links.
 *
 * @package    Sleek_Author_Box
 * @subpackage Core
 * @since      1.0.0
 * @version    1.0.0
 * @author     kantbtrue
 * @license    GPL-2.0-or-later
 */

?>
<nav class="sleekathrbox-social">
	<?php
	foreach ( $args as $key => $social ) :
		if ( isset( $social['url'] ) && ! empty( $social['url'] ) ) :
			?>
		<a href="<?php echo esc_url( $social['url'] ); ?>">
			<img src="<?php echo esc_url( $social['icon'] ); ?>" alt="" class="icon">
		</a>
			<?php
		endif;
	endforeach;
	?>
</nav>
