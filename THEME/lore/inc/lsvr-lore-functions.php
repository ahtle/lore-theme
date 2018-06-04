<?php
/**
 * Generate color scheme inline CSS from accent color
 */
if ( ! function_exists( 'lsvr_lore_get_color_scheme_code' ) ) {
	function lsvr_lore_get_color_scheme_code( $link, $accent ) {

		// Link font color
		$link_font_color_elements = array( 'a', '.c-kb-articles .kb-article-title a', '.c-post-comments .comment-reply-title small a',
			'.c-post-list .post-title a', '#sidebar .widget-more-link a', '.page-kb-post-tax-category .category-title a',
			'div.bbp-template-notice a', 'div.bbp-template-notice a:hover', '#bbpress-forums .bbp-topic-tags a' );
		$link_font_color_css = implode( ',', $link_font_color_elements ) . '{ color: ' . esc_html( $link ) . '; }';

		// Accent font color
		$accent_font_color_elements = array( '.c-accordion .accordion-item.m-active:before', '.c-accordion .m-active .accordion-item-title',
			'.c-button.m-style-outline', '.c-content-grid .feature-icon', '.c-post-comments .bypostauthor .comment-author a', '.c-post-comments .comment-metadata .comment-edit-link',
			'.c-post-rating .likes', '.c-search-form .submit-btn', '.c-tabs .tabs-title-list>li.m-active', '.widget.lsvr-kb-categories .toggle.m-active',
			'.widget.lsvr-kb-categories .m-current-cat>.item-link .category-icon', '.widget.lsvr-kb-categories .m-current-post>.item-link .post-icon',
			'.widget.lsvr-kb-categories .m-current-cat>.item-link a', '.widget.lsvr-kb-categories .m-current-post>.item-link a',
			'.widget.widget_calendar a', '.widget.widget_nav_menu .toggle.m-active', '.widget.widget_rss ul a', '.header-search-form .text-input',
			'.header-search-form .submit-btn', '.page-post-archive .post-title a:hover', '.page-post-single .post-author-bio h5 span',
			'.page-kb-post-archive-category-view .category-icon', '.page-kb-post-single .post-rating-buttons .like', '#footer a', '#footer .footer-social a',
			'.footer-widgets .widget.widget_calendar a', '.footer-widgets .widget.widget_recent_comments a', '.footer-widgets .widget.widget_recent_entries a',
			'.footer-widgets .widget.widget_rss ul a', '.footer-widgets .widget.widget_tag_cloud a' );
		$accent_font_color_css = implode( ',', $accent_font_color_elements ) . '{ color: ' . esc_html( $accent ) . '; }';

		// Accent background color
		$accent_bg_color_elements = array( 'blockquote:before', '.c-button', '#main .navigation.pagination .current', '.c-post-comments ul.page-numbers .current',
			'.c-post-comments .comment-form input[type="submit"]', '.c-subscribe-form input[type="submit"]', '.widget.widget_calendar #today',
			'.widget.widget_display_search input.button', '.header-menu ul ul a:hover', '.header-menu ul ul li.m-hover>a', '.header-search-filter label.m-active',
			'.header-search-suggestions-inner', '.page-post .post-password-form input[type="submit"]', '.bbp-submit-wrapper button',
			'#bbpress-forums>#subscription-toggle a.subscription-toggle', '#bbpress-forums .bbp-pagination-links .current', '#bbpress-forums #bbp-your-profile #bbp_user_edit_submit' );
		$accent_bg_color_css = implode( ',', $accent_bg_color_elements ) . '{ background-color: ' . esc_html( $accent ) . '; }';

		// Accent border color
		$accent_border_color_elements = array( '.c-accordion .accordion-item.m-active', '.c-button', '.c-faq-list .m-active .post-item-inner',
			'.c-post-comments .comment-form input[type="submit"]', '.c-tabs .tabs-title-list>li.m-active', '.widget.lsvr-kb-categories .toggle.m-active',
			'.widget.lsvr-kb-categories .m-current-cat>.item-link', '.widget.lsvr-kb-categories .m-current-post>.item-link', '.widget.widget_nav_menu .toggle.m-active',
			'.widget.widget_display_search input.button', '.header-search-options', '.header-search-filter label.m-active', '.header-search-filter label:hover',
			'.page-post .post-password-form input[type="submit"]', '.faq-post-list-accordion .m-active .post-item-inner', '.bbp-submit-wrapper button',
			'#bbpress-forums>#subscription-toggle a.subscription-toggle', '#bbpress-forums #bbp-your-profile #bbp_user_edit_submit' );
		$accent_border_color_css =  implode( ',', $accent_border_color_elements ) . '{ border-color: ' . esc_html( $accent ) . '; }';

		// Accent color responsive
		$accent_color_responsive =  '@media (max-width: 991px) { .header-menu>ul>li>a:hover,.header-menu ul ul a:hover { background-color: ' . esc_html( $accent ) . '; }';
		$accent_color_responsive .= '.header-menu>ul>li.current-menu-item>a,.header-menu li.current-menu-item>a { border-color: ' . esc_html( $accent ) . '; } }';

		return $link_font_color_css . $accent_font_color_css . $accent_bg_color_css . $accent_border_color_css . $accent_color_responsive;

	}
}

/**
 * Alert Message component
 *
 * Wraps the content in c-alert-message element
 */
