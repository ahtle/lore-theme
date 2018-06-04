<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'faq_sidebar_position', 'right' ),
)); ?>

<!-- FAQ ARCHIVE : begin -->
<?php $default_state = get_theme_mod( 'faq_default_state', 'closed' ); ?>
<?php $active_class = 'open' === $default_state ? 'm-active' : ''; ?>
<div class="page-faq-post page-faq-post-archive">

	<?php // MAIN HEADER
	lsvr_lore_the_main_header(); ?>

	<?php if ( have_posts() ) : ?>

		<div class="faq-post-list-accordion">
		<?php while ( have_posts() ) : the_post(); ?>

			<!-- POST ITEM : begin -->
			<article id="<?php echo esc_attr( $post->post_name ); ?>" <?php post_class(); ?>>
				<div class="post-item-inner">

					<!-- POST HEADER : begin -->
					<header class="post-header">
						<?php the_title( '<h3 class="post-title" itemprop="headline">', '</h3>' ); ?>
					</header>
					<!-- POST HEADER : end -->

					<!-- POST CONTENT : begin -->
					<div class="post-content" itemprop="text"<?php if ( 'closed' === $default_state ) { echo ' style="display: none;"'; } ?>>

						<?php if ( '' !== $post->post_excerpt ) {
                            echo wpautop( $post->post_excerpt );
                        } else {
                            echo wpautop( $post->post_content );
                        } ?>

						<?php if ( true == get_theme_mod( 'faq_permalink_enable', true ) ) : ?>
							<p class="post-item-permalink"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php esc_html_e( 'Permalink', 'lore' ); ?></a></p>
						<?php endif; ?>

					</div>
					<!-- POST CONTENT : end -->

				</div>
			</article>
			<!-- POST ITEM : end -->

		<?php endwhile; ?>
		</div>

		<?php // PAGINATION
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'There are no FAQ posts', 'lore' ) ); ?>

	<?php endif; ?>

</div>
<!-- FAQ ARCHIVE : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'faq', // Load sidebar-faq.php
	'sidebar_position' => get_theme_mod( 'faq_sidebar_position', 'right' ),
)); ?>

<?php get_footer(); ?>