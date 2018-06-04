<?php
/**
 * Theme setup
 */
add_action( 'after_setup_theme', 'lsvr_lore_theme_setup' );
if ( ! function_exists( 'lsvr_lore_theme_setup' ) ) {
	function lsvr_lore_theme_setup() {

		/**
		 * Set content width
		 *
		 * @link https://codex.wordpress.org/Content_Width
		 */
		if ( ! isset( $content_width ) ) {
			$content_width = 1000;
		}

		/**
		 * Load textdomain
		 *
		 * @link https://codex.wordpress.org/Function_Reference/load_textdomain
		 */
		load_theme_textdomain( 'lore', get_template_directory() . '/languages' );

		/**
		 * Include additional files
		 */
		require_once( get_template_directory() . '/inc/lsvr-lore-functions.php' ); // Theme functions
		require_once( get_template_directory() . '/inc/metaboxes.php' ); // Custom metaboxes
		require_once( get_template_directory() . '/inc/tgm-plugin-config.php' ); // TGM plugin activation
		require_once( get_template_directory() . '/inc/kirki-config.php' ); // Kirki Plugin config - WP Customizer options
		require_once( get_template_directory() . '/inc/class-lsvr-lore-content-grid-menu.php' ); // Walker for Content Grid element with source set to menu

    	/**
    	 * HTML 5 support
    	 */
		add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

		/**
		 * Site logo via WP Customizer
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'flex-height' => true,
			'flex-height' => true,
		));

		/**
		 * Let WordPress manage the document title
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable post thumbnails
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Add post formats support fot Knowledge Base articles
		 */
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'video', 'audio' ) );
    	add_post_type_support( 'lsvr_lore_kb', 'post-formats', array( 'gallery', 'link', 'image', 'video', 'audio' ) );
    	add_action( 'init', function() {
    		remove_post_type_support( 'post', 'post-formats' );
    		remove_post_type_support( 'lsvr_lore_faq', 'post-formats' );
    	}, 10 );

    	/**
    	 * Enqueue JS and CSS
    	 */
		add_action( 'wp_enqueue_scripts', 'lsvr_lore_load_theme_scripts' );
		if ( ! function_exists( 'lsvr_lore_load_theme_scripts' ) ) {
			function lsvr_lore_load_theme_scripts(){

				$lsvr_lore_theme_version = wp_get_theme();
				$lsvr_lore_theme_version = $lsvr_lore_theme_version->Version;
				$lsvr_lore_js_suffix = defined( 'WP_DEBUG' ) && true == WP_DEBUG ? '.js' : '.min.js';

				// Main style.css
				wp_enqueue_style( 'lsvr-lore-main-style', get_bloginfo( 'stylesheet_url' ), array(), $lsvr_lore_theme_version );

				// FontAwesome icons
				// Theme contains only limited number of FA icons. It is possible to use a 3rd party plugin with full FA icon set.
				// Then he can disable loading of bundled FA to save bandwitch.
				if ( true == get_theme_mod( 'misc_fontawesome_enable', true ) ) {
					wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/library/css/fontawesome.css', array(), $lsvr_lore_theme_version );
				}

				// Color scheme
				$color_scheme_source = get_theme_mod( 'color_source', 'predefined' );

				// Predefined color scheme
				// It should be loaded even if Color Cheme is set to pick color
				if ( 'predefined' === $color_scheme_source || 'colorpicker' === $color_scheme_source ) {
					$color_scheme = get_theme_mod( 'color_predefined', 'green' );
					wp_enqueue_style( 'lsvr-lore-color-scheme', get_template_directory_uri() . '/library/css/skin/' . esc_attr( $color_scheme ) . '.css', array(), $lsvr_lore_theme_version );
				}

				// Generate inline CSS based on selected colors in Customizer
				if ( 'colorpicker' === $color_scheme_source ) {
					$color_scheme_link = get_theme_mod( 'color_pick_link', '#1565c0' );
					$color_scheme_accent = get_theme_mod( 'color_pick_accent', '#74aa7b' );
					wp_add_inline_style( 'lsvr-lore-color-scheme', lsvr_lore_get_color_scheme_code( $color_scheme_link, $color_scheme_accent ) );
				}

				// Add color scheme as custom inline code
				elseif ( 'inline' === $color_scheme_source ) {
					wp_add_inline_style( 'lsvr-lore-main-style', esc_html( get_theme_mod( 'color_inline', '' ) ) );
				}

				// Add logo max width CSS
				if ( (int) get_theme_mod( 'header_logo_width', 0 ) > 0 ) {
					wp_add_inline_style( 'lsvr-lore-main-style', '.header-branding .custom-logo-link { max-width: ' . (int) get_theme_mod( 'header_logo_width', 0 ) . 'px; }' );
				}

				// Custom CSS
				if ( '' !== trim( get_theme_mod( 'custom_css_code', '' ) ) ){
					$custom_css_code_position = wp_style_is( 'lsvr-lore-color-scheme', 'enqueued' ) ? 'lsvr-lore-color-scheme' : 'lsvr-lore-main-style';
					wp_add_inline_style( $custom_css_code_position, esc_html( get_theme_mod( 'custom_css_code', '' ) ) );
				}

				// Typography
				if ( true == get_theme_mod( 'typography_gf_enable', true ) ) {

					// Prepare query params
					$primary_font = get_theme_mod( 'typography_primary_font', 'Open+Sans' );
					$primary_font_variants = '400,400italic,700,700italic';
					$secondary_font = get_theme_mod( 'typography_secondary_font', 'Merriweather' );
					$secondary_font_variants = '400,400italic,900,900italic';
					$family_param = $primary_font !== $secondary_font ? $primary_font . ':' . $primary_font_variants . '|' . $secondary_font . ':' . $secondary_font_variants : $primary_font . ':' . $primary_font_variants;
					$subset_arr = get_theme_mod( 'typography_subsets' );
					$subset_param = is_array( $subset_arr ) && ! empty( $subset_arr ) ? '&subset=' . implode( ',', $subset_arr ) : '';

					// Create query
					$query_args = array(
						'family' => $family_param,
						'subset' => $subset_param,
					);
					$query_args = array_filter( $query_args );

					// Enqueue query
					if ( ! empty( $query_args ) ) {
						wp_enqueue_style( 'lsvr-lore-google-fonts', esc_url( add_query_arg( $query_args, '//fonts.googleapis.com/css' ) ) );
					}

					// Primary font style
					$primary_font_elements = array( 'body', '.widget-title', '.c-section-title', '.comment-reply-title' );
					$primary_font_family = str_replace( '+', ' ', $primary_font );
					$primary_font_css = implode( ', ', $primary_font_elements ) . ' { font-family: \'' . esc_attr( $primary_font_family ) . '\', Arial, sans-serif; }';
					wp_add_inline_style( 'lsvr-lore-main-style', $primary_font_css );
					wp_add_inline_style( 'lsvr-lore-main-style', 'body { font-size: ' . esc_attr( get_theme_mod( 'typography_font_size', '16' ) ) . 'px; }' );

					// Secondary font style
					if ( $primary_font !== $secondary_font ) {
						$secondary_font_elements = array( 'h1', 'h2' );
						$secondary_font_family = str_replace( '+', ' ', $secondary_font );
						$secondary_font_css = implode( ', ', $secondary_font_elements ) . ' { font-family: \'' . esc_attr( $secondary_font_family ) . '\', Arial, sans-serif; }';
						wp_add_inline_style( 'lsvr-lore-main-style', $secondary_font_css );
					}

				}

				// Header content offset
				if ( true == get_theme_mod( 'header_fixed_navbar_enable', true ) && (int) get_theme_mod( 'header_content_offset', 100 ) > 0 ) {
					$header_content_offset_css = '@media ( min-width: 992px ) { .m-fixed-navbar .header-inner { padding-top: ' . (int) esc_attr( get_theme_mod( 'header_content_offset', 100 ) ) . 'px; } }';
					wp_add_inline_style( 'lsvr-lore-main-style', $header_content_offset_css );
				}

				// Comment reply
				if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }

				// Masonry
				wp_enqueue_script( 'jquery-masonry' );

				// Plugins
				wp_enqueue_script( 'lsvr-lore-plugins', get_template_directory_uri() . '/library/js/plugins' . $lsvr_lore_js_suffix, array( 'jquery' ), $lsvr_lore_theme_version, true );

				// Main scripts
				wp_enqueue_script( 'lsvr-lore-main-scripts', get_template_directory_uri() . '/library/js/scripts' . $lsvr_lore_js_suffix, array( 'jquery' ), $lsvr_lore_theme_version, true );

				// Ajax search
				if ( true == get_theme_mod( 'header_search_enable', true ) && true == get_theme_mod( 'header_search_ajax_enable', true ) ) {
					wp_enqueue_script( 'lsvr-lore-ajax-search', get_template_directory_uri() . '/library/js/ajax-search' . $lsvr_lore_js_suffix, array( 'jquery' ), $lsvr_lore_theme_version, true );
					wp_localize_script( 'lsvr-lore-ajax-search', 'lsvr_lore_ajax_search_var', array(
			    		'url' => admin_url( 'admin-ajax.php' ),
			    		'nonce' => wp_create_nonce( 'lsvr-lore-ajax-search-nonce' )
					));
				}

				// Ajax post rating
				if ( is_singular( 'lsvr_lore_kb' ) && true == get_theme_mod( 'kb_rating_enable', true ) ) {
					wp_enqueue_script( 'lsvr-lore-post-rating', get_template_directory_uri() . '/library/js/post-rating' . $lsvr_lore_js_suffix, array( 'jquery' ), $lsvr_lore_theme_version, true );
					wp_localize_script( 'lsvr-lore-post-rating', 'lsvr_lore_ajax_rating_var', array(
			    		'url' => admin_url( 'admin-ajax.php' ),
			    		'nonce' => wp_create_nonce( 'lsvr-lore-ajax-post-rating-nonce' )
					));
				}

				// Translatable JS strings
				$js_strings = 'var lsvr_lore_js_strings = {};';
			    $js_strings .= 'lsvr_lore_js_strings.mp_tClose = "'. esc_html__( 'Close (Esc)', 'lore' ) .'";';
			    $js_strings .= 'lsvr_lore_js_strings.mp_tLoading = "' . esc_html__( 'Loading...', 'lore' ) . '";';
			    $js_strings .= 'lsvr_lore_js_strings.mp_tPrev = "' . esc_html__( 'Previous (Left arrow key)', 'lore' ) . '";';
			    $js_strings .= 'lsvr_lore_js_strings.mp_tNext = "' . esc_html__( 'Next (Right arrow key)', 'lore' ) . '";';
			    $js_strings .= 'lsvr_lore_js_strings.mp_image_tError = "' . esc_html__( 'The image could not be loaded.', 'lore' ) . '";';
			    $js_strings .= 'lsvr_lore_js_strings.mp_ajax_tError = "' . esc_html__( 'The content could not be loaded.', 'lore' ) . '";';
				wp_add_inline_script( 'lsvr-lore-main-scripts', $js_strings );

				// Fluid iframe and embed elements
			    if ( true == get_theme_mod( 'misc_fluid_embeds_enable', true ) || true == get_theme_mod( 'misc_fluid_iframes_enable', true ) ) {

			    	// Embed
			    	$fluid_selector[] = true == get_theme_mod( 'misc_fluid_embeds_enable', true ) ? '#main embed' : '';

			    	// Iframe
			    	if ( true == get_theme_mod( 'misc_fluid_iframes_enable', true ) ) {
			    		if ( '' !== get_theme_mod( 'misc_fluid_iframes_include', 'youtube, vimeo' ) ) {
							$iframe_filter = str_replace( ', ', ',', get_theme_mod( 'misc_fluid_iframes_include', 'youtube, vimeo' ) );
		    				$iframe_filter = explode( ',', $iframe_filter );
		    				foreach ( $iframe_filter as $filter ) {
		    					$fluid_selector[] = '#main iframe[src*=' . $filter . ']';
		    				}
			    		} else {
							$fluid_selector[] = '#main iframe';
			    		}
			    	}

			    	$js_fluid_selector = '';
			    	$fluid_selector = array_filter( $fluid_selector );
			    	foreach ( $fluid_selector as $selector ) {
			    		$js_fluid_selector .= $selector . ', ';
			    	}
			    	$js_fluid_selector = 'var lsvr_lore_fluid_elements = "' . esc_attr( rtrim ( $js_fluid_selector, ', ' ) ) . '";';
			    	wp_add_inline_script( 'lsvr-lore-main-scripts', $js_fluid_selector );

			    }

			    // Directory URI
			    // Used by style switcher
			    wp_add_inline_script( 'lsvr-lore-main-scripts', 'var lsvr_lore_template_directory_uri = "' . esc_url( get_template_directory_uri() ). '";' );

	    	}
		}

    	/**
    	 * Register header nav menu
    	 */
		register_nav_menu( 'lsvr-lore-header-menu', esc_html__( 'Header Menu', 'lore' ) );

    	/**
    	 * Register footer nav menu
    	 */
		register_nav_menu( 'lsvr-lore-footer-menu', esc_html__( 'Footer Menu', 'lore' ) );

    	/**
    	 * Register content grid menu
    	 */
		register_nav_menu( 'lsvr-lore-content-grid-menu', esc_html__( 'Content Grid', 'lore' ) );

	    /**
	     * Register sidebars
	     */
	    add_action( 'widgets_init', 'lsvr_lore_register_sidebars' );
		if ( ! function_exists( 'lsvr_lore_register_sidebars' ) ) {
			function lsvr_lore_register_sidebars() {

				// Default sidebar used for blog pages
				register_sidebar( array(
					'name' => esc_html__( 'Default Sidebar', 'lore' ),
					'id' => 'lsvr-lore-default-sidebar',
					'description' => esc_html__( 'This sidebar is used for standard posts pages (post archive, post detail, etc.). You can change its position or disable it under Appearance / Customize / Standard Posts', 'lore' ),
					'class' => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></div>',
					'before_title' => '<h3 class="widget-title"><span>',
					'after_title' => '</span></h3>',
				));

				// Content grid
				register_sidebar( array(
					'name' => esc_html__( 'Content Grid', 'lore' ),
					'id' => 'lsvr-lore-content-grid-sidebar',
					'description' => esc_html__( 'This widget area can be used on a page which has its page template set to Default Front Page. Content Grid Source option under Appearance / Customize / Default Front Page Settings has to be set to Widgets. You can also insert this sidebar to any page via Content Grid shortcode [lore_content_grid]', 'lore' ),
					'class' => '',
					'before_widget' => '<li class="brick-item"><div class="brick-item-inner"><div id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></div></div></li>',
					'before_title' => '<h3 class="widget-title"><span>',
					'after_title' => '</span></h3>',
				));

				// Custom sidebars
				$custom_sidebars_count = get_theme_mod( 'custom_sidebars_count', 1 ) < 1 ? 1 : (int) get_theme_mod( 'custom_sidebars_count', 1 );
				for ( $i = 1; $i <= $custom_sidebars_count; $i++ ) {
					register_sidebar( array(
						'name' => sprintf( esc_html__( 'Custom Sidebar %d', 'lore' ), $i ),
						'id' => 'lsvr-lore-custom-sidebar-' . $i,
						'description' => sprintf( esc_html__( 'To assign this sidebar to a page, set page template to "Sidebar on the Left" or "Sidebar on the Right" and then choose the sidebar under Sidebar Settings of that page. Also, you can insert this sidebar to any page using [lore_content_grid sidebar="lsvr-lore-custom-sidebar-%d"] shortcode. Number of available Custom Sidebars can be set under Appearance / Customize / Misc Settings with Number of Custom Sidebars option', 'lore' ), $i ),
						'class' => '',
						'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
						'after_widget' => '</div></div>',
						'before_title' => '<h3 class="widget-title"><span>',
						'after_title' => '</span></h3>',
					));
				}

				// Sidebar for Knowledge Base pages
				register_sidebar( array(
					'name' => esc_html__( 'Knowledge Base Sidebar', 'lore' ),
					'id' => 'lsvr-lore-knowledgebase-sidebar',
					'description' => esc_html__( 'Widget area located on the left or right side of all Knowledge Base pages except the default archive. You can change its side or disable it under Appearance / Customize / Knowledge Base with Sidebar Position option', 'lore' ),
					'class' => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></div>',
					'before_title' => '<h3 class="widget-title"><span>',
					'after_title' => '</span></h3>',
				));

				// Sidebar for FAQ pages
				register_sidebar( array(
					'name' => esc_html__( 'FAQ Sidebar', 'lore' ),
					'id' => 'lsvr-lore-faq-sidebar',
					'description' => esc_html__( 'Widget area located on the left or right side of all FAQ pages. You can change its side or disable it under Appearance / Customize / FAQ with Sidebar Position option', 'lore' ),
					'class' => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></div>',
					'before_title' => '<h3 class="widget-title"><span>',
					'after_title' => '</span></h3>',
				));

				// Widgetized area in footer
				$footer_widgets_columns = get_theme_mod( 'footer_widgets_cols', 3 );
				$footer_widgets_col_number = 12 / $footer_widgets_columns;
				register_sidebar( array(
					'name' => esc_html__( 'Footer Widgets', 'lore' ),
					'id' => 'lsvr-lore-footer-widgets',
					'description' => esc_html__( 'Widget area located in the footer of the site. You can change number of columns under Appearance / Customize / Footer Settings with Footer Widgets Columns option', 'lore' ),
					'class' => '',
					'before_widget' => '<div class="widget-col col-md-' . esc_attr( $footer_widgets_col_number ) . '"><div id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></div></div>',
					'before_title' => '<h3 class="widget-title"><span>',
					'after_title' => '</span></h3>',
				));

				// Sidebar for search results page
				register_sidebar( array(
					'name' => esc_html__( 'Search Results Sidebar', 'lore' ),
					'id' => 'lsvr-lore-search-results-sidebar',
					'description' => esc_html__( 'Widget area located on the left or right side of Search Results page. You can change its position or disable it under Appearance / Customize / Misc Settings with Search Results Sidebar Position option', 'lore' ),
					'class' => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></div>',
					'before_title' => '<h3 class="widget-title"><span>',
					'after_title' => '</span></h3>',
				));

			}
		}

    	/**
    	 * WP Customizer JS script
    	 */
		add_action( 'customize_preview_init', 'lsvr_lore_customizer_live_preview_js' );
    	if ( ! function_exists( 'lsvr_lore_customizer_live_preview_js' ) ) {
    		function lsvr_lore_customizer_live_preview_js() {

				$lsvr_lore_theme_version = wp_get_theme();
				$lsvr_lore_theme_version = $lsvr_lore_theme_version->Version;
				$lsvr_lore_js_suffix = defined( 'WP_DEBUG' ) && true == WP_DEBUG ? '.js' : '.min.js';

    			wp_register_script( 'lsvr-lore-theme-customizer', get_template_directory_uri() . '/library/js/theme-customizer' . $lsvr_lore_js_suffix, array( 'jquery', 'customize-preview' ), $lsvr_lore_theme_version, true );
    			wp_enqueue_script( 'lsvr-lore-theme-customizer' );

			}
    	}

        /**
    	 * Search filter for non-Ajax search
    	 */
		add_action( 'pre_get_posts', 'lsvr_lore_search_filter' );
		if ( ! function_exists( 'lsvr_lore_search_filter' ) ) {
			function lsvr_lore_search_filter( $query ) {
				if ( is_search() && $query->is_main_query() && ( isset( $_GET['search-filter'] ) || isset( $_GET['search-filter-serialized'] ) ) ) {

					if ( isset( $_GET['search-filter'] ) ) {
						$post_type_arr = array_map( 'esc_attr', $_GET['search-filter'] );
					} else {
						$post_type_arr = explode( ',', esc_attr( $_GET['search-filter-serialized'] ) );
					}

					$query->set( 'post_type', $post_type_arr );
					return $query;

				}
			}
		}

        /**
         * Ajax search
         */
	    add_action( 'wp_ajax_nopriv_lsvr-lore-ajax-search', 'lsvr_lore_ajax_search' );
		add_action( 'wp_ajax_lsvr-lore-ajax-search', 'lsvr_lore_ajax_search' );
		if ( ! function_exists( 'lsvr_lore_ajax_search' ) ) {
			function lsvr_lore_ajax_search() {

				$nonce = $_POST['nonce'];
				$search_query = isset( $_POST['search_query'] ) && '' !== $_POST['search_query'] ? sanitize_text_field( $_POST['search_query'] ) : '';
				$post_type = isset( $_POST['post_type'] ) && '' !== $_POST['post_type'] ? array_filter( array_map( 'trim', explode( ',', sanitize_text_field( $_POST['post_type'] ) ) ) ) : 'any';

    			if ( ! wp_verify_nonce( $nonce, 'lsvr-lore-ajax-search-nonce' ) ) {
        			die ( esc_html__( 'You do not have permission to search', 'lore' ) );
        		}

        		if ( '' !== $search_query ) {

					$args = array(
						'posts_per_page' => 1000,
						'post_type' => $post_type,
						's' => $search_query,
					);
					$search_results = get_posts( $args );

					// If has results
					if ( ! empty( $search_results ) ) {

						$search_results_sliced = array_slice( $search_results, 0, get_theme_mod( 'header_search_ajax_results_limit', 10 ) );
						$search_results_parsed = [];
						foreach ( $search_results_sliced as $result ) {

							$temp_array = array(
								'ID' => $result->ID,
								'post_title' => $result->post_title,
								'permalink' => esc_url( get_permalink( $result->ID ) ),
								'post_type' => $result->post_type,
								'icon_class' => lsvr_lore_get_post_type_icon_class( $result->ID ),
							);

							// If post is a bbPress reply CPT, we need to get title of its parent topic
							if ( function_exists( 'bbp_get_reply_topic_title' ) && 'reply' === $result->post_type ) {
								$topic_title = bbp_get_reply_topic_title( $result->ID );
								$temp_array['post_title'] = sprintf( esc_html__( 'Reply To: %s', 'lore' ), $topic_title );
							}

							// Show post rating
							if ( 'lsvr_lore_kb' === $result->post_type && true == get_theme_mod( 'kb_rating_enable', true ) ) {

								$post_rating = lsvr_lore_get_post_rating_values( $result->ID );
						    	$likes = (int) $post_rating['likes'];
						    	$likes_abb = $post_rating['likes_abb'];
						    	$dislikes = (int) $post_rating['dislikes'];
						    	$dislikes_abb = $post_rating['dislikes_abb'];
						    	$difference = (int) $post_rating['difference'];
						    	$difference_abb = $post_rating['difference_abb'];

						    	// Likes and dislikes
								if ( true == get_theme_mod( 'kb_rating_dislikes_enable', true ) ) {

									// Show difference between likes and dislikes
									if ( 'difference' === get_theme_mod( 'kb_rating_type', 'difference' ) ) {
										if ( 0 !== $difference ) {
											$temp_array['difference'] = $difference;
											$temp_array['difference_abb'] = $difference_abb;
										}
									}

									// Show both likes and dislikes
									else {
										if ( 0 !== $likes ) {
											$temp_array['likes'] = $likes_abb;
										}
										if ( 0 !== $dislikes ) {
											$temp_array['dislikes'] = $dislikes_abb;
										}
									}

								}

								// Show likes only
								else if ( 0 !== $likes ) {
									$temp_array['likes'] = $likes_abb;
								}

							}

							$search_results_parsed[] = $temp_array;

						}

						// Prepare array with search results
						$response = array(
	            			'status' => 'ok',
	            			'results' => $search_results_parsed,
            			);

						// Add "more link" to response if needed
            			if ( count( $search_results ) > get_theme_mod( 'header_search_ajax_results_limit', 10 ) ) {
            				$response['more_label'] =  esc_html__( 'Show all results', 'lore' );
            				$response['more_link'] = esc_url( add_query_arg( array(
            					's' => $search_query,
            					'search-filter-serialized' => implode( ',', $post_type ),
        					), home_url( '/' ) ) );
            			}

            			// echo JSON response
						echo json_encode( $response );

					}

					// If no results
					else {

						echo json_encode(array(
	            			'status' => 'noresults',
	            			'message' => esc_html__( 'Sorry, no results were found', 'lore' ),
            			));

					}

        		}

				wp_die();

			}
		}

		/**
		 * Add an item to search filter
		 *
		 * used with lsvr_lore_header_search_filter_add action in Child Theme
		 */
		if ( ! function_exists( 'lsvr_lore_header_search_filter_add_item' ) ) {
			function lsvr_lore_header_search_filter_add_item( $post_type, $label ) {
				if ( isset( $_GET['search-filter'] ) ) {
					$post_type_arr = array_map( 'esc_attr', $_GET['search-filter'] );
				} elseif ( isset( $_GET['search-filter-serialized'] ) ) {
					$post_type_arr = explode( ',', esc_attr( $_GET['search-filter-serialized'] ) );
				} else {
					$post_type_arr = [];
				}
				$checked = in_array( $post_type, $post_type_arr ) ? ' checked="checked"' : '';
				echo '<label for="header-search-filter-type-' . esc_attr( $post_type )  . '" class="header-search-filter-type-' . esc_attr( $post_type )  . '"><input type="checkbox" id="header-search-filter-type-' . esc_attr( $post_type ) . '" name="search-filter[]" value="' . esc_attr( $post_type ) . '"' . $checked . '>' . esc_html( $label ) . '</label>';
			}
		}

        /**
         * Knowledge Base ajax post rating
         *
         * @link http://code.tutsplus.com/articles/how-to-create-a-simple-post-rating-system-with-wordpress-and-jquery--wp-24474
         */
		add_action( 'wp_ajax_nopriv_lsvr-lore-kb-post-rating', 'lsvr_lore_kb_post_rating' );
		add_action( 'wp_ajax_lsvr-lore-kb-post-rating', 'lsvr_lore_kb_post_rating' );
		if ( ! function_exists( 'lsvr_lore_kb_post_rating' ) ) {
			function lsvr_lore_kb_post_rating() {

    			$nonce = $_POST['nonce'];

    			if ( ! wp_verify_nonce( $nonce, 'lsvr-lore-ajax-post-rating-nonce' ) ) {
        			die ( esc_html__( 'You do not have permission to rate', 'lore' ) );
        		}

    			if ( isset( $_POST['lsvr_lore_kb_post_rating'] ) ) {

					$post_id = $_POST['post_id'];
    				$rating_type = isset( $_POST['rating_type'] ) && 'dislike' === $_POST['rating_type'] ? 'dislike' : 'like';

        			// Get votes count for the current post
        			$meta_likes_count = '' !== get_post_meta( $post_id, 'lsvr_lore_likes_count', true ) ? get_post_meta( $post_id, 'lsvr_lore_likes_count', true ) : 0;
        			$meta_dislikes_count = '' !== get_post_meta( $post_id, 'lsvr_lore_dislikes_count', true ) ? get_post_meta( $post_id, 'lsvr_lore_dislikes_count', true ) : 0;

        			// User has already voted ?
        			if ( ! lsvr_lore_kb_already_rated( $post_id ) ) {

	            		// Save the rating cookie
	            		$cookie_expiration_date = get_theme_mod( 'kb_rating_interval', 'month' );
	            		switch ( $cookie_expiration_date ) {
            				case '1hour':
            					$cookie_expiration_date_seconds = 3600;
            					break;
            				case 'day':
            					$cookie_expiration_date_seconds = 60*60*24;
            					break;
            				case 'week':
            					$cookie_expiration_date_seconds = 60*60*24*7;
            					break;
            				case 'month':
            					$cookie_expiration_date_seconds = 60*60*24*30;
            					break;
            				case 'threemonths':
            					$cookie_expiration_date_seconds = 60*60*24*90;
            					break;
            				case 'sixmonths':
            					$cookie_expiration_date_seconds = 60*60*24*180;
            					break;
            				case 'year':
            					$cookie_expiration_date_seconds = 60*60*24*365;
            					break;
            				case 'tenyears':
            					$cookie_expiration_date_seconds = 60*60*24*3650;
            					break;
	            		}
	            		if ( empty( $cookie_expiration_date_seconds ) ) {
	            			$cookie_expiration_date_seconds = 60*60*24*30;
	            		}
	            		setcookie( 'lsvr_lore_kb_rating_' . $post_id, $rating_type, time() + $cookie_expiration_date_seconds, COOKIEPATH, COOKIE_DOMAIN );

	            		// Like
	            		if ( 'like' === $rating_type ) {
	            			update_post_meta( $post_id, 'lsvr_lore_likes_count', (int) ++$meta_likes_count );
	            		}
	            		// Dislike
	            		else {
	            			update_post_meta( $post_id, 'lsvr_lore_dislikes_count', (int) ++$meta_dislikes_count );
	            		}

	            		// Likes dislikes difference
	            		update_post_meta( $post_id, 'lsvr_lore_rating_diff', (int) ( $meta_likes_count - $meta_dislikes_count ) );

	            		$json_reponse = array(
	            			'status' => 'rating_saved',
            			);

            		} else {

						$json_reponse = array(
	            			'status' => 'already_rated',
            			);

            		}

            		$json_reponse = array_merge( $json_reponse, array(
            			'likes_count' => $meta_likes_count,
            			'dislikes_count' => $meta_dislikes_count,
            			'likes_count_abb' => lsvr_lore_abbreviate_number( $meta_likes_count ),
            			'dislikes_count_abb' => lsvr_lore_abbreviate_number( $meta_dislikes_count ),
            			'likes_btn_title' => sprintf( esc_html( _n( '%s like', '%s likes', lsvr_lore_abbreviate_number( $meta_likes_count ), 'lore' ) ), lsvr_lore_abbreviate_number( $meta_likes_count ) ),
            			'dislikes_btn_title' => sprintf( esc_html( _n( '%s dislike', '%s dislikes', lsvr_lore_abbreviate_number( $meta_dislikes_count ), 'lore' ) ), lsvr_lore_abbreviate_number( $meta_dislikes_count ) ),
        			));
        			echo json_encode( $json_reponse );

        		}
        		else {
            		echo json_encode(array(
            			'status' => 'error',
        			));
        		}
        		wp_die();

    		}
		}

		// Function to check if user already rated
		if ( ! function_exists( 'lsvr_lore_kb_already_rated' ) ) {
			function lsvr_lore_kb_already_rated( $post_id ) {

				if ( isset( $_COOKIE[ 'lsvr_lore_kb_rating_' . $post_id ] ) ) {
					return true;
				}

				return false;

			}
		}

	    /**
	     * Include KB articles on author archive page
	     */
	    add_action( 'pre_get_posts', 'lsvr_lore_author_archive_loop' );
	    if ( ! function_exists( 'lsvr_lore_author_archive_loop' ) ) {
	    	function lsvr_lore_author_archive_loop( $query ) {
	    		if ( $query->is_author() ) {
        			$query->set( 'post_type', array( 'post', 'lsvr_lore_kb' ) );
    			}
	    	}
	    }

	    /**
	     * Set menu link as active for theme's CPTs
	     */
		add_filter( 'nav_menu_css_class', 'lsvr_lore_active_nav_link_class', 10, 2 );
		if ( ! function_exists( 'lsvr_lore_active_nav_link_class' ) ) {
			function lsvr_lore_active_nav_link_class( $classes, $item ) {

				// Knowledge Base
				$knowledgebase_archive_slug = get_theme_mod( 'kb_slug', 'knowledge-base' );
				if ( lsvr_lore_is_knowledgebase() && strpos( $item->url, '/' . $knowledgebase_archive_slug ) ) {
					$classes[] = 'current-menu-ancestor';
				}

				// FAQ
				$faq_archive_slug = get_theme_mod( 'faq_slug', 'faq' );
				if ( lsvr_lore_is_faq() && strpos( $item->url, '/' . $faq_archive_slug ) ) {
					$classes[] = 'current-menu-ancestor';
				}

				// Blog pages
				elseif ( lsvr_lore_is_blog() &&  false !== @strpos( rtrim( $item->url, '/' ), rtrim( get_permalink( get_option( 'page_for_posts' ) ), '/' ) ) ) {
					$classes[] = 'current-menu-ancestor';
				}

	    		return $classes;
			}
		}

		/**
		 * Add custom page title for KB & FAQ archive pages
		 */
		add_filter( 'document_title_parts', 'lsvr_lore_cpt_title', 10, 2 );
		if ( ! function_exists( 'lsvr_lore_cpt_title' ) ) {
			function lsvr_lore_cpt_title( $title ) {
				if ( is_post_type_archive( 'lsvr_lore_kb' ) ) {
					$title['title'] = sanitize_text_field( get_theme_mod( 'kb_title', 'Knowledge Base' ) );
				} elseif ( is_post_type_archive( 'lsvr_lore_faq' ) ) {
					$title['title'] = sanitize_text_field( get_theme_mod( 'faq_title', 'FAQ' ) );
				}
				return $title;
			}
		}

		/**
		 * Post class filter
		 *
		 * Add some custom classes to post_class call
		 */
		add_filter( 'post_class', 'lsvr_lore_custom_post_class' );
		if ( ! function_exists( 'lsvr_lore_custom_post_class' ) ) {
			function lsvr_lore_custom_post_class( $classes ) {

				global $post;
				$classes[] = 'post-item';

				// Knowledge Base
				if ( 'lsvr_lore_kb' === get_post_type( $post ) && lsvr_lore_has_post_rating_values( $post->ID ) ) {
				 	$classes[] = 'm-has-rating';
				}

				// FAQ
				elseif ( 'lsvr_lore_faq' === get_post_type( $post ) ) {
					$default_state = get_theme_mod( 'faq_default_state', 'closed' );
					$classes[] = 'open' === $default_state ? 'post-item m-active' : 'post-item';
				}

				return $classes;

			}
		}

		/**
		 * Number of Knowledge Base articles per page
		 *
		 * If archive page layout is set to article_view
		 */
		add_action( 'pre_get_posts', 'lsvr_lore_modify_kb_posts_per_page' );
		if ( ! function_exists( 'lsvr_lore_modify_kb_posts_per_page' ) ) {
			function lsvr_lore_modify_kb_posts_per_page( $query ) {

				$tax_terms = get_terms( 'lsvr_lore_kb_cat', array( 'parent' => 0 ) );

				// Masonry archive
				if ( $query->is_main_query() && ( 'article_view' === get_theme_mod( 'kb_archive_layout', 'article_view' ) || empty( $tax_terms ) ) &&
						( $query->is_post_type_archive( 'lsvr_lore_kb' ) || $query->is_tax( 'lsvr_lore_kb_cat' ) || $query->is_tax( 'lsvr_lore_kb_tag' ) ) && ! is_admin() ) {
					if ( 0 === get_theme_mod( 'kb_per_page', 10 ) ) {
						$query->set( 'posts_per_page', 1000 );
					} else {
						$query->set( 'posts_per_page', esc_attr( get_theme_mod( 'kb_per_page', 10 ) ) );
					}
				}

			}
		}

		/**
		 * Order of Knowledge Base posts
		 *
		 * This filter will be applied to Knowledge Base archive with article_view layout and to Category and Tag taxonomy pages
		 */
		add_action( 'pre_get_posts', 'lsvr_lore_modify_kb_posts_order' );
		if ( ! function_exists( 'lsvr_lore_modify_kb_posts_order' ) ) {
			function lsvr_lore_modify_kb_posts_order( $query ) {
				if ( $query->is_main_query() && ( ( $query->is_post_type_archive( 'lsvr_lore_kb' ) && ( 'article_view' === get_theme_mod( 'kb_archive_layout', 'category_view' ) ) ) ||
						$query->is_tax( 'lsvr_lore_kb_cat' ) || $query->is_tax( 'lsvr_lore_kb_tag' ) ) && ! is_admin() ) {
					if ( 'date_desc' === get_theme_mod( 'kb_articles_order', 'default' ) ) {
						$query->set( 'order', 'DESC' );
						$query->set( 'orderby', 'date' );
					} elseif ( 'date_asc' === get_theme_mod( 'kb_articles_order', 'default' ) ) {
						$query->set( 'order', 'ASC' );
						$query->set( 'orderby', 'date' );
					} elseif ( 'title' === get_theme_mod( 'kb_articles_order', 'default' ) ) {
						$query->set( 'order', 'ASC' );
						$query->set( 'orderby', 'title' );
					}
				}
			}
		}

		/**
		 * Intuitive Custom Post Order Plugin Fix
		 *
		 * Force articles on Knowledge Base taxonomy pages to show properly as defined with ICPO plugin
		 */
		if ( class_exists( 'Hicpo' ) ) {
			add_action( 'pre_get_posts', 'lsvr_lore_icpo_fix' );
			if ( ! function_exists( 'lsvr_lore_icpo_fix' ) ) {
				function lsvr_lore_icpo_fix( $query ) {
					if ( $query->is_main_query() &&
							( $query->is_tax( 'lsvr_lore_kb_cat' ) || $query->is_tax( 'lsvr_lore_kb_tag' ) ) && ! is_admin() ) {
						if ( 'default' === get_theme_mod( 'kb_articles_order', 'default' ) ) {
							$query->set( 'order', 'ASC' );
							$query->set( 'orderby', 'menu_order' );
						}
					}
				}
			}
		}

		/**
		 * Knowledge Base category tax articles filter
		 *
		 * Show only direct child articles of current category
		 */
		add_filter( 'pre_get_posts', 'lsvr_lore_kb_cat_archive_filter' );
		if ( ! function_exists( 'lsvr_lore_kb_cat_archive_filter' ) ) {
			function lsvr_lore_kb_cat_archive_filter( $query ) {
				if ( $query->is_main_query() && $query->is_tax( 'lsvr_lore_kb_cat' ) && ! is_admin() ) {

					$current_term = get_queried_object();
					$tax_query = array(
						array(
							'taxonomy' => 'lsvr_lore_kb_cat',
							'field' => 'id',
							'terms' => $current_term->term_id,
							'include_children' => false,
						)
					);
					if ( ! empty( $current_term ) ) {
						$query->set( 'tax_query', $tax_query );
					}

				}
			}
		}

		/**
		 * Knowledge Base article attachments
		 *
		 * This functionality is handled via Attachments plugin
		 *
		 * @link https://github.com/jchristopher/attachments
		 */

		// Add metabox
		add_action( 'attachments_register', 'lsvr_lore_kb_article_attachments' );
		if ( ! function_exists( 'lsvr_lore_kb_article_attachments' ) ) {
			function lsvr_lore_kb_article_attachments( $attachments ) {
				$fields = array(
					array(
						'name' => 'title',
			      		'type' => 'text',
			      		'label' => esc_html__( 'Title', 'lore' ),
			      		'default' => 'title',
			    	),
					array(
						'name' => 'icon',
			      		'type' => 'text',
			      		'label' => esc_html__( 'Icon (for example "fa fa-file-o")', 'lore' ),
			      		'default' => '',
			    	),
			  	);
			  	$args = array(
			  		'label' => esc_html__( 'Add Attachments', 'lore' ),
			  		'post_type' => array( 'lsvr_lore_kb' ),
			  		'position' => 'normal',
			  		'priority' => 'high',
			  		'filetype' => null,
			  		'note' => esc_html__( 'Hold the CTRL / CMD key to select multiple files at once', 'lore' ),
			  		'append' => true,
			  		'button_text' => esc_html__( 'Attach Files', 'lore' ),
			  		'modal_text' => esc_html__( 'Attach', 'lore' ),
			  		'router' => 'browse',
			  		'post_parent' => false,
			  		'fields' => $fields,
			  	);
			  	$attachments->register( 'lsvr_lore_kb_article_attachments', $args );
			}
		}

		/**
		 * Order of FAQ posts
		 */
		add_action( 'pre_get_posts', 'lsvr_lore_modify_faq_posts_order' );
		if ( ! function_exists( 'lsvr_lore_modify_faq_posts_order' ) ) {
			function lsvr_lore_modify_faq_posts_order( $query ) {
				if ( $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_lore_faq' ) || $query->is_tax( 'lsvr_lore_faq_cat' ) || $query->is_tax( 'lsvr_lore_faq_tag' ) ) && ! is_admin() ) {
					if ( 'date_desc' === get_theme_mod( 'faq_order', 'default' ) ) {
						$query->set( 'order', 'DESC' );
						$query->set( 'orderby', 'date' );
					} elseif ( 'date_asc' === get_theme_mod( 'faq_order', 'default' ) ) {
						$query->set( 'order', 'ASC' );
						$query->set( 'orderby', 'date' );
					} elseif ( 'title' === get_theme_mod( 'faq_order', 'default' ) ) {
						$query->set( 'order', 'ASC' );
						$query->set( 'orderby', 'title' );
					}
				}
			}
		}

		/**
		 * Number of FAQ posts per page
		 */
		add_action( 'pre_get_posts', 'lsvr_lore_modify_faq_posts_per_page' );
		if ( ! function_exists( 'lsvr_lore_modify_faq_posts_per_page' ) ) {
			function lsvr_lore_modify_faq_posts_per_page( $query ) {
				if ( $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_lore_faq' ) || $query->is_tax( 'lsvr_lore_faq_cat' ) || $query->is_tax( 'lsvr_lore_faq_tag' ) ) && ! is_admin() ) {
					if ( 0 === get_theme_mod( 'faq_per_page', 0 ) ) {
						$query->set( 'posts_per_page', 1000 );
					} else {
						$query->set( 'posts_per_page', esc_attr( get_theme_mod( 'faq_per_page', 0 ) ) );
					}
				}
			}
		}

		/**
		 * Add body class if default lightbox is being used
		 */
		if ( true == get_theme_mod( 'misc_lightbox_enable', true ) ) {
			add_filter( 'body_class', 'lsvr_lore_lightbox_body_class' );
		}
		if ( ! function_exists( 'lsvr_lore_lightbox_body_class' ) ) {
			function lsvr_lore_lightbox_body_class( $classes ) {
				$classes[] = 'm-default-lightbox';
				return $classes;
			}
		}

		/**
		 * Include bbPress forum, topic and reply CPT in WordPress search results
		 *
		 * @link https://bbpress.org/forums/topic/plugin-snippet-hack-to-include-bbpress-topics-in-wordpress-search/
		 */
		add_filter( 'bbp_register_topic_post_type', 'lsvr_lore_bbp_topic_cpt_search' );
		if ( ! function_exists( 'lsvr_lore_bbp_topic_cpt_search' ) ) {
			function lsvr_lore_bbp_topic_cpt_search( $topic_search ) {
				$topic_search['exclude_from_search'] = false;
				return $topic_search;
			}
		}
		add_filter( 'bbp_register_forum_post_type', 'lsvr_lore_bbp_forum_cpt_search' );
		if ( ! function_exists( 'lsvr_lore_bbp_forum_cpt_search' ) ) {
			function lsvr_lore_bbp_forum_cpt_search( $forum_search ) {
				$forum_search['exclude_from_search'] = false;
				return $forum_search;
			}
		}
		add_filter( 'bbp_register_reply_post_type', 'lsvr_lore_bbp_reply_cpt_search' );
		if ( ! function_exists( 'lsvr_lore_bbp_reply_cpt_search' ) ) {
			function lsvr_lore_bbp_reply_cpt_search( $reply_search ) {
				$reply_search['exclude_from_search'] = false;
				return $reply_search;
			}
		}

		/**
		 * Optimize Contact Form 7
		 *
		 * CF7 JS and CSS files will be loaded only on page where CF7 form is being used
		 *
		 * @link http://contactform7.com/loading-javascript-and-stylesheet-only-when-it-is-necessary
		 */
		add_action( 'template_redirect', 'lsvr_lore_optimize_cf7' );
		if ( ! function_exists( 'lsvr_lore_optimize_cf7' ) ) {
			function lsvr_lore_optimize_cf7() {

				global $post;

				// Deactivate CSS and JS if contact page is defined
				if ( '' !== get_theme_mod( 'contact_form_page', '' ) ) {

					add_filter( 'wpcf7_load_js', '__return_false' );
					add_filter( 'wpcf7_load_css', '__return_false' );

					// Activate JS and CSS for contact page
					if ( is_object( $post ) && property_exists( $post, 'ID' ) && (int) get_theme_mod( 'contact_form_page', '' ) === (int) $post->ID ) {

						if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
							wpcf7_enqueue_scripts();
						}
						if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
							wpcf7_enqueue_styles();
	    				}

					}

				}

			}
		}

		/**
		 * Disable default WPML JS & CSS
		 *
		 * @link https://wpml.org/documentation/support/wpml-coding-api/
		 */
		if ( true == get_theme_mod( 'wpml_lang_switcher_enable', true ) ) {
			define( 'ICL_DONT_LOAD_NAVIGATION_CSS', true );
			define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
			define( 'ICL_DONT_LOAD_LANGUAGES_JS', true );
		}

		/**
		 * Enable Style Switcher
		 *
		 * It can be toggled via constant defined in wpconfig.php
		 */
		if ( defined( 'LSVR_DEMO' ) && true == LSVR_DEMO ) {
			add_filter( 'body_class', 'lsvr_lore_style_switcher_body_class' );
			if ( ! function_exists( 'lsvr_lore_style_switcher_body_class' ) ) {
				function lsvr_lore_style_switcher_body_class( $classes ) {
					$classes[] = 'm-style-switcher';
					return $classes;
				}
			}
		}

	}
}
?>