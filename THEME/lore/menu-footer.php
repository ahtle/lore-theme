<?php if ( has_nav_menu( 'lsvr-lore-footer-menu' ) ) : ?>
<!-- FOOTER MENU : begin -->
<nav class="footer-menu" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

    <?php wp_nav_menu(
        array(
            'theme_location' => 'lsvr-lore-footer-menu',
			'container' => '',
			'fallback_cb' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth' => 1,
		)
	); ?>

</nav>
<!-- FOOTER MENU : end -->
<?php endif; ?>