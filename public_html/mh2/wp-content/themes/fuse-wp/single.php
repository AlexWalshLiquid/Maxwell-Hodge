<?php
/**
 * The Template for displaying all single posts
 */
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
if ( defined( 'ERP_PATH' ) ) {
    $erp_slug = 'erp-portfolio';
} else {
    $erp_slug = false;
}
if ( get_post_type() == $erp_slug ):
    get_template_part( 'template-parts/content', 'portfolio' );
else :
    get_header();
// Get Blog related header meta
    $post_id = get_option( 'page_for_posts' );
    ?> 
    <div class="container">	
        <div class="row">
            <?php
            // Gets blog page related meta for sidebar
            $sidebar_position = get_post_meta( $post_id, 'nfw_sidebar_position', true );
            if ( $post_id == 0 ) {
                $sidebar_position = 'right';
            }

            if ( !empty( $sidebar_position ) ) {
                if ( $sidebar_position == 'left' ) {
                    get_sidebar();
                }
            }
            if ( !empty( $sidebar_position ) && $sidebar_position != 'none' ) {
                global $nfw_theme_options;
                if ( isset( $nfw_theme_options['nfw-sidebars-size'] ) ) {
                    $span_size = 12 - $nfw_theme_options['nfw-sidebars-size'];
                } else {
                    $span_size = 9;
                }
                // There is a sidebar, 
                if ( have_posts() ) :
                    ?>
                    <div class="span<?php echo $span_size; ?>">   
                        <?php
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content', 'post' );
                        endwhile;
                        ?>
                    </div>
                <?php else :
                    ?>
                    <div class="span<?php echo $span_size; ?>">
                        <?php
                        // If no content, include the "No posts found" template.
                        get_template_part( 'template-parts/content', 'none' );
                        ?>
                    </div>
                <?php
                endif;
            } else {
                // There is no sidebar
                if ( have_posts() ) :
                    ?> 
                    <div class="span12">   
                        <?php
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content', 'post' );
                        endwhile;
                        ?>
                    </div>
                    <?php
                else :
                    ?>
                    <div class="span12">
                        <?php
                        // If no content, include the "No posts found" template.
                        get_template_part( 'template-parts/content', 'none' );
                        ?>
                    </div>
                <?php
                endif;
            }

            if ( !empty( $sidebar_position ) ) {
                if ( $sidebar_position == 'right' ) {
                    get_sidebar();
                }
            }
            ?>
        </div> 
    </div> 
    <?php
    get_footer();
endif;