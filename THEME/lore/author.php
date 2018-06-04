<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'blog_sidebar_position', 'right' ),
)); ?>

<!-- POST ARCHIVE : begin -->
<div class="page-post page-post-archive">

	<?php // MAIN HEADER
	lsvr_lore_the_main_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<!-- POST ITEM : begin -->
			<article itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" <?php post_class(); ?>>
				<div class="post-item-inner">

					<!-- POST HEADER : begin -->
					<header class="post-header">

						<?php the_title( sprintf( '<h2 class="post-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

					</header>
					<!-- POST HEADER : end -->

					<!-- POST CONTENT : begin -->
					<div class="post-content" itemprop="text">
						<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<?php the_excerpt(); ?>
						<?php elseif ( $post->post_content ) : ?>
							<?php the_content(); ?>
						<?php endif; ?>
					</div>
					<!-- POST CONTENT : end -->

					<!-- POST FOOTER : begin -->
					<footer class="post-footer">
						<div class="post-footer-inner">

							<p class="post-date">
								<time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>"><?php the_date(); ?></time>
								<span class="post-author"><?php echo sprintf( esc_html__( 'by %s', 'lore' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . get_the_author() . '</a>' ); ?></span>
							</p>

							<p class="read-more">
								<a href="<?php esc_url( the_permalink() ); ?>" class="c-button"><?php esc_html_e( 'Read More', 'lore' ); ?></a>
							</p>

						</div>
					</footer>
					<!-- POST CONTENT : end -->

				</div>
			</article>
			<!-- POST ITEM : end -->

		<?php endwhile; ?>

		<?php // PAGINATION
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no posts matched your criteria', 'lore' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_position' => get_theme_mod( 'blog_sidebar_position', 'right' ),
)); ?>

<?php get_footer(); ?>