if ( ! function_exists( 'lsvr_lore_the_alert_message' ) ) {
	function lsvr_lore_the_alert_message( $content = '', $args = [] ) {

    	$defaults = array( 'type' => 'info', 'custom_class' => '', 'hidden' => false );
    	$args = wp_parse_args( $args, $defaults );
    	$hidden = true === $args['hidden'] ? ' style="display: none;"' : '';
    	$custom_class = '' !== $args['custom_class'] ? ' ' . $args['custom_class'] : '';

		if ( '' !== $content ) {
    		echo '<div class="c-alert-message m-type-' . esc_attr( $args['type'] ) . esc_attr( $custom_class ) . '" ' . $hidden . '>' . wpautop( $content ) . '</div>';
    	}

	}
}

/**
 * The header class
 */
if ( ! function_exists( 'lsvr_lore_the_header_class' ) ) {
	function lsvr_lore_the_header_class( $classes = '' ) {

		$header_class = [];

		// Has fixed navbar
		if ( true == get_theme_mod( 'header_fixed_navbar_enable', true ) ) {
			$header_class[] = 'm-fixed-navbar';
		}

		// Has ajax search
		if ( true == get_theme_mod( 'header_search_ajax_enable', true ) ) {
			$header_class[] = 'm-ajax-search';
		}

		// Large search
		if ( true == lsvr_lore_has_large_header_search() ) {
			$header_class[] = 'm-large-search';
		}

		// Compact
		if ( true == lsvr_lore_has_compact_header_search() ) {
			$header_class[] = 'm-compact-search';
		}

		// Set body class for different KB archive views
		if ( is_archive( 'lsvr_lore_kb' ) && ( 'article_view' === get_theme_mod( 'kb_archive_layout', 'article_view' ) ||
			( isset( $_GET['kb_archive_layout'] ) && 'article_view' === $_GET['kb_archive_layout'] ) ) ) {
			$header_class[] = 'lsvr_lore_kb_archive_article_view';
		} else if ( is_archive( 'lsvr_lore_kb' ) ) {
			$header_class[] = 'lsvr_lore_kb_archive_category_view';
		}

		if ( ! empty( $header_class ) ) {
			echo ' class="' . esc_attr( implode( ' ', $header_class ) ) . '"';
		}

	}
}

/**
 * Header background image
 */
if ( ! function_exists( 'lsvr_lore_the_background_image' ) ) {
	function lsvr_lore_the_background_image() {

		global $post;

		// Regular page
		if ( is_page() && has_post_thumbnail( $post->ID ) ) {
			$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		}

		// Blog page
		elseif ( lsvr_lore_is_blog() && '' !== get_theme_mod( 'blog_bg_image', '' ) ) {
			$image_url = get_theme_mod( 'blog_bg_image', '' );
		}

		// Knowledge Base page
		elseif ( lsvr_lore_is_knowledgebase() && '' !== get_theme_mod( 'kb_bg_image', '' ) ) {
			$image_url = get_theme_mod( 'kb_bg_image', '' );
		}

		// FAQ page
		elseif ( lsvr_lore_is_faq() && '' !== get_theme_mod( 'faq_bg_image', '' ) ) {
			$image_url = get_theme_mod( 'faq_bg_image', '' );
		}

		// Default background
		else {
			$image_url = get_theme_mod( 'header_bg_image', '' );
		}

		if ( '' !== $image_url ) {

			$output = ' style="background-image: url(\'' . esc_url( $image_url ) . '\');';
			$output .= ' background-position: center ' . esc_attr( get_theme_mod( 'header_bg_image_alignment', 'top' ) ) . ';';
			echo $output . '"';

		}

	}
}

/**
 * Header background overlay class
 */
if ( ! function_exists( 'lsvr_lore_the_header_bg_overlay' ) ) {
	function lsvr_lore_the_header_bg_overlay() {

		if ( get_theme_mod( 'header_bg_image_overlay', 0 ) > 0 ) {
			echo ' m-overlay m-overlay-' . esc_attr( get_theme_mod( 'header_bg_image_overlay', 0 ) );
		}

	}
}

/**
 * Check if page has large header search
 */
if ( ! function_exists( 'lsvr_lore_has_large_header_search' ) ) {
	function lsvr_lore_has_large_header_search() {

		if ( true == get_theme_mod( 'header_search_enable', true ) && (
				( 'kbandfront' === get_theme_mod( 'header_search_large_enable', 'everywhere' ) && ( is_front_page() || lsvr_lore_is_knowledgebase() ) ) ||
				( 'knowledgebase' === get_theme_mod( 'header_search_large_enable', 'everywhere' ) && ( lsvr_lore_is_knowledgebase() ) ) ||
				( 'frontpage' === get_theme_mod( 'header_search_large_enable', 'everywhere' )  && is_front_page() ) ||
				( 'everywhere' === get_theme_mod( 'header_search_large_enable', 'everywhere' ) ) ||
				is_search() || is_404() ) ) {
			$return = true;
		}
		else {
			$return = false;
		}

		$filter = apply_filters( 'lsvr_lore_has_large_header_search', $return );
		return ! empty( $filter ) ? $filter : $return;

	}
}

/**
 * Check if page has compact header search
 */
if ( ! function_exists( 'lsvr_lore_has_compact_header_search' ) ) {
	function lsvr_lore_has_compact_header_search() {

		if ( true == get_theme_mod( 'header_search_enable', true ) && ! lsvr_lore_has_large_header_search() ) {
			return true;
		}
		else {
			return false;
		}

	}
}

/**
 * Get header search ID
 *
 * There can be more than one header search form present at the same time
 * one as a large header search, second as toggleable compact header search
 * input elements in each of them need to posses unique IDs
 */
if ( ! function_exists( 'lsvr_lore_get_header_search_id' ) ) {
	function lsvr_lore_get_header_search_id() {

		global $lsvr_lore_the_header_search_counter;

		if ( ! isset( $lsvr_lore_the_header_search_counter ) ) {
			$lsvr_lore_the_header_search_counter = 1;
		} else {
			$lsvr_lore_the_header_search_counter += 1;
		}

		return $lsvr_lore_the_header_search_counter;

	}
}

