<?php
if (!defined('ABSPATH')) {
    exit();
}

function nfw_widgets_init1() {
    register_widget('nfw_flickr_widget');
    register_widget('nfw_connect_social_widget');
    register_widget('nfw_twitter_widget');
    register_widget('nfw_posts_widget');
}

add_action('widgets_init', 'nfw_widgets_init1');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Flickr Widget
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class nfw_flickr_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'nfw_flickr_widget', esc_html__('Fuse - Flickr', 'fuse-wp'), array(
            'description' => esc_html__('Flickr gallery widget', 'fuse-wp'),)
        );
    }

    public function widget($args, $instance) {
        $user = apply_filters('widget_user', $instance['user']);
        $title = apply_filters('widget_title', $instance['title']);
        $images = apply_filters('widget_images', $instance['images']);

        if (trim($images) != '') {
            if (preg_match("/[^0-9]/", $images)) {
                $images = 1;
            }
        } else {
            $images = 1;
        }

        echo wp_kses_post($args['before_widget']);
        ?>
        <div class="nfw_widget_flickr">
            <?php
            if (trim($title) != '') {
                echo wp_kses_post($args['before_title']);
                echo esc_html($title);
                echo wp_kses_post($args['after_title']);
            }
            ?>
            <div class="flickr-feed">
                <?php if (trim($user) != ''): ?>
                    <script type="text/javascript" src="//www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr($images); ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr($user); ?>"></script>                    
                <?php endif; ?>
            </div>
        </div>
        <br class="clear">
        <?php
        echo wp_kses_post($args['after_widget']);
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>" />
        </p>

        <?php
        if (isset($instance['user'])) {
            $user = $instance['user'];
        } else {
            $user = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('user')); ?>"><?php esc_html_e('Flicker User ID:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('user')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('user')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($user); ?>" />
            <label><?php esc_html_e('Use ', 'fuse-wp'); ?><a href='//idgettr.com/' target='_blank'>idgettr.com</a><?php esc_html_e(' to get the Flicker ID number.', 'fuse-wp'); ?></label>
        </p>

        <?php
        if (isset($instance['images'])) {
            $images = $instance['images'];
        } else {
            $images = '9';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('images')); ?>"><?php esc_html_e('Number of images:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('images')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('images')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($images); ?>" />
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['user'] = (!empty($new_instance['user']) ) ? strip_tags($new_instance['user']) : '';
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['images'] = (!empty($new_instance['images']) ) ? strip_tags($new_instance['images']) : '';
        return $instance;
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Connect Social Widget
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class nfw_connect_social_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'nfw_connect_social_widget', esc_html__('Fuse - Connect With Us', 'fuse-wp'), array(
            'description' => esc_html__('Connect With Us widget', 'fuse-wp'),)
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $facebook = apply_filters('widget_facebook', $instance['facebook']);
        $googleplus = apply_filters('widget_googleplus', $instance['googleplus']);
        $twitter = apply_filters('widget_twitter', $instance['twitter']);
        $pinterest = apply_filters('widget_pinterest', $instance['pinterest']);
        $youtube = apply_filters('widget_youtube', $instance['youtube']);
        $linkedin = apply_filters('widget_linkedin', $instance['linkedin']);
        $instagram = apply_filters('widget_instagram', $instance['instagram']);

        echo wp_kses_post($args['before_widget']);
        ?>
        <div class="nfw_widget_social_media">

            <?php
            if (trim($title) != '') {
                echo wp_kses_post($args['before_title']);
                echo esc_html($title);
                echo wp_kses_post($args['after_title']);
            }
            ?>
            <?php if (trim($facebook) != '') { ?>
                <a href="<?php echo esc_url($facebook); ?>" class="facebook-icon social-icon" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            <?php } ?>
            <?php if (trim($twitter) != '') { ?>
                <a href="<?php echo esc_url($twitter); ?>" class="twitter-icon social-icon" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
            <?php } ?>
            <?php if (trim($googleplus) != '') { ?>
                <a href="<?php echo esc_url($googleplus); ?>" class="google-icon social-icon" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>
            <?php } ?>
            <?php if (trim($linkedin) != '') { ?>
                <a href="<?php echo esc_url($linkedin); ?>" class="linkedin-icon social-icon" target="_blank">
                    <i class="fa fa-linkedin"></i>
                </a>
            <?php } ?>
            <?php if (trim($youtube) != '') { ?>
                <a href="<?php echo esc_url($youtube); ?>" class="youtube-icon social-icon" target="_blank">
                    <i class="fa fa-youtube"></i>
                </a>
            <?php } ?>
            <?php if (trim($pinterest) != '') { ?>
                <a href="<?php echo esc_url($pinterest); ?>" class="pinterest-icon social-icon" target="_blank">
                    <i class="fa fa-pinterest"></i>
                </a>
            <?php } ?>
            <?php if (trim($instagram) != '') { ?>
                <a href="<?php echo esc_url($instagram); ?>" class="instagram-icon social-icon" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
            <?php } ?>
        </div>

        <?php
        echo wp_kses_post($args['after_widget']);
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>" />
        </p>

        <?php
        if (isset($instance['facebook'])) {
            $facebook = $instance['facebook'];
        } else {
            $facebook = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('facebook')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($facebook); ?>" />
        </p>
        <?php
        if (isset($instance['twitter'])) {
            $twitter = $instance['twitter'];
        } else {
            $twitter = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('twitter')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($twitter); ?>" />
        </p>

        <?php
        if (isset($instance['googleplus'])) {
            $googleplus = $instance['googleplus'];
        } else {
            $googleplus = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('googleplus')); ?>"><?php esc_html_e('Googleplus link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('googleplus')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('googleplus')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($googleplus); ?>" />
        </p>
        <?php
        if (isset($instance['linkedin'])) {
            $linkedin = $instance['linkedin'];
        } else {
            $linkedin = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('linkedin')); ?>"><?php esc_html_e('LinkedIn link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('linkedin')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($linkedin); ?>" />
        </p>

        <?php
        if (isset($instance['youtube'])) {
            $youtube = $instance['youtube'];
        } else {
            $youtube = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('youtube')); ?>"><?php esc_html_e('Youtube link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('youtube')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($youtube); ?>" />
        </p>

        <?php
        if (isset($instance['pinterest'])) {
            $pinterest = $instance['pinterest'];
        } else {
            $pinterest = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('pinterest')); ?>"><?php esc_html_e('Pinterest link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('pinterest')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($pinterest); ?>" />
        </p>

        <?php
        if (isset($instance['instagram'])) {
            $instagram = $instance['instagram'];
        } else {
            $instagram = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('instagram')); ?>"><?php esc_html_e('Instagram link:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('instagram')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($instagram); ?>" />
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook']) ) ? strip_tags($new_instance['facebook']) : '';
        $instance['googleplus'] = (!empty($new_instance['googleplus']) ) ? strip_tags($new_instance['googleplus']) : '';
        $instance['twitter'] = (!empty($new_instance['twitter']) ) ? strip_tags($new_instance['twitter']) : '';
        $instance['pinterest'] = (!empty($new_instance['pinterest']) ) ? strip_tags($new_instance['pinterest']) : '';
        $instance['linkedin'] = (!empty($new_instance['linkedin']) ) ? strip_tags($new_instance['linkedin']) : '';
        $instance['youtube'] = (!empty($new_instance['youtube']) ) ? strip_tags($new_instance['youtube']) : '';
        $instance['instagram'] = (!empty($new_instance['instagram']) ) ? strip_tags($new_instance['instagram']) : '';
        return $instance;
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Twitter Widget
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class nfw_twitter_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'nfw_twitter_widget', esc_html__('Fuse - Twitter', 'fuse-wp'), array(
            'description' => esc_html__('Twitter widget', 'fuse-wp'),)
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $id = apply_filters('widget_id', $instance['id']);
        $count = apply_filters('widget_count', $instance['count']);

        echo wp_kses_post($args['before_widget']);
        ?>

        <div class="nfw_widget_latest_tweets">

            <?php
            if (trim($title) != '') {
                echo wp_kses_post($args['before_title']);
                echo esc_html($title);
                echo wp_kses_post($args['after_title']);
            }
            ?>
            <?php
            if (trim($id) != ''):
                if (preg_match("/[^0-9]/", $count)) {
                    $count = 1;
                }
                ?>
                <div class="nfw-tweet-list" data-account-id="<?php echo esc_attr($id); ?>" data-items="<?php echo esc_attr($count); ?>"></div>
            <?php endif; ?>

        </div>        

        <?php
        echo wp_kses_post($args['after_widget']);
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>" />
        </p>

        <?php
        if (isset($instance['id'])) {
            $id = $instance['id'];
        } else {
            $id = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('id')); ?>"><?php esc_html_e('Twitter Widget ID:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('id')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('id')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($id); ?>" />
            <label><?php esc_html_e('### HOW TO CREATE A VALID ID TO USE: ###<br>
                * Go to www.twitter.com and sign in as normal, go to your settings page.<br>
                * Go to "Widgets" on the left hand side.<br>
                * Create a new widget for what you need eg "user time line" or "search" etc.<br>
                * Feel free to check "exclude replies" if you do not want replies in results.<br>
                * Now go back to settings page, and then go back to widgets page and you should see the widget you just created. Click edit.<br>
                * Look at the URL in your web browser, you will see a long number like this:<br>
                * 551361115104763906<br>
                * Use this as your ID instead!', 'fuse-wp'); ?></label>

        </p>

        <?php
        if (isset($instance['count'])) {
            $count = $instance['count'];
        } else {
            $count = '1';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('count')); ?>"><?php esc_html_e('Number of tweets:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('count')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($count); ?>" />
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['id'] = (!empty($new_instance['id']) ) ? strip_tags($new_instance['id']) : '';
        $instance['count'] = (!empty($new_instance['count']) ) ? strip_tags($new_instance['count']) : '';
        return $instance;
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Posts Widget 
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class nfw_posts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'nfw_posts_widget', esc_html__('Fuse - Recent posts', 'fuse-wp'), array(
            'description' => esc_html__('Displays recent posts with a thumbnail', 'fuse-wp'),)
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $count = apply_filters('widget_count', $instance['count']);

        if (trim($count) != '') {
            if (preg_match("/[^0-9]/", $count)) {
                $count = 1;
            }
        } else {
            $count = 1;
        }

        echo wp_kses_post($args['before_widget']);
        ?>
        <div class="nfw_widget_latest_posts">
            <?php
            if (trim($title) != '') {
                echo wp_kses_post($args['before_title']);
                echo esc_html($title);
                echo wp_kses_post($args['after_title']);
            }
            ?>

            <ul>
                <?php
                $recent_posts = wp_get_recent_posts(array('numberposts' => $count,'suppress_filters' => false, 'post_status' => 'publish'));

                foreach ($recent_posts as $recent):
                    ?>
                    <li>
                        <?php echo get_the_post_thumbnail($recent["ID"], 'nfw_testimonial_size'); ?>

                        <a class="title" href="<?php echo esc_url(get_permalink($recent["ID"])); ?>"><?php echo esc_html($recent["post_title"]); ?></a><br>

                        <p><?php esc_html_e('by ', 'fuse-wp'); ?><?php
                            $author = get_user_by('id', $recent['post_author']);
                            echo esc_html($author->display_name);
                            ?> 
                            <span class="post-date"><?php echo get_the_date('F j, Y', $recent["ID"]); ?></span>


                            <a href="<?php echo esc_url(get_permalink($recent["ID"])); ?>"><?php esc_html_e('Read more', 'fuse-wp'); ?></a>                                   
                        </p>
                    </li>  
                    <?php
                endforeach;
                ?>

            </ul>
        </div>

        <?php
        echo wp_kses_post($args['after_widget']);
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = esc_html__('Latest posts', 'fuse-wp');
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>" />
        </p>

        <?php
        if (isset($instance['count'])) {
            $count = $instance['count'];
        } else {
            $count = '';
        }
        ?>
        <p>
            <label for="<?php echo sanitize_html_class($this->get_field_id('count')); ?>"><?php esc_html_e('Number of posts:', 'fuse-wp'); ?></label>
            <input class="widefat" 
                   id="<?php echo sanitize_html_class($this->get_field_id('count')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($count); ?>" />
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count']) ) ? strip_tags($new_instance['count']) : '';
        return $instance;
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Dashboard News Widget
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function nfw_dashboard_news() {
    wp_add_dashboard_widget('nfw_dashboard_news_widget', 'Latest works', 'nfw_dashboard_news_function');

    // Globalize the metaboxes array, this holds all the widgets for wp-admin

    global $wp_meta_boxes;

    // Get the regular dashboard widgets array 
    // (which has our new widget already but at the end)

    $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

    // Backup and delete our new dashboard widget from the end of the array

    $example_widget_backup = array('nfw_dashboard_news_widget' => $normal_dashboard['nfw_dashboard_news_widget']);
    unset($normal_dashboard['nfw_dashboard_news_widget']);

    // Merge the two arrays together so our widget is at the beginning

    $sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

    // Save the sorted array back into the original metaboxes 

    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

add_action('wp_dashboard_setup', 'nfw_dashboard_news');

// Create the function to output the contents of our Dashboard Widget.

function nfw_dashboard_news_function() {

    // Display whatever it is you want to show.
    $request = wp_remote_get('http://www.europadns.net/wordpress/index.html');
    $response = wp_remote_retrieve_body($request);
    print $response;
}
