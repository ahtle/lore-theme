/**
 * Table of contents
 *
 * 1. General
 * 2. Components
 * 3. Header
 * 4. Core
 * 5. Widgets
 * 6. Other
 * 7. Style Switcher
 */

(function($){ "use strict";
$(document).ready(function(){

/* -----------------------------------------------------------------------------

	1. GENERAL

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		Check for touch display
	------------------------------------------------------------------------- */

	$( 'body' ).one( 'touchstart', function(){
		$(this).addClass( 'm-touch' );
	});

	/* -------------------------------------------------------------------------
		Make Iframe and Embed elements fluid
	------------------------------------------------------------------------- */

	if ( $.fn.lsvrLoreFluidEmbedMedia && 'undefined' !== typeof lsvr_lore_fluid_elements ) {
		$( 'body' ).lsvrLoreFluidEmbedMedia( lsvr_lore_fluid_elements );
	}

	/* -------------------------------------------------------------------------
		Lightbox
		Based on Magnific Popup
	------------------------------------------------------------------------- */

	if ( $.fn.magnificPopup && $( 'body' ).hasClass( 'm-default-lightbox' ) ) {

		// Edit lightbox strings
		if ( 'undefined' !== typeof lsvr_lore_js_strings ) {
			var js_strings = lsvr_lore_js_strings;
			$.extend( true, $.magnificPopup.defaults, {
				tClose: js_strings.mp_tClose,
				tLoading: js_strings.mp_tLoading,
				gallery: {
					tPrev: js_strings.mp_tPrev,
					tNext: js_strings.mp_tNext,
					tCounter: '%curr% / %total%'
				},
				image: {
					tError: js_strings.mp_image_tError,
				},
				ajax: {
					tError: js_strings.mp_ajax_tError,
				}
			});
		}

		// Init lightbox
		$( 'body' ).find( 'a.lightbox, .post-content .gallery-item a' ).magnificPopup({
			type: 'image',
			removalDelay: 300,
			mainClass: 'mfp-fade',
			gallery: {
				enabled: true
			}
		});

	}

	/* -------------------------------------------------------------------------
		Media query breakpoint
		Check the current screen breakpoint to synchronize JS with CSS
	------------------------------------------------------------------------- */

	var lsvrLoreMediaQueryBreakpoint;
	if ( $.fn.lsvrLoreGetMediaQueryBreakpoint ) {
		lsvrLoreMediaQueryBreakpoint = $.fn.lsvrLoreGetMediaQueryBreakpoint();
		$(window).resize(function(){
			if ( $.fn.lsvrLoreGetMediaQueryBreakpoint() !== lsvrLoreMediaQueryBreakpoint ) {
				lsvrLoreMediaQueryBreakpoint = $.fn.lsvrLoreGetMediaQueryBreakpoint();
				$.event.trigger({
					type: 'screenTransition',
					message: 'Screen transition completed.',
					time: new Date()
				});
			}
		});
	}
	else {
		lsvrLoreMediaQueryBreakpoint = $(document).width();
	}


/* -----------------------------------------------------------------------------

	2. COMPONENTS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		Accordion
	------------------------------------------------------------------------- */

	if ( $.fn.lsvrLoreAccordion ) {
		$( '.c-accordion' ).each(function(){
			$(this).lsvrLoreAccordion();
		});
	}

	/* -------------------------------------------------------------------------
		Content grid
	------------------------------------------------------------------------- */

	if ( $.fn.masonry ) {
		$( '.c-content-grid.m-masonry:not( .m-1-columns ) .brick-list' ).each(function(){

			var $this = $(this),
				isRTL = $( 'html' ).attr( 'dir' ) && 'rtl' === $( 'html' ).attr( 'dir' ) ? true : false;

			$this.masonry({
				isRTL: isRTL
			});

			if ( $.fn.lsvrLoreImagesLoaded ) {
				$this.lsvrLoreImagesLoaded(function(){
					$this.masonry( 'reloadItems' );
				});
			}

		});
	}

	/* -------------------------------------------------------------------------
		Contents
	------------------------------------------------------------------------- */

	$( '.c-contents' ).each(function(){

		var $this = $(this),
			$pageContent = $this.parents( '.post-content' ).length > 0 ? $this.parents( '.post-content' ) : $( '#main' ).find( '.post-content' ).first(),
			excludedIds = $this.data( 'excluded-ids' ) ? $this.data( 'excluded-ids' ) : '',
			headings = $pageContent.find( 'h1[id], h2[id], h3[id], h4[id], h5[id], h6[id]' ),
			chapters = [],
			html = '';

		// Exclude headings
		if ( excludedIds !== '' ) {
			excludedIds = excludedIds.split( ',' );
			var excludedSelector = [];
			for ( var i = 0; i < excludedIds.length; i++ ) {
				excludedSelector.push( '[id=' + excludedIds[i] + ']' );
			}
			headings = headings.not( excludedSelector.join( ',' ) );
		}

		// Parse headings
		headings.each(function(){
			var title = $(this).attr( 'title' ) && '' !== $(this).attr( 'title' ) ? $(this).attr( 'title' ) : $(this).text();
			chapters.push({ id: $(this).attr( 'id' ), title: title, tag: $(this).prop( 'tagName' ) });
		});

		// Create HTML
		if ( chapters.length > 0 ) {
			html = '<ul class="contents-chapters">';
			for ( var i = 0; i < chapters.length; i++ ) {
				var tagName = chapters[i].tag;
				html += '<li class="m-element-type-' + tagName.toLowerCase() + '"><a href="#' + chapters[i].id + '">' + chapters[i].title + '</li>';
			}
			html += '</ul>';
			$this.find( '.contents-inner' ).append( html );
			$this.slideToggle( 150 );
		}
		else {
			$this.remove();
		}

	});

	/* -------------------------------------------------------------------------
		FAQ list
	------------------------------------------------------------------------- */

	$( '.c-faq-list .faq-list-items' ).each(function(){

		var $this = $(this),
			items = $this.find( '.post-item' );

		items.each(function(){

			var $item = $(this),
				$title = $item.find( '.post-title' ),
				$content = $item.find( '.post-content' );

			$title.on( 'click', function(){

				$item.toggleClass( 'm-active' );
				$content.slideToggle( 150 );
				return false;

			});

		});

	});

	/* -------------------------------------------------------------------------
		GOOGLE MAP
	------------------------------------------------------------------------- */

	if ( $.fn.lsvrLoreLoadGoogleMaps  ) {
		$.fn.lsvrLoreLoadGoogleMaps();
	}

	/* -------------------------------------------------------------------------
		Tabs
	------------------------------------------------------------------------- */

	if ( $.fn.lsvrLoreTabs ) {
		$( '.c-tabs' ).each(function(){
			$(this).lsvrLoreTabs();
		});
	}


/* -----------------------------------------------------------------------------

	3. HEADER

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		Header scrolled
	------------------------------------------------------------------------- */

	if ( $( '#header' ).hasClass( 'm-fixed-navbar' ) ) {
		if ( $( document ).scrollTop() >= 5 ) {
			$( 'body' ).addClass( 'm-scrolled' );
		}
		$( document ).scroll(function(){
			$( 'body' ).toggleClass( 'm-scrolled', $( document ).scrollTop() >= 5 );
		});
	}

	/* -------------------------------------------------------------------------
		Header search
	------------------------------------------------------------------------- */

	$( '.header-search-form' ).each(function(){

		var $form = $(this),
			$input = $form.find( '.text-input' ),
			$searchSuggestions = $form.find( '.header-search-suggestions' ),
			$searchOptions = $form.find( '.header-search-options' );

		// Search suggestions
		if ( $form.hasClass( 'm-ajaxed' ) ) {
			$searchSuggestions.find( 'a' ).each(function(){
				$(this).on( 'click', function(){
					$input.val( $(this).data( 'search-keyword' ) ).focus();
					return false;
				});
			});
		}

		// Show search options on focus
		$input.on( 'focus', function(){
			$searchOptions.slideDown( 150 );
		});

		// Hide search options
		$(document).on( 'click', function(e) {
			if ( ! $( e.target ).closest( '.header-search-form' ).length ) {
				$searchOptions.slideUp( 150 );
			}
		});
		$( '.header-search-mobile-close' ).on( 'click', function(){
			$searchOptions.slideUp( 150 );
		});

		// Search filter
		var refreshSearchFilter = function( checkbox ){
			if ( true === checkbox.prop( 'checked' ) || 'checked' === checkbox.prop( 'checked' ) ) {

				checkbox.parent().addClass( 'm-active' );

				// Filter all
				if ( checkbox.attr( 'id' ).indexOf( 'header-search-filter-type-any' ) >= 0 ) {
					$searchOptions.find( 'input:not( [id^=header-search-filter-type-any] )' ).prop( 'checked', false ).change();
				}

				// Filter others
				else {
					$searchOptions.find( 'input[id^=header-search-filter-type-any]' ).prop( 'checked', false ).change();
				}

			} else {

				checkbox.parent().removeClass( 'm-active' );

				// Filter All if there is not other filter active
				if ( $searchOptions.find( 'input:checked' ).length < 1 ) {
					$searchOptions.find( 'input[id^=header-search-filter-type-any]' ).prop( 'checked', true ).change();
				}

			}

		};
		$searchOptions.find( 'input' ).each(function(){
			refreshSearchFilter( $(this) );
			$(this).on( 'change', function(){
				refreshSearchFilter( $(this) );
			});
		});

	});

	/* -------------------------------------------------------------------------
		Compact header search
	------------------------------------------------------------------------- */

	$( '.header-compact-search' ).each(function(){

		var $this = $(this),
			$toggle = $this.find( '> .toggle' ),
			$holder = $this.find( '.header-compact-search-form-holder' );

		// Toggle
		$toggle.on( 'click', function(){
			$this.toggleClass( 'm-active' );
			$holder.slideToggle( 150, function(){
				// Focus
				if ( $holder.is( ':visible' ) ) {
					$holder.find( '.text-input' ).focus();
				}

			} );
		});

		// Hide
		$(document).on( 'click', function(e) {
			if ( ! $( e.target ).closest( '.header-compact-search' ).length ) {
				$this.removeClass( 'm-active' );
				$holder.slideUp( 150 );
			}
		});

	});

	/* -------------------------------------------------------------------------
		Header toggle
	------------------------------------------------------------------------- */

	$( '.header-mobile-toggle' ).each(function(){

		var $this = $(this),
			$headerSearch = $( '.header-search' ),
			$headerMenu = $( '.header-menu-holder' );

		$this.click( function() {

			// Hide
			if ( $this.hasClass( 'm-active' ) ) {
				$headerSearch.slideUp(300);
				$headerMenu.slideUp( 300, function(){
					$( '#header' ).removeClass( 'm-mobile-menu-expanded' );
				});
				$this.removeClass( 'm-active' );
			}
			// Show
			else {
				$headerSearch.slideDown(300);
				$headerMenu.slideDown(300);
				$( '#header' ).addClass( 'm-mobile-menu-expanded' );
				$this.addClass( 'm-active' );
			}

		});

		// Reset on screen transition
		$( document ).on( 'screenTransition', function(){
			$this.removeClass( 'm-active' );
			$( '#header' ).removeClass( 'm-mobile-menu-expanded' );
			$( '.header-menu, .header-menu-holder, .header-search' ).removeAttr( 'style' );
		});

	});

	/* -------------------------------------------------------------------------
		Header menu
	------------------------------------------------------------------------- */

	$( '.header-menu ul > li:last-child' ).prev().addClass( 'm-penultimate' );
	$( '.header-menu ul > li:last-child' ).addClass( 'm-last' );


	if ( ! $.fn.lsvrHeaderMenuSubmenu ) {
		$.fn.lsvrHeaderMenuSubmenu = function(){

			var	$this = $(this),
				$parent = $this.parent();

			$parent.addClass( 'm-has-submenu' );

			// Hover
			$parent.hover(function(){
				if ( lsvrLoreMediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.addClass( 'm-hover' );
					$this.fadeIn( 150 );
				}
			}, function(){
				if ( lsvrLoreMediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.removeClass( 'm-hover' );
					$this.fadeOut( 150 );
				}
			});

			// Click on touch display
			$parent.find( '> a' ).click(function(){
				if ( lsvrLoreMediaQueryBreakpoint > 991 && ! $parent.hasClass( 'm-hover' ) ) {

					if ( $(this).parents( 'ul' ).length < 2 ) {
						$( '.header-menu li.m-hover' ).each(function(){
							$(this).removeClass( 'm-hover' );
							$(this).find( '> ul' ).hide();
						});
					}

					$parent.addClass( 'm-hover' );
					$this.show();

					$( 'html' ).on( 'touchstart', function(e) {
						$parent.removeClass( 'm-hover' );
						$this.hide();
					});

					$parent.on( 'touchstart' ,function(e) {
						e.stopPropagation();
					});

					return false;

				}
			});

			// Create toggles
			if ( $parent.find( '> .toggle' ).length < 1 ) {
				$parent.append( '<button class="submenu-toggle" type="button"><i class="fa"></i></button>' );
			}
			var $toggle = $parent.find( '> .submenu-toggle' );

			// Togle
			$toggle.click( function(){

				// Close
				if ( $(this).hasClass( 'm-active' ) ) {
					$toggle.removeClass( 'm-active' );
					$this.slideUp( 150 );
				}

				// Open
				else {

					// Deactivate others
					if ( $(this).parents( 'ul' ).length < 2 ) {
						$( '.header-menu nav > ul > li > .submenu-toggle.m-active' ).each(function(){
							$(this).removeClass( 'm-active' );
							$(this).parent().find( '> ul' ).slideUp( 150 );
						});
					}

					// Activate this
					$toggle.addClass( 'm-active' );
					$this.slideDown( 150 );

				}

			});

			// Reset on screen transition
			$( document ).on( 'screenTransition', function(){
				$toggle.removeClass( 'm-active' );
				$this.removeAttr( 'style' );
			});

		};
	}
	$( '.header-menu ul > li > ul' ).each(function(){
		if ( ! $(this).is( ':visible' ) ) {
			$(this).lsvrHeaderMenuSubmenu();
		}
	});


/* -----------------------------------------------------------------------------

	4. CORE

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		Knowledge Base archive masonry
	------------------------------------------------------------------------- */

	if ( $.fn.masonry ) {

		var isRTL = $( 'html' ).attr( 'dir' ) && 'rtl' === $( 'html' ).attr( 'dir' ) ? true : false;

		$( '.page-kb-post-archive-category-view.m-masonry:not( .m-1-columns ) .category-list' ).masonry({
			isRTL: isRTL
		});
	}

	/* -------------------------------------------------------------------------
		FAQ post list accordion
	------------------------------------------------------------------------- */

	$( '.faq-post-list-accordion' ).each(function(){

		var $this = $(this),
			items = $this.find( '.post-item' );

		items.each(function(){

			var $item = $(this),
				$title = $item.find( '.post-title' ),
				$content = $item.find( '.post-content' );

			$title.on( 'click', function(){

				$item.toggleClass( 'm-active' );
				$content.slideToggle( 150 );
				return false;

			});

		});

	});

/* -----------------------------------------------------------------------------

	5. WIDGETS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		Knowledge Base category widget
	------------------------------------------------------------------------- */

	$( '.widget.lsvr-kb-categories' ).each(function(){

		var $this = $(this);

		// Expand all parents of current category
		$this.find( '.m-current-cat' ).each(function(){
			$(this).parents( 'li.cat-item' ).addClass( 'm-current-cat-ancestor' );
		});
		$this.find( '.m-current-post' ).each(function(){
			$(this).parents( 'li.cat-item' ).addClass( 'm-current-post-ancestor' );
		});

		// Toggle button
		$this.find( '.children-holder' ).filter(function(){
		    return $.trim(this.innerHTML) === '';
		}).remove();
		$this.find( '.children-holder' ).each(function(){

			var $children = $(this),
				$parent = $(this).parent(),
				$toggle;

			$parent.addClass( 'm-has-children' );
			if ( ! ( $parent.hasClass( 'm-current-post-ancestor' ) || $parent.hasClass( 'm-current-cat-ancestor' ) || $parent.hasClass( 'm-current-cat' ) ) ) {

				$parent.append( '<button type="button" class="toggle"><i class="fa"></i></button>' );

				// Click action
				$toggle = $parent.find( '> .toggle' );
				$toggle.on( 'click', function(){
					$children.slideToggle( 150, function(){

						// If this widget is inside Content Grid in content, refresh masonry
						if ( $.fn.masonry ) {
							var isRTL = $( 'html' ).attr( 'dir' ) && 'rtl' === $( 'html' ).attr( 'dir' ) ? true : false;
							$this.parents( '.brick-list.masonry' ).masonry({ isRTL: isRTL });
							$this.parents( '.brick-list.masonry' ).masonry( 'reloadItems' );
						}

					});
					$toggle.toggleClass( 'm-active' );
				});

			}

		});

	});

	/* -------------------------------------------------------------------------
		Custom Menu widget
	------------------------------------------------------------------------- */

	$( '.widget.widget_nav_menu' ).each(function(){

		var $this = $(this);

		// Expand all parents of current page
		$this.find( 'li[class*="current"]' ).each(function(){
			$(this).parents( 'li' ).addClass( 'm-current-item-ancestor' );
		});

		// Add toggle functionality
		$this.find( '.sub-menu' ).each(function(){

			var $submenu = $(this),
				$parent = $submenu.parent();

			if ( ! $parent.hasClass( 'm-current-item-ancestor' ) && ! $parent.hasClass( 'current-menu-item' ) ) {

				$parent.addClass( 'm-has-submenu' );
				$parent.append( '<button type="button" class="toggle"><i class="fa"></i></button>' );

				// Toggle
				$parent.find( '> .toggle' ).on( 'click', function(){
					$submenu.slideToggle( 150, function(){

						// If this widget is inside Content Grid in content, refresh masonry
						if ( $.fn.masonry ) {
							var isRTL = $( 'html' ).attr( 'dir' ) && 'rtl' === $( 'html' ).attr( 'dir' ) ? true : false;
							$this.parents( '.brick-list.masonry' ).masonry({ isRTL: isRTL });
							$this.parents( '.brick-list.masonry' ).masonry( 'reloadItems' );
						}

					});
					$(this).toggleClass( 'm-active' );
				});

			}

		});

	});


/* -----------------------------------------------------------------------------

	6. OTHER

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		bbPress reset password
	------------------------------------------------------------------------- */

	$( '.login-forgot-pass-btn' ).on( 'click', function(){
		$( '.login-forgot-pass-form' ).slideToggle( 150 );
		return false;
	});

	/* -------------------------------------------------------------------------
		Move DWQA Breadcrumbs
	------------------------------------------------------------------------- */

	$( '.dwqa-container .dwqa-breadcrumbs' ).prependTo( '#main .main-header' );
	$( '.dwqa-breadcrumbs .dwqa-sep' ).last().hide();

	/* -------------------------------------------------------------------------
		Scroll animation on anchor links
	------------------------------------------------------------------------- */

	$( '.footer-scroll-top a, .c-contents a[href^="#"], .header-menu a[href^="#"], .footer-menu a[href^="#"]' ).each(function(){

		var $this = $(this),
			href = $(this).attr( 'href' ),
			hash = href.substr( href.indexOf( '#' ) );

		if ( $( hash ).length > 0 ) {
			$this.click(function(e){
				var offset = lsvrLoreMediaQueryBreakpoint > 991 && $( '#header' ).hasClass( 'm-fixed-navbar' ) ? 100 : 0;
				$( 'html, body' ).animate({
					'scrollTop' : $( hash ).offset().top - offset
				}, 200 );
			});
		}

	});

});
})(jQuery);


