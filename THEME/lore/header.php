<!DOCTYPE html>
<html <?php language_attributes(); ?> id="top">
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<body itemscope="itemscope" itemtype="http://schema.org/WebPage" <?php body_class(); ?>>

	<?php // Add custom code before Header
	do_action( 'lsvr_lore_header_before' ); ?>

	<!-- HEADER : begin -->
	<header id="header" itemscope="itemscope" itemtype="http://schema.org/WPHeader"<?php lsvr_lore_the_header_class(); ?>>
		<div class="header-bg<?php lsvr_lore_the_header_bg_overlay(); ?>"<?php lsvr_lore_the_background_image(); ?>>
			<div class="header-inner">

				<!-- HEADER NAVBAR : begin -->
				<div class="header-navbar">
					<div class="container">
						<div class="header-navbar-inner">

							<!-- HEADER BRANDING : begin -->
							<div class="header-branding">
								<?php if ( has_custom_logo() ) : ?>
									<?php the_custom_logo(); ?>
								<?php else : ?>
									<h1><a href="<?php echo esc_url( home_url() ); ?>" class="logo-text"><?php bloginfo( 'name' ); ?></a></h1>
								<?php endif; ?>
							</div>
							<!-- HEADER BRANDING : end -->

							<!-- HEADER MENU HOLDER : begin -->
							<div class="header-menu-holder">
								<div class="header-menu-holder-inner">

									<?php // Add custom code before header menu
									do_action( 'lsvr_lore_header_menu_before' ); ?>

									<?php if ( lsvr_lore_has_compact_header_search() ) : ?>
									<!-- HEADER COMPACT SEARCH : begin -->
									<div class="header-compact-search">
										<button class="toggle" type="button"><i class="fa fa-search"></i></button>
										<div class="header-compact-search-form-holder">
											<?php // HEADER SEARCH FORM
											get_template_part( 'components/header-search-form' ); // Load components/header-search-form.php template ?>
										</div>
									</div>
									<!-- HEADER COMPACT SEARCH : begin -->
									<?php endif; ?>

									<?php if ( true == get_theme_mod( 'wpml_lang_switcher_enable', true ) ) : ?>
										<?php $wpml_languages = apply_filters( 'wpml_active_languages', false, 'skip_missing=0&orderby=id&order=desc' ); ?>
										<?php if ( is_array( $wpml_languages ) && count( $wpml_languages ) > 1 ) : ?>

											<!-- HEADER LANGUAGES : begin -->
											<div class="header-languages">
												<span class="header-languages-label"><?php esc_html_e( 'Choose language:', 'lore' ); ?></span>
												<ul>
												<?php foreach ( $wpml_languages as $lang ) : ?>
													<li<?php if ( (bool) $lang['active'] ) { echo ' class="m-active"'; } ?>><a href="<?php echo esc_url( $lang['url'] ); ?>"><?php echo esc_html( $lang['language_code'] ); ?></a></li>
												<?php endforeach; ?>
												</ul>
											</div>
											<!-- HEADER LANGUAGES : end -->

										<?php endif; ?>
									<?php endif; ?>

									<?php // HEADER MENU
									get_template_part( 'menu', 'header' ); ?>

								</div>
							</div>
							<!-- HEADER MENU HOLDER : end -->

							<!-- HEADER MOBILE TOGGLE : begin -->
							<button type="button" class="header-mobile-toggle"><i class="fa fa-bars"></i></button>
							<!-- HEADER MOBILE TOGGLE : end -->

						</div>
					</div>
				</div>
				<!-- HEADER NAVBAR : end -->

				<?php if ( true == get_theme_mod( 'header_search_enable', true ) ) : ?>
				<!-- HEADER SEARCH : begin -->
				<div class="header-search">
					<div class="container">
						<div class="header-search-inner">

							<?php // HEADER SEARCH FORM
							get_template_part( 'components/header-search-form' ); // Load components/header-search-form.php template ?>

						</div>
					</div>
				</div>
				<!-- HEADER SEARCH : end -->
				<?php endif; ?>

			</div>
		</div>
	</header>
	<!-- HEADER : end -->

	<?php // Add custom code after Header
	do_action( 'lsvr_lore_header_after' ); ?>

	<!-- CORE : begin -->
	<div id="core" <?php post_class(); ?>>
		<div class="core-inner">