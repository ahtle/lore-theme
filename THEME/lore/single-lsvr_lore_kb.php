<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'kb_sidebar_position', 'left' ),
)); ?>

<!-- SINGLE KB POST : begin -->
<div class="page-kb-post page-kb-post-single">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<!-- POST ITEM : begin -->
	<article <?php post_class(); ?>>
		<div class="post-item-inner">

			<!-- POST HEADER : begin -->
			<header class="post-header">

				<?php // MAIN HEADER
				lsvr_lore_the_main_header( array(
					'wrap_in_header' => false,
				)); ?>

			</header>
			<!-- POST HEADER : end -->

			<!-- POST CONTENT : begin -->
			<div class="post-content" itemprop="text">

				<?php // TABLE OF CONTENTS
				if ( true == get_theme_mod( 'kb_article_contents_enable', false ) ) : ?>
					<?php echo do_shortcode( '[lore_contents title="' . esc_attr( get_theme_mod( 'kb_article_contents_title', esc_html__( 'Contents', 'lore' ) ) ) . '" excluded_ids="' . esc_attr( get_theme_mod( 'kb_article_contents_excluded_ids', '' ) ) . '"]' ); ?>
				<?php endif; ?>

				<?php the_content(); ?>

			</div>
			<!-- POST CONTENT : end -->

			<?php if ( class_exists( 'Attachments' ) ) : ?>
				<?php $post_attachments = new Attachments( 'lsvr_lore_kb_article_attachments' ); ?>
				<?php if ( $post_attachments->exist() ) : ?>
					<!-- POST ATTACHMENTS : begin -->
					<div class="post-attachments">
	  					<h4 class="attachments-title"><?php esc_html_e( 'Attachments', 'lore' ); ?></h4>
						<ul class="attachments-list">
						<?php while ( $post_attachments->get() ) : ?>
							<li class="attachment">
								<div class="attachment-inner">
									<?php $attachment_field_icon = $post_attachments->field( 'icon' );
									if ( ! empty( $attachment_field_icon ) ) : ?>
										<i class="attachment-icon <?php echo esc_attr( $post_attachments->field( 'icon' ) ); ?>"></i>
									<?php else : ?>
										<i class="attachment-icon <?php echo esc_attr( lsvr_lore_get_post_attachment_icon_class( $post_attachments->type(), $post_attachments->subtype() ) ); ?>"></i>
									<?php endif;  ?>
									<a href="<?php echo esc_url( $post_attachments->url() ); ?>" class="attachment-title" target="_blank"><?php echo esc_html( $post_attachments->field( 'title' ) ); ?></a>
									<div class="attachment-filesize"><?php echo esc_html( $post_attachments->filesize() ); ?></div>
								</div>
	  						</li>
	  					<?php endwhile; ?>
						</ul>
					</div>
					<!-- POST ATTACHMENTS : end -->
				<?php endif; ?>
			<?php endif; ?>

			<!-- POST FOOTER : begin -->
			<footer class="post-footer">

				<p class="post-date">
					<time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span class="post-author"><?php echo sprintf( esc_html__( 'by %s', 'lore' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . get_the_author() . '</a>' ); ?></span>
					<?php if ( true == get_theme_mod( 'kb_single_last_update_enable', true ) && get_the_date() !== get_the_modified_date() ) : ?>
						<span class="post-modified-date"><?php echo sprintf( esc_html__( 'Updated: %s', 'lore' ), esc_html( get_the_modified_date() ) ); ?></span>
					<?php endif; ?>
				</p>

				<?php $cat_terms = wp_get_post_terms( get_the_ID(), 'lsvr_lore_kb_cat' );
				$tag_terms = wp_get_post_terms( get_the_ID(), 'lsvr_lore_kb_tag' ); ?>

				<?php if ( ! empty( $cat_terms ) || ! empty( $tag_terms ) ) : ?>
				<!-- POST META : begin -->
				<ul class="post-meta">

					<?php if ( ! empty( $cat_terms ) ) : ?>
					<li class="post-categories">
						<i class="ico loreico loreico-folder"></i>
						<?php echo get_the_term_list( get_the_ID(), 'lsvr_lore_kb_cat', '', ', ' ); ?>
					</li>
					<?php endif; ?>


					<?php if ( ! empty( $tag_terms ) ) : ?>
					<li class="post-tags">
						<i class="ico loreico loreico-tag"></i>
						<?php echo get_the_term_list( get_the_ID(), 'lsvr_lore_kb_tag', '', ', ' ); ?>
					</li>
					<?php endif; ?>

				</ul>
				<!-- POST META : end -->
				<?php endif; ?>

				<?php if ( true == get_theme_mod( 'kb_rating_enable', true ) ) : ?>
				<!-- POST RATING : begin -->
				<div class="post-rating" data-post-id="<?php the_ID(); ?>">

					<?php // RATING SAVED MSG
					lsvr_lore_the_alert_message(
						esc_html__( 'Thanks for your rating!', 'lore' ),
						array(
							'type' => 'success',
							'hidden' => true,
							'custom_class' => 'post-rating-saved-msg',
						)
					); ?>

					<?php // ALREADY RATED MSG
					lsvr_lore_the_alert_message(
						esc_html__( 'You have already rated this article', 'lore' ),
						array(
							'hidden' => true,
							'custom_class' => 'post-rating-already-rated-msg',
						)
					); ?>

					<?php // ERROR MSG
					lsvr_lore_the_alert_message(
						esc_html__( 'An error occured, please try again later', 'lore' ),
						array(
							'hidden' => true,
							'custom_class' => 'post-rating-error-msg',
						)
					); ?>

					<div class="post-rating-inner">
						<div class="post-rating-inner2">
							<h5 class="post-rating-title"><?php esc_html_e( 'Was This Article Helpful?' ,'lore' ); ?></h5>
							<div class="post-rating-buttons">
								<?php $post_rating_values = lsvr_lore_get_post_rating_values( get_the_ID() ); ?>
								<?php $likes_count = (int) $post_rating_values['likes']; ?>
								<button type="button" class="like" title="<?php echo sprintf( esc_html( _n( '%s like', '%s likes', $likes_count, 'lore' ) ), $likes_count ); ?>">
									<?php echo '<i class="fa fa-thumbs-up"></i> <span>' . esc_attr( lsvr_lore_abbreviate_number( $likes_count ) ) . '</span>'; ?>
								</button>
								<?php if ( true == get_theme_mod( 'kb_rating_dislikes_enable', true ) ) : ?>
								<?php $dislikes_count = (int) $post_rating_values['dislikes']; ?>
								<button type="button" class="dislike" title="<?php echo sprintf( esc_html( _n( '%s dislike', '%s dislikes', $dislikes_count, 'lore' ) ), $dislikes_count ); ?>">
									<?php echo '<i class="fa fa-thumbs-down"></i> <span>' . esc_attr( lsvr_lore_abbreviate_number( $dislikes_count ) ) . '</span>'; ?>
								</button>
								<?php endif; ?>
							</div>
						</div>
					</div>

				</div>
				<!-- POST RATING : end -->
				<?php endif; ?>

			</footer>
			<!-- POST FOOTER : end -->

		</div>
	</article>
	<!-- POST ITEM : end -->

	<?php // RELATED POSTS
	if ( true == get_theme_mod( 'kb_single_related_enable', true ) ) : ?>

		<?php $related_limit = get_theme_mod( 'kb_single_related_limit', 3 ) > 0 ? (int) get_theme_mod( 'kb_single_related_limit', 3 ) : 1000;
		$query_args = array(
			'post_type' => 'lsvr_lore_kb',
			'numberposts' => $related_limit,
			'orderby' => 'rand',
			'exclude' => array( get_the_id() ),
		);
		$post_terms = wp_get_post_terms( $post->ID, 'lsvr_lore_kb_cat' );
		$post_term = ! empty( $post_terms ) ? reset( $post_terms ) : false;
		$post_term_id = ! empty( $post_term->term_id ) ? $post_term->term_id : false;
		if ( $post_term_id ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_lore_kb_cat',
					'field' => 'id',
					'terms' => $post_term_id,
					'include_children' => false,
				),
			);
		}
		$related_posts = get_posts( $query_args ); ?>

		<?php if ( ! empty( $related_posts ) ) : ?>
		<!-- POST RELATED : begin -->
		<div class="post-related<?php if ( comments_open() ) { echo ' m-bottom-border'; } ?>">
			<h6 class="related-title"><?php esc_html_e( 'Related Articles', 'lore' ); ?></h6>
			<ul class="related-post-list">
				<?php foreach ( $related_posts as $related_post ) : ?>
					<li class="related-post-item">
						<?php lsvr_lore_the_post_type_icon( $related_post->ID, 'related-post-icon' ); ?>
						<a class="related-post-title" href="<?php echo esc_url( get_post_permalink( $related_post->ID ) ); ?>"><?php echo esc_html( $related_post->post_title ); ?></a>
						<?php lsvr_lore_the_post_rating_values( $related_post->ID ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!-- POST RELATED : end -->
		<?php endif; ?>

	<?php endif; ?>

    <?php if ( comments_open() ) : ?>
    <!-- POST COMMENTS : begin -->
	<div class="c-post-comments" id="comments">
		<?php comments_template(); ?>
	</div>
    <!-- POST COMMENTS : end -->
    <?php endif; ?>

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no Knowledge Base article matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- SINGLE KB POST : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'knowledgebase',
	'sidebar_position' => get_theme_mod( 'kb_sidebar_position', 'left' ),
)); ?>

<?php get_footer(); ?>