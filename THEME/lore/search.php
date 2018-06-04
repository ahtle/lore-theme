<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'search_results_sidebar_position', 'disable' ),
)); ?>

<?php // MAIN HEADER
lsvr_lore_the_main_header(); ?>

<!-- SEARCH RESULTS PAGE : begin -->
<div class="page-search-results">

	<?php if ( have_posts() ) : ?>

		<h6><?php echo sprintf( esc_html( _n( '%s Result', '%s Results', lsvr_lore_get_query_post_count(), 'lore' ) ), lsvr_lore_get_query_post_count() ); ?></h6>

		<div class="c-post-list">
		<?php while ( have_posts() ) : the_post(); ?>

			<!-- POST ITEM : begin -->
			<article <?php post_class(); ?>>
				<div class="post-item-inner">

					<!-- POST HEADER : begin -->
					<header class="post-header">
						<?php lsvr_lore_the_post_type_icon( get_the_ID(), 'post-icon' ); ?>
						<?php the_title( sprintf( '<h3 class="post-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					</header>
					<!-- POST HEADER : end -->

					<?php if ( '' !== $post->post_excerpt ) : ?>
					<!-- POST CONTENT : begin -->
					<div class="post-content" itemprop="text">
						<?php the_excerpt(); ?>
					</div>
					<!-- POST CONTENT : end -->
					<?php endif; ?>

					<!-- POST FOOTER : begin -->
					<footer class="post-footer">
						<div class="post-date"><?php echo get_the_date(); ?></div>
						<?php if ( 'lsvr_lore_kb' === get_post_type() ) {
							lsvr_lore_the_post_rating_values( get_the_ID() );
						} ?>
					</footer>
					<!-- POST FOOTER : end -->

				</div>
			</article>
			<!-- POST ITEM : end -->

		<?php endwhile; ?>
		</div>

		<?php // PAGINATION
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no results were found', 'lore' ) ); ?>

	<?php endif; ?>

</div>
<!-- SEARCH RESULTS PAGE : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'search-results', // Load sidebar-search-results.php
	'sidebar_position' => get_theme_mod( 'search_results_sidebar_position', 'disable' ),
)); ?>

<?php get_footer(); ?>