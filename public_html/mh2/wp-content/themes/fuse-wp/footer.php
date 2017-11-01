<?php
/**
 * The template for displaying the footer
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
?>
</div><!-- content / End -->
<?php
global $nfw_theme_options;
// Footer layout options
$nfw_footer_top_switch = $nfw_footer_top_layout =$nfw_footer_middle_switch = $nfw_footer_middle_layout= $nfw_footer_bottom_switch = $nfw_footer_bottom_layout = "";

if ( isset( $nfw_theme_options['nfw-footer-top-switch'] ) ) {
    $nfw_footer_top_switch = $nfw_theme_options['nfw-footer-top-switch'];
}
if ( isset( $nfw_theme_options['nfw-footer-top-layout'] ) ) {
    $nfw_footer_top_layout = $nfw_theme_options['nfw-footer-top-layout'];
}
if ( isset( $nfw_theme_options['nfw-footer-middle-switch'] ) ) {
    $nfw_footer_middle_switch = $nfw_theme_options['nfw-footer-middle-switch'];
}
if ( isset( $nfw_theme_options['nfw-footer-middle-layout'] ) ) {
    $nfw_footer_middle_layout = $nfw_theme_options['nfw-footer-middle-layout'];
}
if ( isset( $nfw_theme_options['nfw-footer-bottom-switch'] ) ) {
    $nfw_footer_bottom_switch = $nfw_theme_options['nfw-footer-bottom-switch'];
}
if ( isset( $nfw_theme_options['nfw-footer-bottom-layout'] ) ) {
    $nfw_footer_bottom_layout = $nfw_theme_options['nfw-footer-bottom-layout'];
}
if ( $nfw_footer_top_switch == 1 ):
    ?>
    <div id="footer-top">
        <div class="container">
            <div class="row">

                <?php
                // Sets widget area classes for top footer
                $top_layout_class = "span3";

                if ( $nfw_footer_top_layout == 3 ) {
                    $top_layout_class = "span4";
                } elseif ( $nfw_footer_top_layout == 2 ) {
                    $top_layout_class = "span6";
                } elseif ( $nfw_footer_top_layout == 1 ) {
                    $top_layout_class = "span12";
                }
                ?>

                <?php
                // 1 widget area for top footer
                if ( $nfw_footer_top_layout >= 1 ):
                    ?>
                    <div class="<?php echo esc_attr($top_layout_class); ?>" id="footer-top-widget-area-1">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-top-sidebar-1' ) ) {
                                dynamic_sidebar( 'nfw-footer-top-sidebar-1' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 2 widget areas for top footer
                if ( $nfw_footer_top_layout >= 2 ):
                    ?>
                    <div class="<?php echo esc_attr($top_layout_class); ?>" id="footer-top-widget-area-2">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-top-sidebar-2' ) ) {
                                dynamic_sidebar( 'nfw-footer-top-sidebar-2' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 3 widget areas for top footer
                if ( $nfw_footer_top_layout >= 3 ):
                    ?>
                    <div class="<?php echo esc_attr($top_layout_class); ?>" id="footer-top-widget-area-3">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-top-sidebar-3' ) ) {
                                dynamic_sidebar( 'nfw-footer-top-sidebar-3' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 4 widget areas for top footer
                if ( $nfw_footer_top_layout == 4 ):
                    ?>
                    <div class="<?php echo esc_attr($top_layout_class); ?>" id="footer-top-widget-area-4">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-top-sidebar-4' ) ) {
                                dynamic_sidebar( 'nfw-footer-top-sidebar-4' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; 
if ( $nfw_footer_middle_switch == 1 ):
    ?>
    <div id="footer">
        <div class="container">
            <div class="row">

                <?php
                // Sets widget area classes for middle footer
                $middle_layout_class = "span3";

                if ( $nfw_footer_middle_layout == 3 ) {
                    $middle_layout_class = "span4";
                } elseif ( $nfw_footer_middle_layout == 2 ) {
                    $middle_layout_class = "span6";
                } elseif ( $nfw_footer_middle_layout == 1 ) {
                    $middle_layout_class = "span12";
                }
                ?>

                <?php
                // 1 widget area for middle footer
                if ( $nfw_footer_middle_layout >= 1 ):
                    ?>
                    <div class="<?php echo esc_attr($middle_layout_class); ?>" id="footer-middle-widget-area-1">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-middle-sidebar-1' ) ) {
                                dynamic_sidebar( 'nfw-footer-middle-sidebar-1' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 2 widget areas for middle footer
                if ( $nfw_footer_middle_layout >= 2 ):
                    ?>
                    <div class="<?php echo esc_attr($middle_layout_class); ?>" id="footer-middle-widget-area-2">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-middle-sidebar-2' ) ) {
                                dynamic_sidebar( 'nfw-footer-middle-sidebar-2' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 3 widget areas for middle footer
                if ( $nfw_footer_middle_layout >= 3 ):
                    ?>
                    <div class="<?php echo esc_attr($middle_layout_class); ?>" id="footer-middle-widget-area-3">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-middle-sidebar-3' ) ) {
                                dynamic_sidebar( 'nfw-footer-middle-sidebar-3' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 4 widget areas for middle footer
                if ( $nfw_footer_middle_layout == 4 ):
                    ?>
                    <div class="<?php echo esc_attr($middle_layout_class); ?>" id="footer-middle-widget-area-4">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-middle-sidebar-4' ) ) {
                                dynamic_sidebar( 'nfw-footer-middle-sidebar-4' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; 
if ( $nfw_footer_bottom_switch == 1 ):
    ?>
    <div id="footer-bottom">
        <div class="container">
            <div class="row">

                <?php
                // Sets widget area classes for bottom footer
                $bottom_layout_class = "span3";

                if ( $nfw_footer_bottom_layout == 3 ) {
                    $bottom_layout_class = "span4";
                } elseif ( $nfw_footer_bottom_layout == 2 ) {
                    $bottom_layout_class = "span6";
                } elseif ( $nfw_footer_bottom_layout == 1 ) {
                    $bottom_layout_class = "span12";
                }
                ?>

                <?php
                // 1 widget area for bottom footer
                if ( $nfw_footer_bottom_layout >= 1 ):
                    ?>
                    <div class="<?php echo esc_attr($bottom_layout_class); ?>" id="footer-bottom-widget-area-1">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-bottom-sidebar-1' ) ) {
                                dynamic_sidebar( 'nfw-footer-bottom-sidebar-1' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 2 widget areas for bottom footer
                if ( $nfw_footer_bottom_layout >= 2 ):
                    ?>
                    <div class="<?php echo esc_attr($bottom_layout_class); ?>" id="footer-bottom-widget-area-2">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-bottom-sidebar-2' ) ) {
                                dynamic_sidebar( 'nfw-footer-bottom-sidebar-2' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 3 widget areas for bottom footer
                if ( $nfw_footer_bottom_layout >= 3 ):
                    ?>
                    <div class="<?php echo esc_attr($bottom_layout_class); ?>" id="footer-bottom-widget-area-3">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-bottom-sidebar-3' ) ) {
                                dynamic_sidebar( 'nfw-footer-bottom-sidebar-3' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

                <?php
                // 4 widget areas for bottom footer
                if ( $nfw_footer_bottom_layout == 4 ):
                    ?>
                    <div class="<?php echo esc_attr($bottom_layout_class); ?>" id="footer-bottom-widget-area-4">

                        <?php
                        if ( function_exists( 'dynamic_sidebar' ) ) {

                            if ( is_active_sidebar( 'nfw-footer-bottom-sidebar-4' ) ) {
                                dynamic_sidebar( 'nfw-footer-bottom-sidebar-4' );
                            }
                        }
                        ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

</div><!-- wrapper / End -->

<a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>

<?php wp_footer(); ?>

</body>
</html>