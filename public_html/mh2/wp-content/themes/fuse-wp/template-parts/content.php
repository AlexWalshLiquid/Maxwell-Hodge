<?php
/**
 * The template for displaying posts with no or standard format
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
<span class="byline"><?php echo get_the_author(); ?> /</span>
        <span class="posted-on"><?php echo get_the_date('F j'); ?> /</span>	
        <span class="cat-links"> <?php the_category(', '); ?></span>	

        <h3 class="post-title">
            <a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

    </div><!-- .post-header -->
    <div class="post-content">

        <?php the_content(); ?>

    </div><!-- .post-content -->
    <div class="post-footer">

    </div><!-- .post-footer -->
</div>