/**
 * Echo page title based on the current page
 *
 * Page title for 3rd party CPTs can be overridden in Child theme via lsvr_lore_page_title_args hook
 */
if ( ! function_exists( 'lsvr_lore_the_page_title' ) ) {
	function lsvr_lore_the_page_title( $args = [] ) {

		global $wp_query;

		$default_args = array(
			'post_types' => array(
				'lsvr_lore_kb' => get_theme_mod( 'kb_title', esc_html__( 'Knowledge Base', 'lore' ) ),
				'lsvr_lore_faq' => get_theme_mod( 'faq_title', esc_html__( 'FAQ', 'lore' ) ),
			)
		);

		// Merge post_types $default_args and $args first to preserve defaults
		if ( array_key_exists( 'post_types', $args ) ) {
			$args['post_types'] = array_merge( $args['post_types'], $default_args['post_types'] );
		}

		// Merge $default_args and $args
		$args = wp_parse_args( $args, $default_args );

		$the_title = '';
		$post_types = ! empty( $args['post_types'] ) ? $args['post_types'] : false;

		// Blog
		if ( is_home() ) {
			if ( get_option( 'page_for_posts' ) ) {
				$the_title = get_the_title( get_option( 'page_for_posts' ) );
			} else {
				$the_title = esc_html__( 'News', 'lore' );
			}

		// 404
		} elseif ( is_404() ) {
			$the_title = esc_html__( 'Page Not Found', 'lore' );

		// Search results page
		} elseif ( is_search() ) {
			$search_query = get_search_query();
			$the_title = sprintf( esc_html__( 'Searching for %s', 'lore' ), '<span class="search-query">' . $search_query . '</span>' );

		// Tag
		} elseif ( is_tag() ) {
			$the_title = single_tag_title( '', false );

		// Day view
		} elseif ( is_day() ) {
			$the_title = sprintf( esc_html__( 'Archive for %s', 'lore' ), get_the_time( 'F jS, Y' ) );

		// Month view
		} elseif ( is_month() ) {
			$the_title = sprintf( esc_html__( 'Archive for %s', 'lore' ), get_the_time( 'F, Y' ) );

		// Year view
		} elseif ( is_year() ) {
			$the_title = sprintf( esc_html__( 'Archive for %s', 'lore' ), get_the_time( 'Y' ) );

		// Author view
		} elseif ( is_author() ) {
			$the_title = esc_html__( 'Author Archive', 'lore' );

		// Single post
		} elseif ( is_singular( 'post' ) ) {
			$the_title = get_the_title();

		// Category
		} elseif ( is_category() ) {
			$current_term = $wp_query->queried_object;
			$the_title = $current_term->name;

		// Post type archive
		} elseif ( is_post_type_archive() ) {
			if ( get_post_type() && $post_types && array_key_exists( get_post_type(), $post_types ) ) {
				$the_title = $post_types[ get_post_type() ];
			} else {
				$the_title = post_type_archive_title( '', false );
			}

		// Taxonomy
		} elseif ( is_tax() ) {
			$current_term = $wp_query->queried_object;
			$the_title = $current_term->name;

		} else {
			$the_title = get_the_title();
		}

		echo $the_title;

	}
}

/**
 * Get current page breadcrumbs
 *
 * Settings can be overridden in Child theme via lsvr_lore_breadcrumbs_args hook
 */
