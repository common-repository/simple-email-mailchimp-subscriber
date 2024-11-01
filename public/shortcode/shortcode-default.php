<?php 
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

add_shortcode('wpmsems-subscriber-form','wpmsems_default_form');
function wpmsems_default_form($atts, $content=null){
		global $wpmsems;
		$defaults = array(
			"id"					=> 102448
		);
		$params 					= shortcode_atts($defaults, $atts);
		$id								= $params['id'];
		$wpmsems_settings		= get_option('wpmsems_settings');
		$default_form			= $wpmsems_settings['wpmsems_subscriber_form'];
ob_start();
?>
<div class="wpmsems-subscriber-form-body">
    <?php do_action('wpmsems_before_subscriber_section',$id); ?>
	<div class="wpmsems-form-part wpmsems_simple_form_<?php echo $id; ?>">
	    <?php do_action('wpmsems_before_subscriber_result',$id); ?>
		<div id="wpmsems_simple_result"></div>
		<?php do_action('wpmsems_after_subscriber_result',$id); ?>
			<form action="" id='wpmsems_simple_form_<?php echo $id; ?>'>
					<?php
					if(!empty($default_form)){
					foreach ($default_form as $_form) {
						?>
						<div class="wpmsems-form-row wpmsems-subscriber-form-field">
							<label for="wpmsems_<?php echo $_form['form_inputs']; ?>">
								<?php echo $wpmsems->get_form_field($_form['label_text'],$_form['form_inputs']);  ?>					
							</label>
						</div>
						<?php
					}
				}else{
					?>
						<div class="wpmsems-form-row wpmsems-subscriber-form-field">
							<label for="wpmsems_email">
									<input required="" type="email" name="wpmsems_email" id="wpmsems_email" placeholder="<?php _e('Email','simple-email-mailchimp-subscriber'); ?>">									
							</label>
						</div>																	
						<div class="wpmsems-form-row wpmsems-subscriber-form-field">
						<div class='wpmsems-subscriber-form-button'>
							<label for="wpmsems_submit">
										<button type="submit" class="btn btn-primary wpmsems-btn" id="wpmsems_default_submit"><?php _e('Subscriber Now','simple-email-mailchimp-subscriber'); ?></button>								
							</label>
							</div>
						</div>
					<?php
				}
			?>
			</form>
</div>
<?php do_action('wpmsems_after_subscriber_section',$id); ?>
</div>
<?php
echo $wpmsems->wpmsems_ajax_js($id);
return ob_get_clean();
}