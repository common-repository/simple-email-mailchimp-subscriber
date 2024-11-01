<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

add_shortcode( 'wpmsems-subscriber-form', 'wpmsems_subscriber_form' );
function wpmsems_subscriber_form($atts, $content=null){
		$defaults = array(
			"id"						=> '102448'
		);
		$params 					= shortcode_atts($defaults, $atts);
		$id					= $params['id'];

		$fname_st 					= wpmsems_get_option( 'wpmsems_form_fname', 'wpmsems_default_form_setting_sec', 'hidden');
		$lname_st 					= wpmsems_get_option( 'wpmsems_form_lname', 'wpmsems_default_form_setting_sec', 'hidden');
		$email_st 					= wpmsems_get_option( 'wpmsems_form_email', 'wpmsems_default_form_setting_sec', 'hidden');
		$phone_st 					= wpmsems_get_option( 'wpmsems_form_phone', 'wpmsems_default_form_setting_sec', 'hidden');
		$address_st 					= wpmsems_get_option( 'wpmsems_form_address', 'wpmsems_default_form_setting_sec', 'hidden');
		$dob_st 					= wpmsems_get_option( 'wpmsems_form_dob', 'wpmsems_default_form_setting_sec', 'hidden');

		$fname_label 					= wpmsems_get_option( 'wpmsems_form_fname_label', 'wpmsems_default_form_setting_sec', __('First Name','wpmsems'));
		$lname_label 					= wpmsems_get_option( 'wpmsems_form_lname_label', 'wpmsems_default_form_setting_sec', __('Last Name','wpmsems'));
		$email_label 					= wpmsems_get_option( 'wpmsems_form_email_label', 'wpmsems_default_form_setting_sec', __('Your Email Address','wpmsems'));
		$phone_label 					= wpmsems_get_option( 'wpmsems_form_phone_label', 'wpmsems_default_form_setting_sec', __('Your Phone Number','wpmsems'));
		$address_label 					= wpmsems_get_option( 'wpmsems_form_address_label', 'wpmsems_default_form_setting_sec', __('Your Address','wpmsems'));
		$dob_label					= wpmsems_get_option( 'wpmsems_form_dob_label', 'wpmsems_default_form_setting_sec', __('Select Your Birth Date','wpmsems'));
		$btn_label					= wpmsems_get_option( 'wpmsems_form_bn_label', 'wpmsems_default_form_setting_sec', __('Subscribe NOW!','wpmsems'));
ob_start();
?>
<div class="wpmsems-subscriber-form-body">
	<div class="wpmsems-form-part">
		<div id="wpmsems_simple_result"></div>
			<form action="" method="post" id='wpmsems_simple_form_<?php echo $id; ?>'>
					<div class="wpmsems-subscriber-form-field <?php echo $fname_st; ?>" >
						<label for="subscriber_first_name">
							<?php echo $fname_label; ?>
							<input type="<?php echo $fname_st; ?>" placeholder="<?php echo $fname_label; ?>" name="subscriber_first_name" id='subscriber_first_name'>
						</label>
					</div>						
					<div class="wpmsems-subscriber-form-field <?php echo $lname_st; ?>" >
						<label for="subscriber_last_name">
							<?php echo $lname_label; ?>
							<input type="<?php echo $lname_st; ?>" placeholder="<?php echo $lname_label; ?>" name="subscriber_last_name" id='subscriber_last_name'>
						</label>

					</div>						
					<div class="wpmsems-subscriber-form-field <?php echo $email_st; ?>" >
						<label for="subscriber_email_address">
							<?php echo $email_label; ?>
							<input required type="<?php echo $email_st; ?>" placeholder="<?php echo $email_label; ?>" name="subscriber_email_address" id='subscriber_email_address'>
						</label>
					</div>						
					<div class="wpmsems-subscriber-form-field <?php echo $phone_st; ?>" >
						<label for="subscriber_phone_number">
							<?php echo $phone_label; ?>
							<input type="<?php echo $phone_st; ?>" placeholder="<?php echo $phone_label; ?>" name="subscriber_phone_number" id='subscriber_phone_number'>
						</label>
					</div>						
					<div class="wpmsems-subscriber-form-field <?php echo $address_st; ?>" >
						<label for="subscriber_address">
							<?php echo $address_label; ?>
							<textarea type="text" placeholder="<?php echo $address_label; ?>" name="subscriber_address" id='subscriber_address'></textarea>
						</label>
					</div>	
					<div class="wpmsems-subscriber-form-field <?php echo $dob_st; ?>" >
						<label for="subscriber_dob">
							<?php echo $dob_label; ?>
							<input type="<?php echo $dob_st; ?>" placeholder="<?php echo $dob_label; ?>" name="subscriber_dob" id='subscriber_dob'>
						</label>
					</div>							
					<div class="wpmsems-subscriber-form-field">
						<button type="submit" id='sebc_send_email_collector'><?php echo $btn_label; ?></button>
					</div>
			</form>
	</div>
</div>
<script type="text/javascript">
  jQuery( "#wpmsems_simple_form_<?php echo $id; ?>" ).submit(function(e) {
     e.preventDefault();
     // alert('Yes');
        wpmsems_fname        	 = jQuery("#subscriber_first_name").val().trim();
        wpmsems_lname        	 = jQuery("#subscriber_last_name").val().trim();       
        wpmsems_email         	 = jQuery("#subscriber_email_address").val().trim();       
        wpmsems_phone        	 = jQuery("#subscriber_phone_number").val().trim();       
        wpmsems_address        	 = jQuery("#subscriber_address").val().trim();       
        wpmsems_dob        	 	 = jQuery("#subscriber_dob").val().trim();       
        jQuery.ajax({
          type: 'POST',
          url:ajaxurl,
          data: {"action": "wpmsems_simple_subscriber", "fname":wpmsems_fname, "lname":wpmsems_lname, "email":wpmsems_email, "phone":wpmsems_phone, "address":wpmsems_address, "dob":wpmsems_dob},
        beforeSend: function(){
            jQuery('#wpmsems_simple_result').html('<span class=wpmsems_message wpmsems_process style="display:block;background:#ddd:color:#000:font-weight:bold;text-align:center"><?php echo wpmsems_get_option( 'wpmsems_form_sending_msg', 'wpmsems_default_form_message_sec', 'Sending..') ?></span>');
                },          
        success: function(data)
            { 
              jQuery('#wpmsems_simple_result').html(data);
            }
          });
         return false;
      })
</script>
<?
$content = ob_get_clean();
return $content;
}