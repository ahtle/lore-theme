<?php /* Template Name: bbPress Login / Register */ ?>

<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(); ?>

<?php // MAIN HEADER
lsvr_lore_the_main_header(); ?>

<!-- POST CONTENT : begin -->
<div class="post-content" itemprop="text">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>

	<?php if ( is_user_logged_in() ) : ?>

		<?php lsvr_lore_the_alert_message( esc_html__( 'You are already logged in.', 'lore' ) . ' <a href="' . esc_url( wp_logout_url() ) . '">' . esc_html__( 'Logout?', 'lore' ) . '</a>' ); ?>

	<?php else : ?>

		<?php if ( class_exists( 'bbPress' ) ) : ?>

			<div class="row">
				<div class="col-md-6">

					<h2><?php esc_html_e( 'Login', 'lore' ); ?></h3>
					<?php echo do_shortcode( '[bbp-login]' ); ?>

					<!-- PASSWORD RESET : begin -->
					<p><a href="#" class="login-forgot-pass-btn"><?php esc_html_e( 'Forgot Password?', 'lore' ); ?></a></p>
					<div class="login-forgot-pass-form">
						<h2><?php esc_html_e( 'Reset Password', 'lore' ); ?></h3>
						<?php echo do_shortcode( '[bbp-lost-pass]' ); ?>
					</div>
					<!-- PASSWORD RESET : end -->

				</div>
				<div class="col-md-6">

					<h2><?php esc_html_e( 'Register', 'lore' ); ?></h3>
					<?php echo do_shortcode( '[bbp-register]' ); ?>

				</div>
			</div>

		<?php else : ?>

			<?php lsvr_lore_the_alert_message( esc_html__( 'bbPress plugin is required for this feature to work', 'lore' ) ); ?>

		<?php endif; ?>

	<?php endif; ?>

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no pages matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- POST CONTENT : end -->

<?php // MAIN END
lsvr_lore_main_end(); ?>

<?php get_footer(); ?>