<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'faq_sidebar_position', 'right' )
)); ?>

<!-- SINGLE FAQ POST : begin -->
<div class="page-faq-post page-faq-post-single">
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
				<?php the_content(); ?>
			</div>
			<!-- POST CONTENT : end -->

			<!-- POST FOOTER : begin -->
			<footer class="post-footer">

				<p class="post-date">
					<time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</p>

				<?php $cat_terms = wp_get_post_terms( get_the_ID(), 'lsvr_lore_faq_cat' );
				$tag_terms = wp_get_post_terms( get_the_ID(), 'lsvr_lore_faq_tag' ); ?>

				<?php if ( ! empty( $cat_terms ) || ! empty( $tag_terms ) ) : ?>
				<!-- POST META : begin -->
				<ul class="post-meta">

					<?php if ( ! empty( $cat_terms ) ) : ?>
					<li class="post-categories">
						<i class="ico loreico loreico-folder"></i>
						<?php echo get_the_term_list( get_the_ID(), 'lsvr_lore_faq_cat', '', ', ' ); ?>
					</li>
					<?php endif; ?>

					<?php if ( ! empty( $tag_terms ) ) : ?>
					<li class="post-tags">
						<i class="ico loreico loreico-tag"></i>
						<?php echo get_the_term_list( get_the_ID(), 'lsvr_lore_faq_tag', '', ', ' ); ?>
					</li>
					<?php endif; ?>

				</ul>
				<!-- POST META : end -->
				<?php endif; ?>

			</footer>
			<!-- POST FOOTER : end -->

		</div>
	</article>
	<!-- POST ITEM : end -->

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no posts matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- SINGLE FAQ POST : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'faq',
	'sidebar_position' => get_theme_mod( 'faq_sidebar_position', 'right' ),
)); ?>

<?php get_footer(); ?>