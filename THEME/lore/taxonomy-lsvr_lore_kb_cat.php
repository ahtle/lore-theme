<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => get_theme_mod( 'kb_sidebar_position', 'left' ),
)); ?>

<!-- KB POST CATEGORY : begin -->
<div class="page-kb-post page-kb-post-tax page-kb-post-tax-category">

	<?php // MAIN HEADER
	lsvr_lore_the_main_header(); ?>

	<?php $current_term = get_queried_object();
	$term_description = term_description( $current_term->term_id, 'lsvr_lore_kb_cat' ); ?>

	<?php // CATEGORY DESCRIPTION
	if ( ! empty( $term_description ) ) : ?>
	<div class="parent-category-description">
		<?php echo wpautop( $term_description ); ?>
	</div>
	<?php endif; ?>

	<?php $child_cats = get_terms( 'lsvr_lore_kb_cat', array(
		'child_of' => $current_term->term_id,
		'pad_counts' => true,
	)); ?>

	<?php if ( ! empty( $child_cats ) ) : ?>

		<!-- CATEGORY LIST : begin -->
		<div class="category-list">
			<ul class="category-list-items">

				<?php foreach ( $child_cats as $category ) : ?>
					<?php if ( $category->parent === $current_term->term_id ) : ?>

						<li class="category-item">
							<div class="category-item-inner">

								<div class="category-header">

									<?php // CATEGORY ICON
									$term_meta = get_option( 'taxonomy_' . $category->term_id ); ?>
									<?php if ( ! empty( $term_meta['category_icon_meta'] ) ) : ?>
										<i class="category-icon <?php echo esc_attr( $term_meta['category_icon_meta'] ); ?>"></i>
									<?php else : ?>
										<i class="category-icon loreico loreico-folder"></i>
									<?php endif; ?>

									<h3 class="category-title"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_attr( $category->name ); ?></a></h3>
									<span class="category-count">(<?php echo sprintf( esc_html( _n( '%s Article', '%s Articles', $category->count, 'lore' ) ), $category->count ); ?>)</span>

								</div>

								<?php // CATEGORY DESCRIPTION
								if ( term_description( $category->term_id, 'lsvr_lore_kb_cat' ) ) : ?>
									<div class="category-description">
										<?php echo wpautop( term_description( $category->term_id, 'lsvr_lore_kb_cat' ) ); ?>
									</div>
								<?php endif; ?>

							</div>
						</li>

					<?php endif; ?>
				<?php endforeach; ?>

			</ul>
		</div>
		<!-- CATEGORY LIST : end -->

	<?php endif; ?>

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

					<?php if ( ! empty( $post->post_excerpt ) ) : ?>
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

	<?php elseif ( empty( $child_cats ) ) : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'There are currently no articles in this category', 'lore' ) ); ?>

	<?php endif;?>

</div>
<!-- KB POST CATEGORY : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'knowledgebase', // Load sidebar-knowledgebase.php
	'sidebar_position' => get_theme_mod( 'kb_sidebar_position', 'left' ),
)); ?>

<?php get_footer(); ?>