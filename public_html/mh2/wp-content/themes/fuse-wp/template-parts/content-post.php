<?php
/*
 * Template used for displaying the single posts content
 */
if (!defined('ABSPATH')) {
    exit();
}
?>
<div <?php post_class(); ?>>	                            

    <div class="post-header">

        <h3 class="post-title"><?php the_title(); ?></h3>

        <span class="byline"><?php echo get_the_author(); ?></span>
        <span class="posted-on"><?php echo get_the_date('F j'); ?></span>

    </div><!-- .post-header -->
    <div class="post-content">

        <?php
        if (has_post_thumbnail()) {
            $post_id = get_the_ID();
            $image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
            ?>	
            <p><a class="magnificPopup" href="<?php echo esc_url($image_full[0]); ?>" class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </a></p>
            <?php
        }

        the_content('');
        ?>

    </div><!-- .post-content -->
    <div class="post-footer">

        <?php
        the_tags();
        echo '<br>';
        wp_link_pages();
        posts_nav_link();
        ?>

    </div><!-- .post-footer -->
</div>
<?php comments_template(); ?> 