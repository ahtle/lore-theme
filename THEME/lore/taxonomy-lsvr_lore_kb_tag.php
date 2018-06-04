<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'kb_sidebar_position', 'left' ),
)); ?>

<!-- KB POST TAG : begin -->
<div class="page-kb-post page-kb-post-tax page-kb-post-tax-tag">

	<?php // MAIN HEADER
	lsvr_lore_the_main_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php $queried_object = get_queried_object(); ?>
		<?php if ( ! empty( $queried_object->count ) ) : ?>
		<h6><?php echo sprintf( esc_html( _n( '%s article', '%s articles', $queried_object->count, 'lore' ) ), $queried_object->count ); ?></h6>
		<?php endif; ?>

		<!-- POST LIST : begin -->
		<div class="c-post-list">
		<?php while ( have_posts() ) : the_post(); ?>

			<!-- POST ITEM : begin -->
			<article <?php post_class(); ?>>
				<div class="post-item-inner">

					<!-- POST HEADER : begin -->
					<header class="post-header">
						<?php lsvr_lore_the_kb_post_icon( get_the_ID(), 'post-icon' ); ?>
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
					<div class="post-footer">
						<div class="post-date"><?php echo get_the_date(); ?></div>
						<?php lsvr_lore_the_post_rating_values( get_the_ID() ); ?>
					</div>
					<!-- POST CONTENT : end -->

				</div>
			</article>
			<!-- POST ITEM : end -->

		<?php endwhile; ?>
		</div>
		<!-- POST LIST : end -->

		<?php // PAGINATION
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'There are currently no articles with this tag', 'lore' ) ); ?>

	<?php endif;?>

</div>
<!-- KB POST TAG : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'knowledgebase', // Load sidebar-knowledgebase.php
	'sidebar_position' => get_theme_mod( 'kb_sidebar_position', 'left' ),
)); ?>

<?php get_footer(); ?>