if ( ! function_exists( 'lsvr_lore_get_breadcrumbs' ) ) {
	function lsvr_lore_get_breadcrumbs( $args = [] ) {

		global $wp_query, $post;
		$breadcrumbs_arr = [];
		$post_types = ! empty( $args['post_types'] ) ? $args['post_types'] : false;
		$taxonomies = ! empty( $args['taxonomies'] ) ? $args['taxonomies'] : false;
		$show_home_link = $args['show_home_link'];
		$home_link_label = $args['home_link_label'];

		// Home link
		if ( $show_home_link ) {
			$breadcrumbs_arr[] = array(
				'url' => esc_url( home_url( '/' ) ),
				'label' => $home_link_label,
			);
		}

		// Blog root for blog pages
		if ( get_option( 'page_for_posts' ) ) {
			$blog_root = array(
				'url' => get_permalink( get_option( 'page_for_posts' ) ),
				'label' => get_the_title( get_option( 'page_for_posts' ) ),
			);
		}
		else {
			$blog_root = array(
				'url' => esc_url( home_url( '/' ) ),
				'label' => esc_html__( 'News', 'lore' ),
			);
		}

		// 404
		if ( is_404() ) {
			$breadcrumbs_arr[] = array(
				'label' => esc_html__( 'Page Not Found', 'lore' ),
			);

		// Search results page
		} elseif ( is_search() ) {
			$breadcrumbs_arr[] = array(
				'label' => esc_html__( 'Search Results', 'lore' ),
			);

		// Tag view
		} elseif ( is_tag() ) {
			array_push( $breadcrumbs_arr, $blog_root, array(
				'label' => single_tag_title( '', false ),
			));

		// Day view
		} elseif ( is_day() ) {
			array_push( $breadcrumbs_arr, $blog_root, array(
				'label' => sprintf( esc_html__( 'Archive for %s', 'lore' ), get_the_time( 'F jS, Y' ) ),
			));

		// Month view
		} elseif ( is_month() ) {
			array_push( $breadcrumbs_arr, $blog_root, array(
				'label' => sprintf( esc_html__( 'Archive for %s', 'lore' ), get_the_time( 'jS, Y' ) ),
			));

		// Year view
		} elseif ( is_year() ) {
			array_push( $breadcrumbs_arr, $blog_root, array(
				'label' => sprintf( esc_html__( 'Archive for %s', 'lore' ), get_the_time( 'Y' ) ),
			));

		/*// Author view
		} elseif ( is_author() ) {
			array_push( $breadcrumbs_arr, $blog_root, array(
				'label' => esc_html__( 'Author Archive', 'lore' ),
			));
		*/

		// Single blog post
		} elseif ( is_singular( 'post' ) ) {
			array_push( $breadcrumbs_arr, $blog_root, array(
				'label' => get_the_title(),
			));

		// Blog category
		} elseif ( is_category() ) {
			$breadcrumbs_arr[] = $blog_root;
			$current_term = $wp_query->queried_object;
			$current_term_id = $current_term->term_id;
			$parent_ids = lsvr_lore_get_term_parents( $current_term_id, 'category' );
			if ( ! empty( $parent_ids ) ) {
				foreach( $parent_ids as $parent_id ){
					$parent = get_term( $parent_id, 'category' );
					$breadcrumbs_arr[] = array(
						'url' => get_term_link( $parent, 'category' ),
						'label' => $parent->name,
					);
				}
			}
			$breadcrumbs_arr[] = array(
				'label' => $current_term->name,
			);

		// Regular page
		} elseif ( is_page() ) {
			$parent_id  = $post->post_parent;
			$parents_arr = [];
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$parents_arr[] = array(
					'url' => get_permalink( $page->ID ),
					'label' => get_the_title( $page->ID ),
				);
				$parent_id = $page->post_parent;
			}
			$parents_arr = array_reverse( $parents_arr );
			foreach ( $parents_arr as $parent ) {
				$breadcrumbs_arr[] = $parent;
			}
			$breadcrumbs_arr[] = array(
				'label' => get_the_title(),
			);

		// CPT archive
		} elseif ( is_post_type_archive() ) {
			if ( get_post_type() && $post_types && array_key_exists( get_post_type(), $post_types ) ) {
				$breadcrumbs_arr[] = array(
					'label' => $post_types[ get_post_type() ],
				);
			} else {
				$breadcrumbs_arr[] = array(
					'label' => post_type_archive_title( '', false ),
				);
			}

		// CPT taxonomy
		} elseif ( is_tax() ) {

			$current_term = get_queried_object();

			// Archive
			if ( $post_types && $taxonomies &&
					array_key_exists( $current_term->taxonomy, $taxonomies ) &&
					array_key_exists( $taxonomies[ $current_term->taxonomy ], $post_types ) ) {

				$breadcrumbs_arr[] = array(
					'url' => get_post_type_archive_link( $taxonomies[ $current_term->taxonomy ] ),
					'label' => $post_types[ $taxonomies[ $current_term->taxonomy ] ],
				);

			}

			// Category parents
			$term_parents_arr = lsvr_lore_get_term_parents( $current_term->term_id, $current_term->taxonomy );
			if ( is_array( $term_parents_arr ) ) {
				foreach ( $term_parents_arr as $term_id ) {
					$term = get_term( $term_id, $current_term->taxonomy );
					$breadcrumbs_arr[] = array(
						'url' => get_term_link( $term, $current_term->taxonomy ),
						'label' => $term->name,
					);
				}
			}

			// Current category
			$breadcrumbs_arr[] = array(
				'label' => $current_term->name,
			);

		// Singular CPT post
		} elseif ( is_singular() ) {

			$article_taxonomies = get_post_taxonomies( $post );
			if ( is_array( get_post_taxonomies( $post ) ) && $post_types && $taxonomies ) {
				foreach ( $taxonomies as $key => $value ) {
					if ( in_array( $key, $article_taxonomies ) ) {

						$current_taxonomy = $article_taxonomies[ array_search( $key, $article_taxonomies ) ];

						// Archive
						if ( array_key_exists( $current_taxonomy, $taxonomies )
							&& array_key_exists( $taxonomies[ $current_taxonomy ], $post_types ) ) {

							$breadcrumbs_arr[] = array(
								'url' => get_post_type_archive_link( $taxonomies[ $current_taxonomy ] ),
								'label' => $post_types[ $taxonomies[ $current_taxonomy ] ],
							);

						}

						// Categories
						$article_terms = wp_get_post_terms( $post->ID, $current_taxonomy );
						if ( ! empty( $article_terms ) ) {

							$current_term = reset( $article_terms );

							if ( is_object( $current_term ) ) {

								// Category parents
								$term_parents_arr = lsvr_lore_get_term_parents( $current_term->term_id, $current_term->taxonomy );
								if ( ! empty( $term_parents_arr ) ) {
									foreach ( $term_parents_arr as $term_id ) {
										$term = get_term( $term_id, $current_term->taxonomy );
										$breadcrumbs_arr[] = array(
											'url' => get_term_link( $term, $current_term->taxonomy ),
											'label' => $term->name,
										);
									}
								}

								// Current category
								$breadcrumbs_arr[] = array(
									'url' => get_term_link( $current_term, $current_term->taxonomy ),
									'label' => $current_term->name,
								);

							}

						}
						break; // break foreach after first tax
					}
				}
			}

			// Current page
			$breadcrumbs_arr[] = array(
				'label' => get_the_title()
			);

		}

		return $breadcrumbs_arr;

	}
}

/**
 * Echo page breadcrumbs
 *
 * Get data from lsvr_lore_get_breadcrumbs and generate HTML
 */
