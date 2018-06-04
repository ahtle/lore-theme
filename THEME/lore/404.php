<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(); ?>

<?php // MAIN HEADER
lsvr_lore_the_main_header(); ?>

<!-- POST CONTENT : begin -->
<div class="post-content" itemprop="text">

	<?php lsvr_lore_the_alert_message( get_theme_mod( 'page404_content', esc_html__( 'The page you are looking for is no longer available or has been moved', 'lore' ) ) ); ?>

</div>
<!-- POST CONTENT : end -->

<?php // MAIN END
lsvr_lore_main_end(); ?>

<?php get_footer(); ?>