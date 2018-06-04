<?php $comments_count = get_comment_count( $post->ID ); ?>
<?php if ( ! empty( $comments_count['approved'] ) ) : ?>

    <?php $approved_count = (int) $comments_count['approved']; ?>
    <h2><?php echo sprintf( esc_html( _n( '%s Comment', '%s Comments', $approved_count, 'lore' ) ), $approved_count ); ?></h2>

    <!-- COMMENTS LIST : begin -->
    <ul class="comments-list<?php if ( get_option( 'show_avatars' ) ) { echo ' m-has-avatars'; } ?>">

        <?php wp_list_comments(array(
            'reply_text' => esc_html__( 'Reply to comment', 'lore' ),
            'avatar_size' => 40,
            'format' => 'html5'
        )); ?>

        <?php paginate_comments_links(array(
            'prev_next' => false,
            'type' => 'list'
        )); ?>

    </ul>
    <!-- COMMENTS LIST : end -->

<?php else : ?>

    <h2><?php esc_html_e( 'Comments','lore' ); ?></h2>
    <?php lsvr_lore_the_alert_message( esc_html__( 'There are no comments yet', 'lore' ), array( 'custom_class' => 'm-no-comments' ) ); ?>

<?php endif; ?>

<!-- COMMENT FORM : begin -->
<div class="respond-form<?php if ( is_user_logged_in() ) { echo ' m-user-logged-in'; } ?>">

    <?php comment_form(array(
        'title_reply' => '<span>' . esc_html__( 'Leave a comment', 'lore' ) . '</span>'
    )); ?>

</div>
<!-- COMMENT FORM : end -->