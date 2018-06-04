<?php /* Template Name: Default Front Page */ ?>

<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'layout' => 'fullwidth',
)); ?>

<?php // MAIN HEADER
lsvr_lore_the_main_header(); ?>

<!-- POST CONTENT : begin -->
<div class="post-content" itemprop="text">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php if ( true == get_theme_mod( 'defaultfp_grid_enable', true ) ) : ?>
	<!-- CONTENT GRID : begin -->
	<div class="c-content-grid m-<?php echo get_theme_mod( 'defaultfp_grid_columns', 4 ); ?>-columns<?php if ( true == get_theme_mod( 'defaultfp_grid_masonry', true ) ) { echo ' m-masonry'; } ?>">
		<div class="content-grid-inner">

			<!-- GRID BRICKS : begin -->
			<div class="content-grid-bricks">

				<?php // Grid CTA
				$cta_brick_html = '';
				if ( true == get_theme_mod( 'defaultfp_grid_cta_enable', true ) ) {
                    ob_start(); ?>
                    <li class="brick-item cta-brick">
                    	<div class="brick-item-inner">
                			<?php $defaultfp_grid_cta_title = get_theme_mod( 'defaultfp_grid_cta_title', esc_html__( 'Hello World!', 'lore' ) );
                			if ( ! empty( $defaultfp_grid_cta_title ) ) : ?>
                    			<h3 class="cta-brick-title"><?php echo esc_html( get_theme_mod( 'defaultfp_grid_cta_title', esc_html__( 'Hello World!', 'lore' ) ) ); ?></h3>
                			<?php endif; ?>
                			<?php $defaultfp_grid_cta_text = get_theme_mod( 'defaultfp_grid_cta_text', esc_html__( 'Lorem ipsum', 'lore' ) );
                			if ( ! empty( $defaultfp_grid_cta_text ) ) : ?>
                    			<div class="cta-brick-text">
                    				<?php echo wpautop( wp_kses_post( get_theme_mod( 'defaultfp_grid_cta_text', esc_html__( 'Lorem ipsum', 'lore' ) ) ) ); ?>
                    			</div>
                			<?php endif; ?>
                			<?php $defaultfp_grid_cta_btn_label = get_theme_mod( 'defaultfp_grid_cta_btn_label', esc_html__( 'Learn More', 'lore' ) );
                			$defaultfp_grid_cta_btn_link = get_theme_mod( 'defaultfp_grid_cta_btn_link', '#' );
                			if ( ! empty( $defaultfp_grid_cta_btn_label ) && ! empty( $defaultfp_grid_cta_btn_link ) ) : ?>
                    			<p class="cta-brick-button">
                    				<a href="<?php echo esc_url( get_theme_mod( 'defaultfp_grid_cta_btn_link', '#' ) ); ?>" class="c-button"><?php echo esc_html( get_theme_mod( 'defaultfp_grid_cta_btn_label', esc_html__( 'Learn More', 'lore' ) ) ); ?></a>
                    			</p>
                			<?php endif; ?>
                    	</div>
                    </li>
            		<?php $cta_brick_html = ob_get_clean();
				} ?>

				<?php $content_grid_source = get_theme_mod( 'defaultfp_grid_source', 'knowledgebase' ); ?>

				<?php // SOURCE : KNOWLEDGE BASE
				if ( 'knowledgebase' === $content_grid_source ) : ?>

					<?php $knowledgebase_top_categories = get_terms( 'lsvr_lore_kb_cat', array( 'parent' => 0 ) ); ?>
					<?php if ( ! empty( $knowledgebase_top_categories ) ) : ?>

						<!-- CONTENT GRID HEADER : begin -->
						<div class="content-grid-header">
							<div class="content-grid-header-inner">
								<h5 class="content-grid-title"><?php echo get_theme_mod( 'defaultfp_kb_title', esc_html__( 'Selected topics', 'lore' ) ); ?></h5>
								<p class="content-grid-btn"><a href="<?php echo esc_url( get_theme_mod( 'defaultfp_grid_btn_link', '#' ) ); ?>" class="c-button"><?php echo get_theme_mod( 'defaultfp_grid_btn_label', esc_html__( 'Go To Knowledge Base', 'lore' ) ); ?></a></p>
							</div>
						</div>
						<!-- CONTENT GRID HEADER : end -->

						<?php if ( get_theme_mod( 'defaultfp_grid_kb_cat_limit', 8 ) > 0 && get_theme_mod( 'defaultfp_grid_kb_cat_limit', 8 ) < count( $knowledgebase_top_categories ) ) {
							array_splice( $knowledgebase_top_categories, get_theme_mod( 'defaultfp_grid_kb_cat_limit', 8 ) );
						} ?>

						<!-- BRICK LIST : begin -->
						<ul class="brick-list">

							<?php if ( ! empty( $cta_brick_html ) && 'first' === get_theme_mod( 'defaultfp_grid_cta_position', 'last' ) ) {
								echo $cta_brick_html; // Already sanitized
							} ?>

							<?php foreach ( $knowledgebase_top_categories as $category ) : ?>
							<li class="brick-item">
								<div class="brick-item-inner">

									<!-- FOLDER : begin -->
									<div class="c-folder">

										<!-- FOLDER HEADER : begin -->
										<header class="folder-header">

											<?php // FOLDER ICON
											$term_meta = get_option( 'taxonomy_' . $category->term_id ); ?>
											<?php if ( ! empty( $term_meta['category_icon_meta'] ) ) : ?>
												<i class="folder-icon <?php echo esc_attr( $term_meta['category_icon_meta'] ); ?>"></i>
											<?php else : ?>
												<i class="folder-icon loreico loreico-folder"></i>
											<?php endif; ?>

											<h3 class="folder-title"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_attr( $category->name ); ?></a></h3>

										</header>
										<!-- FOLDER HEADER : end -->

										<?php // ARTICLES
										$numberposts = get_theme_mod( 'defaultfp_grid_kb_articles_limit', 3 ) > 0 ? get_theme_mod( 'defaultfp_grid_kb_articles_limit', 3 ) : 1000;
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

											<!-- FOLDER LINKS : begin -->
											<ul class="folder-links">
												<?php foreach ( $articles as $article ) : ?>
													<li class="folder-link">
														<a href="<?php echo esc_url( get_permalink( $article->ID ) ); ?>"><?php echo esc_html( $article->post_title ); ?></a>
													</li>
												<?php endforeach; ?>
											</ul>
											<!-- FOLDER LINKS : end -->

										<?php endif; ?>

									</div>
									<!-- FOLDER : end -->

								</div>
							</li>
							<?php endforeach; ?>

							<?php if ( ! empty( $cta_brick_html ) && 'last' === get_theme_mod( 'defaultfp_grid_cta_position', 'last' ) ) {
								echo $cta_brick_html; // Already sanitized
							} ?>

						</ul>
						<!-- BRICK LIST : end -->

					<?php else : ?>

						<?php lsvr_lore_the_alert_message( esc_html__( 'There are no Knowledge Base categories at this time', 'lore' ) ); ?>

					<?php endif; ?>

				<?php // SOURCE : MENU
				elseif ( 'menu' === $content_grid_source ) : ?>

					<?php if ( has_nav_menu( 'lsvr-lore-content-grid-menu' ) ) : ?>

						<!-- BRICK LIST : begin -->
						<ul class="brick-list">

							<?php if ( ! empty( $cta_brick_html ) && 'first' === get_theme_mod( 'defaultfp_grid_cta_position', 'last' ) ) {
								echo $cta_brick_html; // Already sanitized
							} ?>

							<?php if ( class_exists( 'Lsvr_Lore_Content_Grid_Menu_Walker' ) ) {
								wp_nav_menu(array(
					            	'theme_location' => 'lsvr-lore-content-grid-menu',
					            	'depth' => 2,
		            				'container' => '',
		            				'fallback_cb' => '',
		            				'items_wrap' => '%3$s',
					            	'walker' => new Lsvr_Lore_Content_Grid_Menu_Walker,
								));
							} ?>

							<?php if ( ! empty( $cta_brick_html ) && 'last' === get_theme_mod( 'defaultfp_grid_cta_position', 'last' ) ) {
								echo $cta_brick_html; // Already sanitized
							} ?>

						</ul>
						<!-- BRICK LIST : end -->

					<?php else : ?>

						<?php lsvr_lore_the_alert_message( esc_html__( 'Please create your custom menu under Appearance / Menus and set its location to Content Grid', 'lore' ) ); ?>

					<?php endif; ?>

				<?php // SOURCE : WIDGETS
				elseif ( 'widgets' === $content_grid_source ) : ?>

					<?php if ( is_active_sidebar( 'lsvr-lore-content-grid-sidebar' ) ) : ?>

						<!-- BRICK LIST : begin -->
						<ul class="brick-list">

							<?php if ( ! empty( $cta_brick_html ) && 'first' === get_theme_mod( 'defaultfp_grid_cta_position', 'last' ) ) {
								echo $cta_brick_html; // Already sanitized
							} ?>

							<?php dynamic_sidebar( 'lsvr-lore-content-grid-sidebar' ); ?>

							<?php if ( ! empty( $cta_brick_html ) && 'last' === get_theme_mod( 'defaultfp_grid_cta_position', 'last' ) ) {
								echo $cta_brick_html; // Already sanitized
							} ?>

						</ul>
						<!-- BRICK LIST : end -->

					<?php else : ?>

						<?php lsvr_lore_the_alert_message( esc_html__( 'There are no widgets. Please populate Content Grid sidebar with widgets under Appearance / Widgets', 'lore' ) ); ?>

					<?php endif; ?>

				<?php endif; ?>

			</div>
			<!-- GRID BRICKS : begin -->

			<!-- CONTENT GRID FOOTER : begin -->
			<div class="content-grid-footer">
				<div class="content-grid-footer-inner">
					<p class="content-grid-btn"><a href="<?php echo esc_url( get_theme_mod( 'defaultfp_grid_btn_link', '#' ) ); ?>" class="c-button"><?php echo get_theme_mod( 'defaultfp_grid_btn_label', esc_html__( 'Go To Knowledge Base', 'lore' ) ); ?></a></p>
				</div>
			</div>
			<!-- CONTENT GRID FOOTER : end -->

		</div>
	</div>
	<!-- CONTENT GRID : end -->
	<?php endif; ?>

	<?php if ( true == get_theme_mod( 'defaultfp_grid_enable', true ) && true == get_theme_mod( 'defaultfp_blog_enable', true ) ) : ?>
		<hr class="c-separator m-style-transparent m-size-medium">
	<?php endif; ?>

	<?php if ( true == get_theme_mod( 'defaultfp_blog_enable', true ) ) : ?>
	<!-- BLOG : begin -->
	<div class="c-blog-list m-<?php echo esc_attr( get_theme_mod( 'defaultfp_blog_columns', 3 ) ); ?>-columns">
		<div class="blog-list-inner">

			<?php $defaultfp_blog_title = get_theme_mod( 'defaultfp_blog_title', esc_html__( 'Recent Blog Posts', 'lore' ) );
			if ( ! empty( $defaultfp_blog_title ) ) : ?>
			<h2 class="blog-list-title"><?php echo get_theme_mod( 'defaultfp_blog_title', esc_html__( 'Recent Blog Posts', 'lore' ) ); ?></h2>
			<?php endif; ?>

			<?php $posts = get_posts(array(
				'posts_per_page' => (int) get_theme_mod( 'defaultfp_blog_post_limit', 3 ),
			)); ?>
			<?php if ( ! empty( $posts ) ) : ?>

				<?php $col_class = floor( 12 / (int) get_theme_mod( 'defaultfp_blog_columns', 3 ) ); ?>
				<div class="blog-list-posts row">
				<?php foreach ( $posts as $post ) : ?>
					<div class="col-md-<?php echo esc_attr( $col_class ); ?>">
						<div class="post-item">
							<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
								<p class="post-thumbnail">
									<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?></a>
								</p>
							<?php endif; ?>
							<p class="post-date"><?php echo get_the_date( get_option( 'date_format' ), $post->ID ); ?></p>
							<h3 class="post-title">
								<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo get_the_title( $post->ID ); ?></a>
							</h3>
							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="post-excerpt">
								<?php if ( ! empty( $post->post_excerpt ) ) {
									echo wpautop( $post->post_excerpt );
								} elseif ( strpos( $post->post_content, '<!--more-->' ) ) {
									$post_excerpt = get_extended( $post->post_content );
									echo ! empty( $post_excerpt['main'] ) ? $post_excerpt['main'] : '';
								} ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
				</div>

				<?php $defaultfp_blog_btn_label = get_theme_mod( 'defaultfp_blog_btn_label', esc_html__( 'More Posts', 'lore' ) );
				if ( ! empty( $defaultfp_blog_btn_label ) ) : ?>
				<p class="blog-list-more">
					<span><a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="c-button"><?php echo get_theme_mod( 'defaultfp_blog_btn_label', esc_html__( 'More Posts', 'lore' ) ); ?></a></span>
				</p>
				<?php endif; ?>

			<?php else : ?>
				<?php lsvr_lore_the_alert_message( esc_html__( 'There are currently no posts', 'lore' ) ); ?>
			<?php endif; ?>

		</div>
	</div>
	<!-- BLOG : end -->
	<?php endif; ?>

	<?php the_content(); ?>

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no pages matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- POST CONTENT : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'layout' => 'fullwidth',
)); ?>

<?php get_footer(); ?>