<?php
/**
 * The template for displaying Search Results pages
 *
 */
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
get_header(); ?>
    <div class="container">	
        <div class="row">
            <?php if ( have_posts() ) :
                ?>
                <div class="span12">   
                    <?php
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'alt' );
                    endwhile;
                    if ( function_exists( "nfw_pagination" ) ) {
                        nfw_pagination();
                    }
                    ?>
                </div>

            <?php else :
                ?>
                <div class="span12">
                    <?php
                    // If no content, include the "No posts found" template.
                    get_template_part( 'template-parts/content', 'none' );
                    ?>
                </div>
            <?php
            endif;
            ?>
        </div> 
    </div> 
<?php
get_footer();
