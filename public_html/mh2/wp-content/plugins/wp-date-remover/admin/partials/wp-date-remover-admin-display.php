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
<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <?php
		$wdr_args = array(
		  'orderby' => 'name',
		  'order' => 'ASC'
		  );
    	$wdr_categories = get_categories($wdr_args);
		if(is_array($wdr_categories) && !empty($wdr_categories))
		{
			$wdr_i=0;
	?>
    <form method="post" name="wdr_settings" action="options.php">
    <table class="form-table">
    <tbody>
        <!-- remove date and time from specific categories -->
        <?php
			$options = get_option($this->plugin_name);
			settings_fields($this->plugin_name);
			do_settings_sections($this->plugin_name);
        	foreach($wdr_categories as $wdr_cat)
			{
				$wdr_category_option=$options['removedt_'.$wdr_cat->term_id];
				$wdr_i++;
				if($wdr_i==1 || $wdr_i%3==1)
				{
		?>
		
					<tr>
        <?php
				}
						
			?>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span><?php _e('Remove Date/Time', $this->plugin_name);?></span></legend>
								<label for="<?php echo $this->plugin_name; ?>-removedt_<?php echo $wdr_cat->term_id; ?>">
									<input type="checkbox" value="1" <?php checked($wdr_category_option, 1); ?> id="<?php echo $this->plugin_name; ?>-removedt_<?php echo $wdr_cat->term_id; ?>" name="<?php echo $this->plugin_name; ?>[removedt_<?php echo $wdr_cat->term_id; ?>]">
									 <span><?php esc_attr_e($wdr_cat->name, $this->plugin_name); ?></span>
								</label>
							</fieldset>
					   </td>

       	<?php
				if($wdr_i%3==0 || $wdr_i==count($wdr_categories))
				 {
		?>
        			</tr>
        <?php
				 }
			}
		?>
  	</tbody>
	</table>
       <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
      
    </form>
	<?php
		}
	?>
</div>