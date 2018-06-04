<?php $sidebar_id = '' !== get_post_meta( $post->ID, 'lsvr_lore_sidebar_id', true ) ? get_post_meta( $post->ID, 'lsvr_lore_sidebar_id', true ) : 'lsvr-lore-custom-sidebar-1'; ?>
<?php if ( is_active_sidebar( $sidebar_id ) ) : ?>
<!-- SIDEBAR : begin -->
<aside id="sidebar" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<div class="sidebar-inner">

		<?php dynamic_sidebar( $sidebar_id ); ?>

	</div>
</aside>
<!-- SIDEBAR : end -->
<?php endif; ?>
