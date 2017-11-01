<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 */
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="container-inner comments-area">

    <?php if ( have_comments() ) : ?>

        <h4 class="comments-title"><?php esc_html_e( 'Article comments ', 'fuse-wp' ); comments_number('(0)','(1)','(%)' ); ?></h4>
        <ol class="comment-list">
            <?php
            // Lists user comments
            wp_list_comments( array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 80,
            ) );
            ?>
        </ol>

        <?php
        // Comment navigation
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav id="comment-nav-below" class="navigation" role="navigation">
                <h3 class="assistive-text section-heading"><?php esc_html_e( 'Comment navigation', 'fuse-wp' ); ?></h3>
                <div class="nav-previous"><?php previous_comments_link( '&larr;' . esc_html__( ' Older Comments', 'fuse-wp' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments ', 'fuse-wp' ) . '&rarr;' ); ?></div>
            </nav>
        <?php endif;
        if ( !comments_open() ) :
            ?>
            <br>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'fuse-wp' ); ?></p>
            <?php
        endif;
    endif;
    // Displays the comment form with customized html
    comment_form(
            array(
                'cancel_reply_link' => esc_html__( 'Cancel reply', 'fuse-wp' ),
                'label_submit' => esc_html__( 'Submit', 'fuse-wp' ),
                'title_reply' => esc_html__( 'Leave a reply ', 'fuse-wp' ),
                'id_form' => 'commentform',
                'comment_notes_after' => '',
                'comment_notes_before' => '',
                'comment_field' =>
                '<p class="comment-form-comment">										
                    <textarea cols="45" id="comment" name="comment" rows="8" placeholder="' . esc_html__( 'message*', 'fuse-wp' ) . '"></textarea>
                </p>',
                'fields' => array(
                    'author' =>
                    '<p class="comment-form-author">										
                        <input id="author" name="author" size="30" type="text" value="" placeholder="' . esc_html__( 'name*', 'fuse-wp' ) . '">
                    </p>',
                    'email' =>
                    '<p class="comment-form-email">										
                        <input id="email" name="email" size="30" type="text" value="" placeholder="' . esc_html__( 'email*', 'fuse-wp' ) . '">
                    </p>',
                    'url' =>
                    '<p class="comment-form-url">										
                        <input id="url" name="url" size="30" type="text" value="" placeholder="' . esc_html__( 'website', 'fuse-wp' ) . '">
                    </p>',
                ),
            )
    );
    ?>

</div>