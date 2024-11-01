<?php
/**
 * Skin - Author box deafult skin.
 *
 * @package    Sleek_Author_Box
 * @subpackage Skins
 * @since      1.0.0
 * @version    1.0.0
 * @author     kantbtrue
 * @license    GPL-2.0-or-later
 */

?>
<!-- Sleek Author Box Card: Skin 1 -->
<div class="sleekathrbox-inner sleekathrbox-skin-1">
	<div class="row">
		<div class="col-12 col-md-auto">
			<img src="<?php echo esc_url( $args['avatar_url'] ); ?>" alt="" class="sleekathrbox-avatar rounded-circle">
		</div>
		<div class="col">
			<div class="sleekathrbox-name">
				<?php
				echo esc_html( $args['display_name'] );

				if ( is_user_logged_in() ) :
					?>
					<span class="sleekathrbox-edit">
						<a href="<?php echo esc_url( get_edit_user_link( $args['id'] ) ); ?>" target="_blank">
								<?php esc_html_e( 'Edit Profile', 'sleek-author-box' ); ?>
						</a>
					</span>
					<?php
				endif;
				?>
			</div>
			<div class="sleekathrbox-bio">
				<?php
				if ( $args['bio'] ) :
					echo wpautop( wp_kses_post( $args['bio'] ) );
				else :
					if ( is_user_logged_in() ) :
						?>
					<span class="sleekathrbox-edit">
						<a href="<?php echo esc_url( get_edit_user_link( $args['id'] ) ); ?>" target="_blank">
							<?php esc_html_e( 'Add Biographical Info', 'sleek-author-box' ); ?>
						</a>
					</span>
						<?php
					endif;
				endif;
				?>
			</div>
			<nav class="sleekathrbox-social">
				<?php
				// Loop through the social links.
				foreach ( $args['social'] as $social => $url ) :
					if ( isset( $url ) && ! empty( $url ) ) :
						?>
					<a href="<?php echo esc_attr( $url ); ?>" target="_blank">
						<img src="<?php echo esc_url( $args['icon_pack_urls'][ $social ] ); ?>" alt="" class="icon">
					</a>
						<?php
					endif;
				endforeach;
				?>
				<?php if ( is_user_logged_in() ) : ?>
				<span class="sleekathrbox-edit">
					<a href="<?php echo esc_url( get_edit_user_link( $args['id'] ) . '?#sleekathrbox-admin-social-wrap' ); ?>" target="_blank">
						<?php esc_html_e( '+ Add more social profiles', 'sleek-author-box' ); ?>
					</a>
				</span>
				<?php endif; ?>
			</nav>
			<div class="mt-4">
				<a href="<?php echo esc_url( get_author_posts_url( $args['id'] ) ); ?>" class="sleekathrbox-more">
					<span>
						<?php esc_html_e( 'View more posts', 'sleek-author-box' ); ?>
					</span> <img src="<?php echo esc_url( SLEEK_AUTHOR_BOX_URL . 'skins/default/images/right-arrow.svg' ); ?>" alt="" class="icon">
				</a>
			</div>
		</div>
	</div>
</div>
<!--/ End Sleek Author Box Card: Skin 1 -->
