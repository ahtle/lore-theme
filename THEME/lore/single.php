<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'blog_sidebar_position', 'right' ),
)); ?>

<!-- SINGLE POST : begin -->
<div class="page-post page-post-single">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<!-- POST ITEM : begin -->
	<article itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" <?php post_class(); ?>>
		<div class="post-item-inner">

			<!-- POST HEADER : begin -->
			<header class="post-header">

				<?php // MAIN HEADER
				lsvr_lore_the_main_header( array(
					'wrap_in_header' => false,
				)); ?>

				<p class="post-date">
					<time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>"><?php the_date(); ?></time>
					<span class="post-author"><?php echo sprintf( esc_html__( 'by %s', 'lore' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . get_the_author() . '</a>' ); ?></span>
				</p>

				<!-- POST META : begin -->
				<ul class="post-meta">

					<?php if ( has_category() ) : ?>
					<li class="post-categories">
						<i class="ico loreico loreico-folder"></i>
						<?php echo get_the_category_list( ', ' ); ?>
					</li>
					<?php endif; ?>

					<?php if ( comments_open() ) : ?>
					<li class="post-comments-count">
						<i class="ico loreico loreico-bubble"></i>
						<?php $comments_count = get_comment_count( get_the_ID() ); ?>
						<?php $approved_count = (int) $comments_count['approved']; ?>
						<a href="<?php the_permalink(); ?>#comments"><?php echo sprintf( esc_html( _n( '%d comment', '%d comments', $approved_count, 'lore' ) ), $approved_count ); ?></a>
					</li>
					<?php endif; ?>

				</ul>
				<!-- POST META : end -->

				<?php if ( has_post_thumbnail() ) : ?>
				<!-- POST THUMBNAIL : begin -->
				<p class="post-thumbnail">
					<a href="<?php echo esc_url( the_post_thumbnail_url( 'full' ) ); ?>" class="lightbox"><?php the_post_thumbnail(); ?></a>
				</p>
				<!-- POST THUMBNAIL : end -->
				<?php endif; ?>

			</header>
			<!-- POST HEADER : end -->

			<!-- POST CONTENT : begin -->
			<div class="post-content" itemprop="text">

				<?php the_content(); ?>
				<?php wp_link_pages(array(
					'before' => '<div class="post-pagination"><h6>' . esc_html__( 'Post pages', 'lore' ) . '</h6><p>',
					'after' => '</p></div>',
					'link_before'  => '<span>',
					'link_after'=> '</span>',
				)); ?>

			</div>
			<!-- POST CONTENT : end -->

			<?php if ( has_tag() ) : ?>
			<!-- POST FOOTER : begin -->
			<footer class="post-footer">

				<div class="post-tags">
					<i class="ico loreico loreico-tag"></i>
					<?php echo get_the_tag_list( '', ', ' ); ?>
				</div>

			</footer>
			<!-- POST FOOTER : end -->
			<?php endif; ?>

		</div>
	</article>
	<!-- POST ITEM : end -->

	<?php if ( true == get_theme_mod( 'blog_single_author_bio_enable', true ) ) : ?>
	<!-- POST AUTHOR BIO : begin -->
	<div class="post-author-bio">
		<div class="post-author-bio-inner">
			<div class="post-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?></div>
			<h5 class="post-author-name">
				<strong><?php echo esc_html( get_the_author() ); ?></strong>
				<span><?php echo esc_html__( 'Author', 'lore' ); ?></span>
			</h5>
			<?php if ( '' !== get_the_author_meta( 'description' ) ) : ?>
				<div class="post-author-description">
					<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>
					<p class="author-articles">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>"><?php echo sprintf( esc_html( 'Articles by %s', 'lore' ), get_the_author() ); ?></a>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- POST AUTHOR BIO : end -->
	<?php endif; ?>


	<?php $prev_post = get_adjacent_post( false, '', false ); ?>
	<?php $next_post = get_adjacent_post( false, '', true ); ?>
	<?php if ( true == get_theme_mod( 'blog_single_navigation_enable', true ) && ( ! empty( $prev_post ) || ! empty( $next_post ) ) ) : ?>

		<!-- POST NAVIGATION : begin -->
		<ul class="post-navigation">

			<?php if ( ! empty( $prev_post ) ): ?>
				<!-- PREVIOUS POST : begin -->
				<li class="previous-post<?php if ( has_post_thumbnail( $prev_post->ID ) ) { echo ' m-has-thumb'; } ?>">
					<div class="previous-post-inner">
						<?php if ( has_post_thumbnail( $prev_post->ID ) ) : ?>
							<?php $thumb_data = lsvr_lore_get_image_data( get_post_thumbnail_id( $prev_post->ID ) ); ?>
							<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="previous-post-thumb"><img src="<?php echo esc_url( $thumb_data['thumbnail'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>"></a>
						<?php endif; ?>
						<h6><a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php esc_html_e( 'Previous', 'lore' ); ?></a></h6>
						<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="prev-post-link"><?php echo esc_html( $prev_post->post_title ); ?></a>
					</div>
				</li>
				<!-- PREVIOUS POST : end -->
			<?php endif; ?>


			<?php if ( ! empty( $next_post ) ): ?>
				<!-- NEXT POST : begin -->
				<li class="next-post<?php if ( has_post_thumbnail( $next_post->ID ) ) { echo ' m-has-thumb'; } ?>">
					<div class="next-post-inner">
						<?php if ( has_post_thumbnail( $next_post->ID ) ) : ?>
							<?php $thumb_data = lsvr_lore_get_image_data( get_post_thumbnail_id( $next_post->ID ) ); ?>
							<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="next-post-thumb"><img src="<?php echo esc_url( $thumb_data['thumbnail'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>"></a>
						<?php endif; ?>
						<h6><a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php esc_html_e( 'Next', 'lore' ); ?></a></h6>
						<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="next-post-link"><?php echo esc_html( $next_post->post_title ); ?></a>
					</div>
				</li>
				<!-- NEXT POST : end -->
			<?php endif; ?>

		</ul>
		<!-- POST NAVIGATION : end -->

	<?php endif; ?>

    <?php if ( comments_open() ) : ?>
    <!-- POST COMMENTS : begin -->
	<div id="comments" class="c-post-comments">
		<?php comments_template(); ?>
	</div>
    <!-- POST COMMENTS : end -->
    <?php endif; ?>

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no post matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- SINGLE POST : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_position' => get_theme_mod( 'blog_sidebar_position', 'right' ),
)); ?>

<?php get_footer(); ?>