/* -----------------------------------------------------------------------------

	7. STYLE SWITCHER

----------------------------------------------------------------------------- */

(function($){ "use strict";
$(document).ready(function(){

	var enableStyleSwitcher = $( 'body' ).hasClass( 'm-style-switcher' ),
		templateDirectoryUri = typeof lsvr_lore_template_directory_uri !== 'undefined' ? lsvr_lore_template_directory_uri : false;

	if ( enableStyleSwitcher && templateDirectoryUri ) {

		// CREATE STYLE SWITCHER
		var styleSwitcherHtml = '<div id="style-switcher"><button class="style-switcher-toggle"><i class="ico fa fa-tint"></i></button>';
			styleSwitcherHtml += '<div class="style-switcher-content"><ul class="skin-list">';
			styleSwitcherHtml += '<li><button class="skin-1 m-active" data-skin="green"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-2" data-skin="orange"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-3" data-skin="cyan"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-4" data-skin="yellow"></button></li>';
			styleSwitcherHtml += '</ul></div></div>';
		$( 'body' ).append( styleSwitcherHtml );

		// INIT SWITCHER
		$( '#style-switcher' ).each(function(){

			var switcher = $(this),
				toggle = switcher.find( '.style-switcher-toggle' ),
				skins = switcher.find( '.skin-list button' ),
				switches = switcher.find( '.switch-list button' );

			// TOGGLE SWITCHER
			toggle.click(function(){
				switcher.toggleClass( 'm-active' );
			});

			// SET SKIN
			skins.click(function(){
				skins.filter( '.m-active' ).removeClass( 'm-active' );
				$(this).toggleClass( 'm-active' );
				if ( $( 'head #skin-temp' ).length < 1 ) {
					$( 'head' ).append( '<link id="lsvr-lore-color-switcher-skin" rel="stylesheet" type="text/css" href="' + templateDirectoryUri + '/library/css/skin/' + $(this).data( 'skin' ) + '.css">' );
				}
				else {
					$( '#lsvr-lore-color-switcher-skin' ).attr( 'href',  templateDirectoryUri + '/library/css/skin/' + $(this).data( 'skin' ) + '.css' );
				}
			});

		});

	}

});
})(jQuery);