<?php /* Template Name: Sidebar on the Left */ ?>

<?php get_header(); ?>

<?php // MAIN BEGIN
lsvr_lore_main_begin(array(
	'sidebar_position' => 'left',
)); ?>

<?php // MAIN HEADER
lsvr_lore_the_main_header(); ?>

<!-- POST CONTENT : begin -->
<div class="post-content" itemprop="text">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>

    <?php if ( comments_open() ) : ?>
    <!-- POST COMMENTS : begin -->
	<div class="c-post-comments" id="comments">
		<?php comments_template(); ?>
	</div>
    <!-- POST COMMENTS : end -->
    <?php endif; ?>

<?php endwhile; else : ?>

	<?php lsvr_lore_the_alert_message( esc_html__( 'Sorry, no pages matched your criteria', 'lore' ) ); ?>

<?php endif; ?>
</div>
<!-- POST CONTENT : end -->

<?php // MAIN END
lsvr_lore_main_end(array(
	'sidebar_id' => 'page', // Load sidebar-page.php
	'sidebar_position' => 'left',
)); ?>

<?php get_footer(); ?>