if ( ! function_exists( 'lsvr_lore_the_breadcrumbs' ) ) {
	function lsvr_lore_the_breadcrumbs( $args = [] ) {

		$default_args = array(
			'post_types' => array(
				'lsvr_lore_kb' => get_theme_mod( 'kb_title', esc_html__( 'Knowledge Base', 'lore' ) ),
				'lsvr_lore_faq' => get_theme_mod( 'faq_title', esc_html__( 'FAQ', 'lore' ) ),
			),
			'taxonomies' => array(
				'lsvr_lore_kb_cat' => 'lsvr_lore_kb',
				'lsvr_lore_kb_tag' => 'lsvr_lore_kb',
				'lsvr_lore_faq_cat' => 'lsvr_lore_faq',
				'lsvr_lore_faq_tag' => 'lsvr_lore_faq',
			),
			'show_home_link' => true,
			'home_link_label' => esc_html__( 'Home', 'lore' ),
			'show_on_front_page' => false,
			'show_last' => false,
			'show_single' => false,
		);

		// Merge post_types and taxonomies of $default_args and $args first to preserve defaults
		if ( ! empty( $args['post_types'] ) ) {
			$args['post_types'] = array_merge( $args['post_types'], $default_args['post_types'] );
		}
		if ( ! empty( $args['taxonomies'] ) ) {
			$args['taxonomies'] = array_merge( $args['taxonomies'], $default_args['taxonomies'] );
		}

		// Merge $default_args and $args
		$args = wp_parse_args( $args, $default_args );

		if ( ! ( is_front_page() && false == $args['show_on_front_page'] ) ) {

			$breadcrumbs_html = '';
			$breadcrumbs_arr = lsvr_lore_get_breadcrumbs( $args );

			// bbPress
			if ( function_exists( 'is_bbpress' ) && function_exists( 'bbp_breadcrumb' ) && is_bbpress() && ! is_post_type_archive( 'forum' ) ) { ?>

				<ul class="breadcrumbs m-bbpress<?php if ( true == $args['show_last'] ) { echo ' m-show-last'; } ?>" itemtype="http://schema.org/BreadcrumbList" itemscope="itemscope">

					<?php if ( true === $args['show_home_link'] ) : ?>
						<li itemtype="http://schema.org/ListItem" itemscope="itemscope" itemprop="itemListElement"><a href="<?php echo esc_url( home_url() ); ?>" itemprop="item"><?php echo esc_html( $args['home_link_label'] ); ?></a></li>
					<?php endif; ?>

					<?php bbp_breadcrumb(array(
						'before' => '',
						'after' => '',
						'sep' => ' ',
						'crumb_before' => '<li itemtype="http://schema.org/ListItem" itemscope="itemscope" itemprop="itemListElement">',
						'crumb_after' => '</li>',
						'include_home' => false,
					)); ?>

				</ul>

			<?php }

			// Other
			elseif ( ! empty( $breadcrumbs_arr ) ) {

				if ( ! $args['show_last'] ) {
					$breadcrumbs_arr = array_slice( $breadcrumbs_arr, 0, -1 );
				}

				if ( ! $args['show_single'] && 1 === count( $breadcrumbs_arr ) ) {
					$breadcrumbs_arr = [];
				}

				foreach ( $breadcrumbs_arr as $item ) {
					if ( ! empty( $item['label'] ) ) {

						if ( ! empty( $item['url'] ) ) {
							$breadcrumbs_html .= '<li itemtype="http://schema.org/ListItem" itemscope="itemscope" itemprop="itemListElement"><a href="' . esc_url( $item['url'] ) . '" itemprop="item">' . sanitize_text_field( $item['label'] ) . '</a></li>';
						}
						else {
							$breadcrumbs_html .= '<li itemtype="http://schema.org/ListItem" itemscope="itemscope" itemprop="itemListElement">' . sanitize_text_field( $item['label'] ) . '</li>';
						}
					}
				}
				if ( $breadcrumbs_html !== '' ) {
					echo '<ul class="breadcrumbs" itemtype="http://schema.org/BreadcrumbList" itemscope="itemscope">' . $breadcrumbs_html . '</ul>';
				}

			}

		}

	}
}

/**
 * Main content of the page start block
 *
 * You can insert any code before Main with lsvr_lore_before_main hook in Child theme
 */
if ( ! function_exists( 'lsvr_lore_before_main' ) ) {
    function lsvr_lore_main_begin( $args = [] ){?>

    	<?php $defaults = array( 'sidebar_position' => 'disable', 'layout' => 'boxed', 'content_layout' => 'normal' ); ?>
    	<?php $args = wp_parse_args( $args, $defaults ); ?>

		<?php if ( 'boxed' === $args['layout'] ) : ?><div class="container"><?php endif; ?>

		<!-- PAGE WRAPPER : begin -->
		<div class="page-wrapper m-layout-<?php echo esc_attr( $args['layout'] ); ?><?php if ( 'disable' !== $args['sidebar_position'] ) { echo ' m-sidebar-' . $args['sidebar_position']; } ?>">
			<div class="page-wrapper-inner">
				<?php if ( 'fullwidth' === $args['layout'] ) : ?><div class="container"><?php endif; ?>

		<?php if ( 'disable' !== $args['sidebar_position'] ) : ?>
		<div class="row">
			<div class="column-content col-md-8<?php if ( 'left' === $args['sidebar_position'] ) { echo ' col-md-push-4'; } ?>">
		<?php endif; ?>

    	<?php // Add custom code before Main
    	do_action( 'lsvr_lore_main_before' ); ?>

		<!-- MAIN : begin -->
		<main id="main" class="m-layout-<?php echo esc_attr( $args['content_layout'] ); ?>" itemprop="mainContentOfPage" itemscope="itemscope">
			<div class="main-inner">

	<?php }
}

