<?php if ( is_active_sidebar( 'lsvr-lore-footer-widgets' ) ) : ?>
<!-- FOOTER WIDGETS : begin -->
<div class="footer-widgets">
	<div class="footer-widgets-inner">
		<div class="container">
			<div class="row">

				<?php dynamic_sidebar( 'lsvr-lore-footer-widgets' ); ?>

			</div>
		</div>
	</div>
</div>
<!-- FOOTER WIDGETS : end -->
<?php endif; ?>