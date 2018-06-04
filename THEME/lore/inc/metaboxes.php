<?php
/**
 * Sidebar settings
 */
add_action( 'add_meta_boxes', 'lsvr_lore_sidebar_settings_meta_add' );
if ( ! function_exists( 'lsvr_lore_sidebar_settings_meta_add' ) ) {
	function lsvr_lore_sidebar_settings_meta_add( $post ) {
		add_meta_box(
			'lsvr_lore_sidebar_settings',
			__( 'Sidebar Settings', 'lore' ),
			'lsvr_lore_sidebar_settings_meta_edit',
			'page',
			'side',
			'low'
		);
	}
}

	// Form
	if ( ! function_exists( 'lsvr_lore_sidebar_settings_meta_edit' ) ) {
		function lsvr_lore_sidebar_settings_meta_edit( $post ) {

			$current_sidebar_id = get_post_meta( $post->ID, 'lsvr_lore_sidebar_id', true );
			$custom_sidebars_count = get_theme_mod( 'custom_sidebars_count', 1 ) < 1 ? 1 : (int) get_theme_mod( 'custom_sidebars_count', 1 );
			?>

			<p><?php esc_html_e( 'Here you can assign a sidebar to this page. The sidebar will be displayed only if this page uses "Sidebar on the Left" or "Sidebar on the Right" template. You can populate sidebars with widgets under Appearance / Widgets. Number of available custom sidebars can be changed under Appearance / Customize / Misc Settings with Number of Custom Sidebars option', 'lore' ); ?></p>

			<?php wp_nonce_field( basename( __FILE__ ), 'lsvr_lore_sidebar_settings_meta_nonce' ); ?>

			<p><label for="lsvr_lore_sidebar_settings_meta_id"><strong><?php esc_html_e( 'Select Sidebar', 'lore' ); ?></strong></label></p>
			<select id="lsvr_lore_sidebar_settings_meta_id" name="lsvr_lore_sidebar_settings_meta_id">
				<option value="lsvr-lore-default-sidebar"<?php if ( 'lsvr-lore-default-sidebar' === $current_sidebar_id ) { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Default Sidebar', 'lore' ); ?></option>
				<?php for ( $i = 1; $i <= $custom_sidebars_count; $i++ ) : ?>
				<option value="lsvr-lore-custom-sidebar-<?php echo esc_attr( $i ); ?>"<?php if ( 'lsvr-lore-custom-sidebar-' . $i === $current_sidebar_id ) { echo ' selected="selected"'; } ?>><?php echo sprintf( esc_html__( 'Custom Sidebar %d', 'lore' ), $i ); ?></option>
				<?php endfor; ?>
			</select>

			<?php
		}
	}

	// Save
	add_action( 'save_post', 'lsvr_lore_sidebar_settings_meta_save', 10, 2 );
	if ( ! function_exists( 'lsvr_lore_sidebar_settings_meta_save' ) ) {
		function lsvr_lore_sidebar_settings_meta_save( $post_id, $post ) {

			if ( ! isset( $_POST['lsvr_lore_sidebar_settings_meta_nonce'] ) || ! wp_verify_nonce( $_POST['lsvr_lore_sidebar_settings_meta_nonce'], basename( __FILE__ ) ) ) {
    			return $post_id;
			}

			if ( ! empty( $_POST['lsvr_lore_sidebar_settings_meta_id'] ) ) {
				update_post_meta( $post->ID, 'lsvr_lore_sidebar_id', esc_attr( $_POST['lsvr_lore_sidebar_settings_meta_id'] ) );
			}

		}
	}

?>