/**
 * Main content of the page end block
 *
 * You can insert any code after Main with lsvr_lore_after_main hook in Child theme
 */
if ( ! function_exists( 'lsvr_lore_after_main' ) ) {
    function lsvr_lore_main_end( $args = [] ){ ?>

    	<?php $defaults = array( 'sidebar_id' => '', 'sidebar_position' => 'disable', 'layout' => 'boxed' ); ?>
    	<?php $args = wp_parse_args( $args, $defaults ); ?>

			</div>
		</main>
		<!-- MAIN : end -->

    	<?php // Add custom code after Main
    	do_action( 'lsvr_lore_main_after' ); ?>

		<?php if ( 'disable' !== $args['sidebar_position'] ) : ?>
			</div>
			<div class="column-sidebar col-md-4<?php if ( 'left' === $args['sidebar_position'] ) { echo ' col-md-pull-8'; } ?>">

				<?php // PAGE SIDEBAR
				get_sidebar( $args['sidebar_id'] ); ?>

			</div>
		</div>
		<?php endif; ?>

				<?php if ( 'fullwidth' === $args['layout'] ) : ?></div><?php endif; ?>
			</div>
		</div>
		<!-- PAGE WRAPPER : end -->

		<?php if ( 'boxed' === $args['layout'] ) : ?></div><?php endif; ?>

	<?php }
}

/**
 * Main header
 *
 * Contains headline with breadcrumbs
 */
if ( ! function_exists( 'lsvr_lore_the_main_header' ) ) {
    function lsvr_lore_the_main_header( $args = [] ) { ?>

    	<?php $defaults = array( 'wrap_in_header' => true ); ?>
    	<?php $args = wp_parse_args( $args, $defaults ); ?>

    	<?php if ( true == $args['wrap_in_header'] ) : ?>
    		<header class="main-header">
		<?php else: ?>
			<div class="main-header">
		<?php endif; ?>

			<?php // BREADCRUMBS
			lsvr_lore_the_breadcrumbs( apply_filters( 'lsvr_lore_breadcrumbs_args', [] ) ); ?>

			<h1><?php // TITLE
			lsvr_lore_the_page_title( apply_filters( 'lsvr_lore_page_title_args', [] ) ); ?></h1>

		<?php if ( true == $args['wrap_in_header'] ) : ?>
    		</header>
		<?php else: ?>
			</div>
		<?php endif; ?>

	<?php }
}

/**
 * Get post rating values
 */
if ( ! function_exists( 'lsvr_lore_get_post_rating_values' ) ) {
    function lsvr_lore_get_post_rating_values( $post_id ) {

		$likes_count = '' !== get_post_meta( $post_id, 'lsvr_lore_likes_count', true ) ? (int) get_post_meta( $post_id, 'lsvr_lore_likes_count', true ) : 0;
		$likes_count_abb = lsvr_lore_abbreviate_number( $likes_count );
		$dislikes_count = '' !== get_post_meta( $post_id, 'lsvr_lore_dislikes_count', true ) ? (int) get_post_meta( $post_id, 'lsvr_lore_dislikes_count', true ) : 0;
		$dislikes_count_abb = lsvr_lore_abbreviate_number( $dislikes_count );
		$difference = $likes_count - $dislikes_count;
		$difference_abb = lsvr_lore_abbreviate_number( $difference );

		return array(
			'likes' => $likes_count,
			'likes_abb' => $likes_count_abb,
			'dislikes' => $dislikes_count,
			'dislikes_abb' => $dislikes_count_abb,
			'difference' => $difference,
			'difference_abb' => $difference_abb,
		);

    }
}

/**
 * Echo post rating values
 *
 * Get data from lsvr_lore_get_post_rating_values and generate HTML
 */
if ( ! function_exists( 'lsvr_lore_the_post_rating_values' ) ) {
    function lsvr_lore_the_post_rating_values( $post_id ) {

		if ( true == get_theme_mod( 'kb_rating_enable', true ) ) {

	    	$post_rating = lsvr_lore_get_post_rating_values( $post_id );
	    	$likes = (int) $post_rating['likes'];
	    	$likes_abb = $post_rating['likes_abb'];
	    	$dislikes = (int) $post_rating['dislikes'];
	    	$dislikes_abb = $post_rating['dislikes_abb'];
	    	$difference = (int) $post_rating['difference'];
	    	$difference_abb = $post_rating['difference_abb'];
	    	$html = '';

	    	// Likes & dislikes
			if ( true == get_theme_mod( 'kb_rating_dislikes_enable', true ) ) {

				// Difference
				if ( 'difference' === get_theme_mod( 'kb_rating_type', 'difference' ) && 0 !== $difference ) {
					$html .= $difference < 0 ? '<span class="dislikes"' : '<span class="likes"';
					$html .= 'title="' . esc_attr( sprintf( esc_html__( '%d likes, %d dislikes', 'lore' ), $likes, $dislikes ) ) . '">' . esc_html( $difference_abb ) . '</span>';
				}

				// Both
				else {
					$html .= ! empty( $likes ) ? '<span class="likes" title="' . esc_attr( sprintf( esc_html__( '%d likes', 'lore' ), $likes ) ) . '">' . esc_html( $likes_abb ) . '</span>' : '';
					$html .= ! empty( $dislikes ) ? '<span class="dislikes" title="' . esc_attr( sprintf( esc_html__( '%d dislikes', 'lore' ), $dislikes ) ) . '">' . esc_html( $dislikes_abb ) . '</span>' : '';
				}

			}

			// Likes only
			else {
				$html .= ! empty( $likes ) ? '<span class="likes">' . esc_attr( $likes_abb ) . '</span>' : '';
			}

			echo ! empty( $html ) ? '<span class="c-post-rating">' . $html . '</span>' : '';

    	}

    }
}

