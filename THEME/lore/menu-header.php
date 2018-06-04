<?php if ( has_nav_menu( 'lsvr-lore-header-menu' ) ) : ?>
<!-- HEADER MENU : begin -->
<nav class="header-menu" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

    <?php wp_nav_menu(
        array(
            'theme_location' => 'lsvr-lore-header-menu',
			'container' => '',
			'menu_class' => 'header-menu-root',
			'fallback_cb' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		)
	); ?>

</nav>
<!-- HEADER MENU : end -->
<?php endif; ?>