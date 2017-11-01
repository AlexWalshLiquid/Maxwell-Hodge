<?php
show_admin_bar( false );
wp_head();
setup_postdata( get_post( get_the_id() ), null, false );
$style = is_user_logged_in() ? ' style="margin-top:-32px"' : '';
echo '<div class="erp-wrap"', $style, '>';
	the_content();
echo '</div>';
wp_footer();