/**
 * Has post rating values
 *
 * Check if post was already rated
 */
if ( ! function_exists( 'lsvr_lore_has_post_rating_values' ) ) {
    function lsvr_lore_has_post_rating_values( $post_id ) {

		if ( true == get_theme_mod( 'kb_rating_enable', true ) ) {

			$likes_count = '' !== get_post_meta( $post_id, 'lsvr_lore_likes_count', true ) ? (int) get_post_meta( $post_id, 'lsvr_lore_likes_count', true ) : 0;
			$dislikes_count = '' !== get_post_meta( $post_id, 'lsvr_lore_dislikes_count', true ) ? (int) get_post_meta( $post_id, 'lsvr_lore_dislikes_count', true ) : 0;

			if ( 0 === $likes_count && 0 === $dislikes_count ) {
				return false;
			} else {
				return true;
			}

		} else {
			return false;
		}

    }
}

/**
 * Get Knowledge Base article icon class
 */
if ( ! function_exists( 'lsvr_lore_get_kb_post_icon_class' ) ) {
	function lsvr_lore_get_kb_post_icon_class( $post_id ) {

		$post_format = get_post_format( $post_id );

		$post_format_icon_defaults = array(
			'default' => 'loreico loreico-document',
			'gallery' => 'loreico loreico-gallery',
			'link' => 'loreico loreico-link',
			'image' => 'loreico loreico-picture',
			'video' => 'loreico loreico-video',
			'audio' => 'loreico loreico-music',
		);

		// Array items can be overriden via filter
		$post_format_icons = wp_parse_args( apply_filters( 'lsvr_lore_kb_post_format_icons', $post_format_icon_defaults ), $post_format_icon_defaults );

		if ( ! empty( $post_format_icons[ $post_format ] ) ) {
			$icon_class = $post_format_icons[ $post_format ];
		} else {
			$icon_class = $post_format_icons[ 'default' ];
		}

		return esc_attr( $icon_class );

	}
}

/**
 * The Knowledge Base article icon
 */
if ( ! function_exists( 'lsvr_lore_the_kb_post_icon' ) ) {
	function lsvr_lore_the_kb_post_icon( $post_id, $class ) {

		$icon_class = lsvr_lore_get_kb_post_icon_class( $post_id );
		$class = ! empty( $class ) ? $class . ' ' . $icon_class : $icon_class;
		echo '<i class="' . esc_attr( $class ) . '"></i>';

	}
}

/**
 * Get post attachment icon class
 */
if ( ! function_exists( 'lsvr_lore_get_post_attachment_icon_class' ) ) {
	function lsvr_lore_get_post_attachment_icon_class( $type, $subtype ) {

		$post_attachment_icon_defaults = array(
			'default' => 'fa fa-file-o',
			'image' => 'fa fa-file-image-o',
			'video' => 'fa fa-file-video-o',
			'audio' => 'fa fa-file-audio-o',
			'msword' => 'fa fa-file-word-o',
			'pdf' => 'fa fa-file-pdf-o',
		);

		// Array items can be overriden via filter
		$post_attachment_icons = wp_parse_args( apply_filters( 'lsvr_lore_post_attachment_icons', $post_attachment_icon_defaults ), $post_attachment_icon_defaults );

		if ( ! empty( $post_attachment_icons[ $type ] ) ) {
			$icon_class = $post_attachment_icons[ $type ];
		} elseif ( ! empty( $post_attachment_icons[ $subtype ] ) ) {
			$icon_class = $post_attachment_icons[ $subtype ];
		} else {
			$icon_class = $post_attachment_icons[ 'default' ];
		}

		return esc_attr( $icon_class );

	}
}

/**
 * Get post type icon class
 *
 * This icon will be used forsearch resutls listing
 */
if ( ! function_exists( 'lsvr_lore_get_post_type_icon_class' ) ) {
	function lsvr_lore_get_post_type_icon_class( $post_id ) {

		$post_type = get_post_type( $post_id );

		$post_type_icons_defaults = array(
			'lsvr_lore_faq' => 'loreico loreico-faq',
			'post' => 'loreico loreico-post',
			'page' => 'loreico loreico-page',
			'forum' => 'loreico loreico-bubbles2',
			'topic' => 'loreico loreico-bubbles2',
			'reply' => 'loreico loreico-bubbles2',
		);

		//* ---------- change classes in child theme --- */

		// Array items can be overriden via filter
		$post_type_icons = wp_parse_args( apply_filters( 'lsvr_lore_post_type_icons' ,$post_type_icons_defaults ), $post_type_icons_defaults );

		// If it's a Knowledge Base article
		if ( 'lsvr_lore_kb' === $post_type ) {
			$icon_class = lsvr_lore_get_kb_post_icon_class( $post_id );
		}

		// Known post types
		elseif ( ! empty( $post_type_icons[ $post_type ] ) ) {
			$icon_class = $post_type_icons[ $post_type ];
		}

		// Other
		else {
			$icon_class = $post_type_icons[ 'page' ];
		}

		return $icon_class;

	}
}

/**
 * The post type icon
 */
if ( ! function_exists( 'lsvr_lore_the_post_type_icon' ) ) {
	function lsvr_lore_the_post_type_icon( $post_id, $class ) {

		$icon_class = lsvr_lore_get_post_type_icon_class( $post_id );
		$class = ! empty( $class ) ? $class . ' ' . $icon_class : $icon_class;
		echo '<i class="' . esc_attr( $class ) . '"></i>';

	}
}

/**
 * Echo social links
 */
