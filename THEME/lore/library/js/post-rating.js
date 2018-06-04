/**
 * Post rating
 */
(function($){ "use strict";
$(document).ready(function(){

	$( '.post-rating' ).each(function(){

		var $this = $(this),
			postId = $this.data( 'post-id' ),
			$likeBtn = $this.find( 'button.like' ),
			$dislikeBtn = $this.find( 'button.dislike' ),
			$loadingAnim = $this.find( '.loading-animation' );

		// Rate post
		function ratePost( rating ){
			if ( ! $this.hasClass( 'm-loading' ) ) {

				$this.addClass( 'm-loading' );
				$this.find( '.c-alert-message' ).slideUp( 150 );

		        // Ajax query
		        jQuery.ajax({
		            type: 'post',
		            url: lsvr_lore_ajax_rating_var.url,
		            data: 'action=lsvr-lore-kb-post-rating&nonce=' + lsvr_lore_ajax_rating_var.nonce + '&lsvr_lore_kb_post_rating=&post_id=' + postId + '&rating_type=' + rating,
		            success: function( response ){
		            	if ( response !== '' ) {

			            	response = JSON.parse( response );

			            	// Update front-end counts and
			            	if ( response.hasOwnProperty( 'likes_count_abb' ) ) {
			            		$likeBtn.find( 'span' ).text( response.likes_count_abb );
			            	}
			            	if ( response.hasOwnProperty( 'likes_btn_title' ) ) {
			            		$likeBtn.attr( 'title', response.likes_btn_title );
			            	}
			            	if ( response.hasOwnProperty( 'dislikes_count_abb' ) ) {
			            		$dislikeBtn.find( 'span' ).text( response.dislikes_count_abb );
			            	}
			            	if ( response.hasOwnProperty( 'dislikes_btn_title' ) ) {
			            		$dislikeBtn.attr( 'title', response.dislikes_btn_title );
			            	}

			            	// If rating was saved to DB
			            	if ( 'rating_saved' === response.status ) {
			            		$this.find( '.post-rating-saved-msg' ).slideDown( 150, function() {
			            			setTimeout(function(){
			            				$this.find( '.post-rating-saved-msg' ).slideUp( 150 );
			            			}, 5000 );
			            		});
			            	}

			            	// If already rated
			            	else if ( 'already_rated' === response.status ) {
			            		$this.find( '.post-rating-already-rated-msg' ).slideDown( 150, function() {
			            			setTimeout( function() {
			            				$this.find( '.post-rating-already-rated-msg' ).slideUp( 150 );
			            			}, 5000 );
			            		});
			            	}

			            	// Error
			            	else {
			            		$this.find( '.post-rating-error-msg' ).slideDown( 150, function() {
			            			setTimeout( function() {
			            				$this.find( '.post-rating-error-msg' ).slideUp( 150 );
			            			}, 5000 );
			            		});
			            	}

			            	$this.removeClass( 'm-loading' );

	            		}
		            }
		        });

			}
		}

		// LIKE
		$likeBtn.on( 'click', function(){
			ratePost( 'like' );
		});

		// DISLIKE
		$dislikeBtn.on( 'click', function(){
			ratePost( 'dislike' );
		});

	});

});
})(jQuery);