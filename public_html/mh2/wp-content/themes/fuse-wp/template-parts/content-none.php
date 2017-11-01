<?php
/**
 * The template for displaying a "No posts found" message
 */
if (!defined('ABSPATH')) {
    exit();
}
?>
<div class="container-inner">
    <div class="row">
        <div class="span6">
            <header>
                <h3><?php esc_html_e('Nothing Found', 'fuse-wp'); ?></h3>
            </header>

            <div>
                <?php if (is_home() && current_user_can('publish_posts')) : ?>

                    <p><?php
                        echo esc_html__('Ready to publish your first post?', 'fuse-wp')
                        . '<a href="' . esc_url(admin_url('post-new.php')) . '">'
                        . esc_html__('Get started here', 'fuse-wp') . '</a>.';
                        ?></p>

                <?php elseif (is_search()) : ?>

                    <p><?php echo esc_html__('There are no search results for ', 'fuse-wp') . get_search_query(); ?></p>
                    <?php get_search_form(); ?>

                <?php else : ?>

                    <p><?php esc_html_e('It seems we cannot find what you are looking for. Perhaps searching can help.', 'fuse-wp'); ?></p>
                    <?php get_search_form(); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>