if ( ! function_exists( 'lsvr_lore_the_social_links' ) ) {
	function lsvr_lore_the_social_links() {

		$social_links = array_filter( get_theme_mod( 'social_links', array(
			array(
				'link_title' => 'Twitter',
				'link_icon' => 'fa fa-twitter',
				'link_url' => '#',
			),
			array(
				'link_title' => 'Facebook',
				'link_icon' => 'fa fa-facebook',
				'link_url' => '#',
			),
		)));

		if ( ! empty( $social_links ) ) {

			$link_target_att = true == get_theme_mod( 'social_links_target', true ) ? ' target="_blank"' : '';
			$html = '';

			foreach ( $social_links as $key => $item ) {
				if ( ! empty( $item['link_url'] ) ) {

					$link_title = ! empty( $item['link_title'] ) ? $item['link_title'] : '';
					$link_title_att = '' !== $link_title ? ' title="' . esc_attr( $link_title ) . '"' : '';

					$html .= '<li><a href="' . esc_url( $item['link_url'] ) . '"' . $link_target_att . $link_title_att . '>';
					$html .= ! empty( $item['link_icon'] ) ? '<i class="' . esc_attr( $item['link_icon'] ) . '"></i>' : esc_attr( $link_title );
					$html .= '</a></li>';

				}
			}

			if ( '' !== $html ) {
				echo '<ul class="social-links">' . $html . '</ul>' . "\r\n";
			}

		}

	}
}

/**
 * Check if the current page is one of blog pages
 */
if ( ! function_exists( 'lsvr_lore_is_blog' ) ) {
    function lsvr_lore_is_blog() {

    	if ( is_home() || is_author() || is_category() || is_singular( 'post' ) || is_tag() || is_author() || is_year() || is_day() || is_month() ) {
    		return true;
    	}
    	else {
    		return false;
    	}

    }
}

/**
 * Check if Knowledge Base page is being displayed
 */
if ( ! function_exists( 'lsvr_lore_is_knowledgebase' ) ) {
    function lsvr_lore_is_knowledgebase() {

		if ( is_post_type_archive( 'lsvr_lore_kb' ) || is_singular( 'lsvr_lore_kb' ) || is_tax( 'lsvr_lore_kb_cat' ) || is_tax( 'lsvr_lore_kb_tag' ) ) {
			return true;
		}
		else {
			return false;
		}

    }
}

/**
 * Check if FAQ page is being displayed
 */
if ( ! function_exists( 'lsvr_lore_is_faq' ) ) {
    function lsvr_lore_is_faq() {

		if ( is_post_type_archive( 'lsvr_lore_faq' ) || is_singular( 'lsvr_lore_faq' ) || is_tax( 'lsvr_lore_faq_cat' ) || is_tax( 'lsvr_lore_faq_tag' ) ) {
			return true;
		}
		else {
			return false;
		}

    }
}

/**
 * Get number of query results
 */
if ( ! function_exists( 'lsvr_lore_get_query_post_count' ) ) {
    function lsvr_lore_get_query_post_count() {
    	global $wp_query;
    	return ! empty( $wp_query->found_posts ) ? $wp_query->found_posts : 0;
    }
}

/**
 * Get array with image data
 */
if ( ! function_exists( 'lsvr_lore_get_image_data' ) ) {
    function lsvr_lore_get_image_data( $image_id ) {

        $image_data = [];
        $image_sizes = array( 'thumbnail', 'medium', 'large', 'full' );

        foreach ( $image_sizes as $size ) {
            $temp = wp_get_attachment_image_src( $image_id, $size );
            $image_data[$size] = $temp[0];
        }

		// get Alt
        $image_data['alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

		// Get Title
        $image_meta = wp_get_attachment_metadata( $image_id );
        if ( ! empty( $image_meta['title'] ) ) {
            $image_data['title'] = $image_meta['title'];
        }
        else {
            $image_data['title'] = '';
        }

		// Get Caption
		$image_post_data = get_post( $image_id );
		if ( $image_post_data && is_object( $image_post_data ) ) {
			$image_data['caption'] = $image_post_data->post_excerpt;
		}
		else {
			$image_data['caption'] = '';
		}

        if ( count( $image_data ) > 0 ) {
            return $image_data;
        }
        else {
            return false;
        }

    }
}

/**
 * Get parents of taxonomy term
 */
if ( ! function_exists( 'lsvr_lore_get_term_parents' ) ) {
	function lsvr_lore_get_term_parents( $term_id, $taxonomy, $max_limit = 5 ) {

		$term = get_term( $term_id, $taxonomy );
		if ( 0 !== $term->parent ) {

			$parents_arr = [];
			$counter = 0;
			$parent_id = $term->parent;

			while ( 0 !== $parent_id && $counter < $max_limit ) {
				array_unshift( $parents_arr, $parent_id );
				$parent = get_term( $parent_id, $taxonomy );
				$parent_id = $parent->parent;
				$counter++;
			}
			return $parents_arr;

		}
		else {
			return false;
		}

	}
}

/**
 * Abbreviate the number
 *
 * For example: 1500 = 1.5K
 */
if ( ! function_exists( 'lsvr_lore_abbreviate_number' ) ) {
	function lsvr_lore_abbreviate_number( $number ) {
		$postfixes = array( '', 'K', 'M' );
		$number = abs( (int) $number );
		if ( 0 !== $number ) {
			$postfix_index = abs( floor( log( $number, 1000 ) ) > 2 ? 2 : floor( log( $number, 1000 ) ) );
			return round( $number / pow( 1000, $postfix_index ), 1 ) . $postfixes[ $postfix_index ];
		} else {
			return $number;
		}
	}
}

?>