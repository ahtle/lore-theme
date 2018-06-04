<?php /* Template Name: Without Title */ ?>

<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(); ?>

<!-- POST CONTENT : begin -->
<div class="post-content" itemprop="text">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no pages matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- POST CONTENT : end -->

<?php // MAIN END
lsvr_lore_main_end(); ?>

<?php get_footer(); ?>