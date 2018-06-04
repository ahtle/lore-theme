<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'layout' => 'fullwidth',
)); ?>

<?php $columns = get_theme_mod( 'kb_archive_columns', 3 );
$masonry_class = true == get_theme_mod( 'kb_archive_masonry', true ) ? ' m-masonry' : ''; ?>

<!-- KB POST ARCHIVE : begin -->
<div class="page-kb-post page-kb-post-archive page-kb-post-archive-category-view m-<?php echo esc_attr( $columns ); ?>-columns<?php echo esc_attr( $masonry_class ); ?>">

	<?php // MAIN HEADER
	lsvr_lore_the_main_header(); ?>

	<?php // Add custom code before Knowledge Base archive
	do_action( 'lsvr_lore_kb_archive_category_view_before' ); ?>

	<?php $knowledgebase_top_categories = get_terms( 'lsvr_lore_kb_cat', array(
		'parent' => 0,
	)); ?>

	<?php if ( ! empty( $knowledgebase_top_categories ) ) : ?>

		<!-- KNOWLEDGE BASE CATEGORY LIST : begin -->
		<div class="category-list-holder">
			<ul class="category-list">
				<?php foreach ( $knowledgebase_top_categories as $category ) : ?>
					<li class="category-item">
						<div class="category-item-inner">

							<!-- CATEGORY HEADER : begin -->
							<header class="category-header">

								<?php // CATEGORY ICON
								$term_meta = get_option( 'taxonomy_' . $category->term_id ); ?>
								<?php if ( ! empty( $term_meta['category_icon_meta'] ) ) : ?>
									<i class="category-icon <?php echo esc_attr( $term_meta['category_icon_meta'] ); ?>"></i>
								<?php else : ?>
									<i class="category-icon loreico loreico-folder"></i>
								<?php endif; ?>

								<h3 class="category-title"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_attr( $category->name ); ?></a></h3>

								<?php // CATEGORY DESCRIPTION
								if ( term_description( $category->term_id, 'lsvr_lore_kb_cat' ) ) : ?>
								<div class="category-description">
									<?php echo wpautop( term_description( $category->term_id, 'lsvr_lore_kb_cat' ) ); ?>
								</div>
								<?php endif; ?>

							</header>
							<!-- CATEGORY HEADER : end -->

							<?php // SUBCATEGORIES
							$knowledgebase_direct_sub_categories = get_terms( 'lsvr_lore_kb_cat', array(
								'parent' => $category->term_id,
							));
							$knowledgebase_sub_categories = get_terms( 'lsvr_lore_kb_cat', array(
								'child_of' => $category->term_id,
								'pad_counts' => true,
							)); ?>

							<?php if ( ! empty( $knowledgebase_sub_categories ) ) : ?>
								<div class="child-list-holder">

									<h6 class="child-list-title"><span><?php echo sprintf( esc_html( _n( '%s Subcategory', '%s Subcategories', count( $knowledgebase_direct_sub_categories ), 'lore' ) ), count( $knowledgebase_direct_sub_categories ) ); ?></span></h6>

									<ul class="child-list subcategory-list">
									<?php foreach ( $knowledgebase_sub_categories as $subcategory ) : ?>
										<?php if ( $subcategory->parent === $category->term_id ) : ?>
										<li class="child-item subcategory-item">

											<?php // SUBCATEGORY ICON
											$term_meta = get_option( 'taxonomy_' . $subcategory->term_id ); ?>
											<?php if ( ! empty( $term_meta['category_icon_meta'] ) ) : ?>
												<i class="child-icon subcategory-icon <?php echo esc_attr( $term_meta['category_icon_meta'] ); ?>"></i>
											<?php else : ?>
												<i class="child-icon subcategory-icon loreico loreico-folder"></i>
											<?php endif; ?>

											<a href="<?php echo esc_url( get_term_link( $subcategory ) ); ?>" class="child-title subcategory-title"><?php echo esc_attr( $subcategory->name ); ?></a>
											<span class="subcategory-post-count"><?php echo sprintf( esc_html( _n( '%s Article', '%s Articles', $subcategory->count, 'lore' ) ), $subcategory->count ); ?></span>

										</li>
										<?php endif; ?>
									<?php endforeach; ?>
									</ul>

								</div>
							<?php endif; ?>

							<?php // ARTICLES
							$numberposts = get_theme_mod( 'kb_archive_category_view_limit', 0 ) > 0 ? get_theme_mod( 'kb_archive_category_view_limit', 0 ) : 1000;
							$articles_args = array(
								'post_type' => 'lsvr_lore_kb',
								'numberposts' => $numberposts,
								'tax_query' => array(
									array(
      									'taxonomy' => 'lsvr_lore_kb_cat',
      									'field' => 'id',
      									'terms' => $category->term_id,
      									'include_children' => false,
    								)
								)
							);
							if ( get_theme_mod( 'kb_articles_order', 'default' ) !== 'default' ) {
								$orderby = get_theme_mod( 'kb_articles_order', 'default' );
								$order = 'title' === $orderby || 'date_asc' === $orderby ? 'ASC' : 'DESC';
								$orderby = 'date_asc' === $orderby || 'date_desc' === $orderby ? 'date' : $orderby;
								$articles_args['order'] = $order;
								$articles_args['orderby'] = $orderby;
							}
							$articles = get_posts( $articles_args ); ?>

							<?php if ( ! empty ( $articles ) ) : ?>
								<div class="child-list-holder">

									<h6 class="child-list-title"><span><?php echo sprintf( esc_html( _n( '%s Article', '%s Articles', $category->count, 'lore' ) ), $category->count ); ?></span></h6>

									<!-- CATEGORY ARTICLES : begin -->
									<ul class="child-list article-list">
									<?php foreach ( $articles as $article ) : ?>
										<li class="child-item article-item">

											<?php lsvr_lore_the_kb_post_icon( $article->ID, 'child-icon article-icon' ); ?>
											<a href="<?php echo esc_url( get_permalink( $article->ID ) ); ?>" class="child-title article-title"><?php echo esc_html( $article->post_title ); ?></a>

										</li>
									<?php endforeach; ?>
									</ul>
									<!-- CATEGORY ARTICLES : end -->

									<?php if ( $category->count > count( $articles ) ) : ?>
									<!-- MORE LINK : begin -->
									<p class="child-list-more"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php esc_html_e( 'See All', 'lore' ); ?></a></p>
									<!-- MORE LINK : end -->
									<?php endif; ?>

								</div>
							<?php endif; ?>

						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!-- KNOWLEDGE BASE CATEGORY LIST : end -->

	<?php else : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'There are currently no articles in Knowledge Base', 'lore' ) ); ?>

	<?php endif;?>

	<?php // Add custom code after Knowledge Base archive
	do_action( 'lsvr_lore_kb_archive_category_view_after' ); ?>

</div>
<!-- KB POST ARCHIVE : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'layout' => 'fullwidth',
)); ?>