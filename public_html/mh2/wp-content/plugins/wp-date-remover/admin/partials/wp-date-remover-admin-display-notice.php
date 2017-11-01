<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://selmamariudottir.com
 * @since      1.0.0
 *
 * @package    Wp_Date_Remover
 * @subpackage Wp_Date_Remover/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
 if (get_option("wdr_admin_notices_show", true)) {
?>
<div id="wp-date-remover-notice" class="update-nag" style="border-left: 4px solid lightgreen;">
	 <b>Thank you for using WP Date Remover</b>

<p style='font-size: 1.15em;'>Want to get WordPress Plugins, Videos, and Other Useful Resources - FREE!</em></p>

<p>
	
<form target="_blank" action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" id="wp_date_remover_form" style="display: none;">

   <label>Please send it to</label>
			
   <input type="email" name="email"  id="wdr_email" required/>
			
   <input type="hidden" name="campaign_token" value="pCG1H"/>
			
  <input type="submit" class="button button-primary" value="Get it now!">
</form>

<div>
<input id="wp_date_remover_yes_btn" type="button" class="button button-primary" value="Yes, please!">
<input id="wp_date_remover_no_btn" type="button" class="button" value="No, thanks." style='margin-left: 0.5em;'>
</div>

</p>
</div>
<?php

}