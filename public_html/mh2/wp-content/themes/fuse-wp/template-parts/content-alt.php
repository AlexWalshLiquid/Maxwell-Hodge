<?php
/**
 * The template for displaying pages in a simple way for search results
 */
if (!defined('ABSPATH')) {
    exit();
}
?>
<div <?php
if (is_sticky()) {
    post_class('sticky');
} else {
    post_class();
}
?>>

    <?php if (has_post_thumbnail()) { ?>	
        <a href="<?php the_permalink(); ?>" class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </a>
    <?php } ?>

    <div class="post-header">
        <?php if (!has_post_thumbnail()) { ?>
            <span class="alt-posted-on"><?php echo get_the_date('M j, Y'); ?></span>
        <?php } ?>
        <h3 class="post-title">
            <a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if (has_post_thumbnail()) { ?>
            <span class="posted-on"><?php echo get_the_date('M j, Y'); ?></span>
        <?php } ?>
        <span class="byline"><?php echo esc_html(get_the_author()); ?></span>
        <?php
        $categories = get_the_category();
        if (isset($categories[0]->term_id)) {
            ?>
            <span class="cat-links"> <?php
                echo esc_html__('in ', 'fuse-wp');

                echo esc_html($categories[0]->name);
                ?></span>	
        <?php } ?>

    </div><!-- .post-header -->
    <?php
    if (get_post_type() == 'post') {
        the_content();
    } else {
        ?>
        <br>
        <p><a class="more-link btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'fuse-wp'); ?></a></p>
    <?php } ?>
    <div class="post-footer">																								

    </div>
</div>