/**
 * Ajax search
 */
(function($){ "use strict";
$(document).ready(function(){

	// Trigger search
	$( '.header-search-form.m-ajaxed' ).each(function(){

		var $form = $(this),
			$input = $form.find( '.text-input' ),
			$filter = $form.find( '.header-search-filter' ),
			searchQuery = '',
			postType,
			postTypeArr = [];

		// Post type filter
		$filter.find( 'input:checked' ).each(function(){
			postTypeArr.push( $(this).val() );
		});
		postType = postTypeArr.length < 1 ? 'any' : postTypeArr.join();
		postTypeArr = [];

		// Change, keyup & paste events
		$input.on( 'change keyup paste', function(e){

			var newSearchQuery = $(this).val();
			if ( ( newSearchQuery !== searchQuery ) && ! ( 38 === e.which || 40 === e.which || 13 === e.which ) ) {
				searchQuery = newSearchQuery.trim();
				lsvrLoreAjaxSearchGetResults( $form, postType, searchQuery );
			}

		});

		// Focus event
		$input.on( 'focus', function(e){

			var newSearchQuery = $(this).val();

			// Show already existing but hidden search results
			if ( ( newSearchQuery === searchQuery ) && $form.find( '.header-search-results' ).length > 0 ) {
				$form.find( '.header-search-results' ).slideDown( 300 );
			}
			// If there are no results, send request
			else {
				searchQuery = newSearchQuery.trim();
				lsvrLoreAjaxSearchGetResults( $form, postType, searchQuery );
			}

		});

		// Change post type filter
		$filter.find( 'input[type="checkbox"]' ).on( 'change', function(){

			$filter.find( 'input:checked' ).each(function(){
				postTypeArr.push( $(this).val() );
			});
			postType = postTypeArr.length < 1 ? 'any' : postTypeArr.join();
			postTypeArr = [];

			lsvrLoreAjaxSearchGetResults( $form, postType, searchQuery );

		});

		// Keyboard navigation
		$input.on( 'keydown', function(e){

			var $searchResults = $form.find( '.header-search-results' ),
				$active = $searchResults.find( '.m-active' );

			// Arrow down
			if ( 40 === e.which ) {

				if ( $active.length < 1 || $active.filter( ':last-child' ).length ) {
					$active.removeClass( 'm-active' );
					$searchResults.find( 'ul > li:first-child' ).addClass( 'm-active' );
				}
				else {
					$active.removeClass( 'm-active' );
					$active.next().addClass( 'm-active' );
				}

				e.preventDefault();
                e.stopPropagation();

			}

			// Arrow up
			if ( 38 === e.which ) {

				if ( $active.length < 1 || $active.filter( ':first-child' ).length ) {
					$active.removeClass( 'm-active' );
					$searchResults.find( 'ul > li:last-child' ).addClass( 'm-active' );
				}
				else {
					$active.removeClass( 'm-active' );
					$active.prev().addClass( 'm-active' );
				}

				e.preventDefault();
                e.stopPropagation();

			}

			// Enter
			if ( 13 === e.which ) {

				if ( $active.length ) {
					window.location.href = $active.find( 'a' ).attr( 'href' );
					e.preventDefault();
                	e.stopPropagation();
				}

			}

		});

	});

	// Get search results
	var lsvrLoreAjaxRequest;
	function lsvrLoreAjaxSearchGetResults( $form, postType, searchQuery ) {

		searchQuery = searchQuery.trim();

		// Check minimum search query length
		if ( searchQuery.length > 1 ) {

			// Delay before sending request
			clearTimeout( $form.data( 'ajax-search-timer' ) );
			$form.data( 'ajax-search-timer', setTimeout( function(){

				$form.addClass( 'm-loading' );

		        // Ajax request
		        if ( null != lsvrLoreAjaxRequest ) { lsvrLoreAjaxRequest.abort(); }
		        lsvrLoreAjaxRequest = jQuery.ajax({
		            type: 'post',
		            url: lsvr_lore_ajax_search_var.url,
		            data: 'action=lsvr-lore-ajax-search&nonce=' + lsvr_lore_ajax_search_var.nonce + '&post_type=' + postType + '&search_query=' + searchQuery,
		            success: function( response ){

		            	if ( '' !== response ) {

							var responseJson = false;

		            		// Parse JSON
		            		try {
								responseJson = JSON.parse( response );
								//log( 'Lore Ajax Search Response: JSON OK' );
							}

							// Invalid response
							catch(e) {
								log( 'Lore Ajax Search Response: INVALID JSON' );
							}

							// Show results
							if ( responseJson ) {
								lsvrLoreAjaxSearchShowResults( $form, responseJson );
							}

		            	} else {
		            		log( 'Lore Ajax Search Response: BLANK' );
		            	}

						$form.removeClass( 'm-loading' );

		            },
		            error: function(){
		            	$form.removeClass( 'm-loading' );
						log( 'Lore Ajax Search Response: ERROR' );
		            }
		        });

	        }, 500 ));

		}

	}

	// Show search results
	function lsvrLoreAjaxSearchShowResults( $form, json ) {
		if ( json.hasOwnProperty( 'status' ) ) {

			var status = json.status,
				$input = $form.find( '.text-input' ),
				output = '';

			// If has results
			if ( 'ok' === status && json.hasOwnProperty( 'results' ) ) {

				$.each( json.results, function(){

					var rating = '';

					if ( this.hasOwnProperty( 'post_title' ) && this.hasOwnProperty( 'icon_class' ) && this.hasOwnProperty( 'permalink' ) && this.hasOwnProperty( 'post_type' ) ) {

						output += '<li><a href="' + this.permalink + '" class="m-post-type-' + this.post_type + '">'
						output += '<i class="ico ' + this.icon_class + '"></i>' + this.post_title;

						// Post rating
						if ( this.hasOwnProperty( 'likes' ) || this.hasOwnProperty( 'dislikes' ) || this.hasOwnProperty( 'difference' ) ) {

							// Likes
							if ( this.hasOwnProperty( 'likes' ) ) {
								rating += '<span class="likes">' + this.likes + '</span>';
							}

							// Dislikes
							if ( this.hasOwnProperty( 'dislikes' ) ) {
								rating += '<span class="dislikes">' + this.dislikes + '</span>';
							}

							// Difference
							if ( this.hasOwnProperty( 'difference' ) && this.hasOwnProperty( 'difference_abb' ) ) {
								rating += this.difference < 0 ? '<span class="dislikes difference">' : '<span class="likes difference">';
								rating += this.difference_abb + '</span>';
							}

							// Wrap rating in HTML
							if ( '' !== rating ) {
								output += '<span class="c-post-rating">' + rating + '</span>';
							}

						}

						output += '</a></li>';

					}

				});
				output = '<ul class="results-list">' + output + '</ul>';

				// More link
				if ( json.hasOwnProperty( 'more_label' ) && json.hasOwnProperty( 'more_link' ) ) {
					output += '<p class="more-link"><a href="' + json.more_link + '">' + json.more_label + '</a></p>';
				}


			}

			// No results
			else if ( 'noresults' === status ) {
				var message = json.hasOwnProperty( 'message' ) ? json.message : '';
				if ( '' !== message ) {
					output = '<p class="results-message">' + message + '</p>';
				}
			}

			// Display results
			if ( '' !== output ) {

				if ( $form.find( '.header-search-results' ).length > 0 ) {
					$form.find( '.header-search-results' ).first().html( output );
				} else {
					$form.find( '.header-search-options' ).append( '<div class="header-search-results">' + output + '</div>' );
				}
				if ( $form.find( '.header-search-results' ).is( ':hidden' ) ) {
					$form.find( '.header-search-results' ).slideDown( 300 );
				}

			}

		}
	}

});
})(jQuery);