<!-- SEARCH FORM : begin -->
<form class="c-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
	<div class="search-form-inner">
		<div class="input-holder">
			<input class="text-input" type="text" name="s"
				placeholder="<?php esc_html_e( 'Search the Site', 'lore' ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>">
			<button class="submit-btn" type="submit" title="<?php esc_html_e( 'Search', 'lore' ); ?>"><i class="fa fa-search"></i></button>
		</div>
	</div>
</form>
<!-- SEARCH FORM : end -->