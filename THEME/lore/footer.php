	</div>
</div>
<!-- CORE : end -->

<?php // Add custom code before Footer
do_action( 'lsvr_lore_footer_before' ); ?>

<!-- FOOTER : begin -->
<footer id="footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
	<div class="footer-inner">

		<?php if ( has_nav_menu( 'lsvr-lore-footer-menu' ) || true == get_theme_mod( 'footer_social_enable', true ) ) : ?>
		<!-- FOOTER TOP : begin -->
		<div class="footer-top">
			<div class="footer-top-inner">
				<div class="container">

					<?php // FOOTER MENU
					get_template_part( 'menu', 'footer' ); ?>

					<?php if ( true == get_theme_mod( 'footer_social_enable', true ) ): ?>
					<!-- FOOTER SOCIAL : begin -->
					<div class="footer-social">
						<?php lsvr_lore_the_social_links(); ?>
					</div>
					<!-- FOOTER SOCIAL : end -->
					<?php endif; ?>

				</div>
			</div>
		</div>
		<!-- FOOTER TOP : end -->
		<?php endif; ?>

		<?php // Add custom code before footer widgets
		do_action( 'lsvr_lore_footer_widgets_before' ); ?>

		<?php // FOOTER WIDGETS
		get_sidebar( 'footer-widgets' ); // Load sidebar-footer-widgets.php template ?>

		<?php // Add custom code after footer widgets
		do_action( 'lsvr_lore_footer_widgets_after' ); ?>

		<?php $footer_text = get_theme_mod( 'footer_text', '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) );
		if ( ! empty( $footer_text ) ||  true == get_theme_mod( 'footer_scroll_top_enable', true ) ) : ?>
		<!-- FOOTER BOTTOM : begin -->
		<div class="footer-bottom">
			<div class="footer-bottom-inner">
				<div class="container">

					<?php if ( $footer_text !== '' ) : ?>
					<!-- FOOTER TEXT : begin -->
					<div class="footer-text">
						<?php echo wpautop( $footer_text ); ?>
					</div>
					<!-- FOOTER TEXT : end -->
					<?php endif; ?>

					<?php if ( true == get_theme_mod( 'footer_scroll_top_enable', true ) ) : ?>
					<!-- SCROLL TO TOP : begin -->
					<p class="footer-scroll-top">
						<a href="#top"><?php esc_html_e( 'Back to Top', 'lore' ); ?></a>
					</p>
					<!-- SCROLL TO TOP : end -->
					<?php endif; ?>

				</div>
			</div>
		</div>
		<!-- FOOTER BOTTOM : end -->
		<?php endif; ?>

	</div>
</footer>
<!-- FOOTER : end -->

<?php wp_footer(); ?>

</body>
</html>