<!-- SEARCH FORM : begin -->
<?php $lsvr_lore_form_id = lsvr_lore_get_header_search_id(); ?>
<form class="header-search-form<?php if ( true == get_theme_mod( 'header_search_ajax_enable', true ) ) { echo ' m-ajaxed'; } ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<div class="header-search-form-inner">

		<!-- INPUT HOLDER : begin -->
		<div class="input-holder">

			<!-- TEXT INPUT : begin -->
			<input class="text-input" type="text" name="s" autocomplete="off"
				placeholder="<?php echo get_theme_mod( 'header_search_placeholder', esc_html__( 'Search the Knowledge Base', 'lore' ) ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>">
			<button class="submit-btn" type="submit" title="<?php esc_html_e( 'Search', 'lore' ); ?>"><i class="fa fa-search"></i></button>
			<i class="loading-anim fa fa-spinner m-spin"></i>
			<!-- TEXT INPUT : end -->

			<!-- SEARCH OPTIONS : begin -->
			<div class="header-search-options" style="display: none;">

				<?php if ( true == get_theme_mod( 'header_search_filter_enable', true ) ) : ?>

					<!-- SEARCH FILTER : begin -->
					<div class="header-search-filter">

						<?php if ( isset( $_GET['search-filter'] ) ) {
							$post_type_arr = array_map( 'esc_attr', $_GET['search-filter'] );
						} elseif ( isset( $_GET['search-filter-serialized'] ) ) {
							$post_type_arr = explode( ',', esc_attr( $_GET['search-filter-serialized'] ) );
						} else {
							$post_type_arr = [];
						}?>

						<span><?php esc_html_e( 'Search in:', 'lore' ); ?></span>

						<label for="header-search-filter-type-any-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-any m-active">
							<input type="checkbox" id="header-search-filter-type-any-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="any"<?php if ( empty( $post_type_arr ) || in_array( 'any', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'all', 'lore' ); ?>
						</label>

						<?php if ( post_type_exists( 'lsvr_lore_kb' ) ) : ?>
						<label for="header-search-filter-type-lsvr_lore_kb-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-lsvr_lore_kb">
							<input type="checkbox" id="header-search-filter-type-lsvr_lore_kb-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="lsvr_lore_kb"<?php if ( in_array( 'lsvr_lore_kb', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'knowledge base', 'lore' ); ?>
						</label>
						<?php endif; ?>

						<?php if ( post_type_exists( 'lsvr_lore_faq' ) ) : ?>
						<label for="header-search-filter-type-lsvr_lore_faq-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-lsvr_lore_faq">
							<input type="checkbox" id="header-search-filter-type-lsvr_lore_faq-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="lsvr_lore_faq"<?php if ( in_array( 'lsvr_lore_faq', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'FAQ', 'lore' ); ?>
						</label>
						<?php endif; ?>

						<label for="header-search-filter-type-post-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-post">
							<input type="checkbox" id="header-search-filter-type-post-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="post"<?php if ( in_array( 'post', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'post', 'lore' ); ?>
						</label>

						<label for="header-search-filter-type-page-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-page">
							<input type="checkbox" id="header-search-filter-type-page-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="page"<?php if ( in_array( 'page', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'page', 'lore' ); ?>
						</label>

						<?php if ( class_exists( 'bbPress' ) && post_type_exists( 'forum' ) && post_type_exists( 'topic' ) ) : ?>
						<label for="header-search-filter-type-forum-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-forum">
							<input type="checkbox" id="header-search-filter-type-forum-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="forum"<?php if ( in_array( 'forum', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'forum', 'lore' ); ?>
						</label>
						<label for="header-search-filter-type-topic-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" class="header-search-filter-type-topic">
							<input type="checkbox" id="header-search-filter-type-topic-<?php echo esc_attr( $lsvr_lore_form_id ); ?>" name="search-filter[]" value="topic"<?php if ( in_array( 'topic', $post_type_arr ) ) { echo ' checked="checked"'; } ?>><?php esc_html_e( 'topic', 'lore' ); ?>
						</label>
						<?php endif; ?>

						<?php do_action( 'lsvr_lore_header_search_filter_items_after' ); ?>

					</div>
					<!-- SEARCH FILTER : end -->

					<p class="header-search-mobile-close m-size-small">
						<button class="c-button" type="button"><?php esc_html_e( 'Close Search', 'lore' ); ?></button>
					</p>

				<?php endif; ?>

			</div>
			<!-- SEARCH OPTIONS : end -->

		</div>
		<!-- INPUT HOLDER : end -->

		<?php if ( '' !== get_theme_mod( 'header_search_suggestions', '' ) ) : ?>
		<!-- SEARCH SUGGESTIONS : begin -->
		<div class="header-search-suggestions">
			<div class="header-search-suggestions-inner">

				<?php $search_suggestions = array_filter( array_map( 'trim', explode( ',', get_theme_mod( 'header_search_suggestions', '' ) ) ) ); ?>
				<span><?php esc_html_e( 'Suggested Search:', 'lore' ); ?></span>
				<?php foreach ( $search_suggestions as $keyword ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 's', $keyword, home_url( '/' ) ) ); ?>" data-search-keyword="<?php echo esc_attr( $keyword ); ?>"><?php echo esc_html( $keyword ); ?></a><?php if ( $keyword !== end( $search_suggestions ) ) { echo ', '; } ?>
				<?php endforeach; ?>

			</div>
		</div>
		<!-- SEARCH SUGGESTIONS : end -->
		<?php endif; ?>

	</div>
</form>
<!-- SEARCH FORM : end -->