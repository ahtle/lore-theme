<?php get_header(); ?>

<?php // CHOOSE LAYOUT
if ( 'article_view' === get_theme_mod( 'kb_archive_layout', 'article_view' ) || ( isset( $_GET['kb_archive_layout'] ) && 'article_view' === $_GET['kb_archive_layout'] ) ) {
	get_template_part( 'components/kb-archive-article-view' );
} else {
	get_template_part( 'components/kb-archive-category-view' );
}?>

<?php get_footer(); ?>
