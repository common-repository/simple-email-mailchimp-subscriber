<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class WpmsemsFunctions {

	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
        $this->add_hooks();		
	}

	private function add_hooks() {
		add_action( 'plugins_loaded',array($this, 'load_plugin_textdomain' ));
		add_action('wp_ajax_wpmsems_simple_subscriber', array($this,'wpmsems_simple_subscriber'));
		add_action('wp_ajax_nopriv_wpmsems_simple_subscriber', array($this,'wpmsems_simple_subscriber'));
		add_filter( 'manage_wpmsems_subscriber_posts_columns', array($this, 'add_new_column_into_subscriber_list' ));
		add_action( 'manage_wpmsems_subscriber_posts_custom_column' , array($this,'add_new_value_column_into_subscriber_list'), 10, 2 );
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'simple-email-mailchimp-subscriber',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

    public function wpmsems_get_option($setting_name,$meta_key,$default=null){
        $get_settings = get_option($setting_name);
        $get_val = $get_settings[$meta_key];
        $output = $get_val ? $get_val : $default;
        return $output; 
     }


	public function wpmsems_get_default_notification_email_text(){
		$text = 'Hello Admin,<br/>
		 A New Subscriber has been subscribed. Here is the details:<br/>
		 Name: {first-name} {last-name}<br/>
		 Email: {email}<br/>
		 Phone: {phone}<br/>
		 Address:<br/>
		 {address}<br/>
		 Date of birth: {birthday}<br/>
		 <br/>
		 Thanks.';
		return $text;
		}

		public function get_form_field($name,$id){
			if( $id=='first_name' || $id=='last_name' || $id=='phone'){
				?>
					<input type="text" name='wpmsems_<?php echo $id; ?>' id='wpmsems_<?php echo $id; ?>' placeholder='<?php echo $name; ?>'>
				<?php
			}
			if( $id=='email'){
				?>
					<input required type="email" name='wpmsems_<?php echo $id; ?>' id='wpmsems_<?php echo $id; ?>' placeholder='<?php echo $name; ?>'>
				<?php
			}
			if( $id=='dob'){
				?>
					<input type="date" name='wpmsems_<?php echo $id; ?>' id='wpmsems_<?php echo $id; ?>' placeholder='<?php echo $name; ?>'>
				<?php
			}
			if( $id=='address'){
				?>
					<textarea name='wpmsems_<?php echo $id; ?>' id='wpmsems_<?php echo $id; ?>' placeholder='<?php echo $name; ?>'></textarea>
				<?php
			}
			if( $id=='submit'){
				?>
				<div class='wpmsems-subscriber-form-button'>
				<button type='submit' class='btn btn-primary wpmsems-btn' id='wpmsems_default_<?php echo $id; ?>'><?php echo $name; ?></button>
				</div>
				<?php
			}
		}


		public function wpmsems_check_subscriber_exists($email){
			$args = array(
				'post_type' => 'wpmsems_subscriber',
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
									'key'       => 'wpmsems_email',
									'value'     => $email,
									'compare'   => '='
							)
					)
			);
			$loop = new WP_Query($args);
			return $loop->post_count;
		  }

		  public function wpmsems_subscriber_create($fname,$lname,$dob,$email,$phone,$address,$cat,$camp,$type,$form,$status){
			  $full_name = $fname.' '.$lname;
			  $name = $full_name ? $full_name : $email;

			  $new_subscriber = array(
				'post_title'    =>   $name,
				'post_content'  =>   '',
				'post_category' =>   array(),
				'tags_input'    =>   array(),
				'post_status'   =>   'publish', 
				'post_type'     =>   'wpmsems_subscriber'  
				);
			
				$pid             = wp_insert_post($new_subscriber);
				$update1         = update_post_meta( $pid, 'wpmsems_first_name', $fname);
				$update12        = update_post_meta( $pid, 'wpmsems_last_name', $lname);
				$update13        = update_post_meta( $pid, 'wpmsems_dob', $dob);
				$update14        = update_post_meta( $pid, 'wpmsems_email', $email);
				$update15        = update_post_meta( $pid, 'wpmsems_phone', $phone);
				$update16        = update_post_meta( $pid, 'wpmsems_address', $address);
				$update17        = update_post_meta( $pid, 'wpmsems_form_cat', $cat);
				$update18        = update_post_meta( $pid, 'wpmsems_camp', $camp);
				$update19        = update_post_meta( $pid, 'wpmsems_form_type', $type);
				$update10        = update_post_meta( $pid, 'wpmsems_form_id', $form);
				$update21        = update_post_meta( $pid, 'wpmsems_subs_status', $status);
				if($pid){
					return true;
				}
		  }



		  public function wpmsems_send_admin_email_notification($fname,$lname,$email,$phone,$address,$dob){

				$email_send_status = $this->wpmsems_get_option( 'wpmsems_settings', 'enable_email_notificaion','no' );
				$email_to = $this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_notification_email',get_bloginfo('admin_email') );
				$email_sub = $this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_email_subject','New Subscriber' );
				$email_form_name = $this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_form_name',get_bloginfo('name'));
				$email_form_email = $this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_form_email',get_bloginfo('admin_email') );
				$email_body = nl2br($this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_email_text',$this->wpmsems_get_default_notification_email_text()));
				
				$email_body    = str_replace("{first-name}",$fname,$email_body);
				$email_body    = str_replace("{last-name}",$lname,$email_body);
				$email_body    = str_replace("{email}",$email,$email_body);
				$email_body    = str_replace("{phone}",$phone,$email_body);
				$email_body    = str_replace("{address}",$address,$email_body);
				$email_body    = str_replace("{birthday}",$dob,$email_body);
				
				if($email_send_status=='yes'){
				$headers[] = "From: $email_form_name <$email_form_email>";
				$headers[] = "Content-Type: text/html; charset=UTF-8";
				wp_mail( $email_to, $email_sub, $email_body, $headers );
				}
				
			}

		public function wpmsems_simple_subscriber(){
			global $wpdb;
				$fname      = sanitize_text_field($_POST['fname']);
				$lname      = sanitize_text_field($_POST['lname']);
				$email      = sanitize_email($_POST['email']);
				$phone      = sanitize_text_field($_POST['phone']);
				$address    = sanitize_text_field($_POST['address']);
				$dob        = sanitize_text_field($_POST['dob']);
				$cat        = 1;
				$camp       = 1;
				$type       = 1;
				$form       = 1;
				$status     = 'Active';
				$check_result   = $this->wpmsems_check_subscriber_exists($email);
			  wpmsems_add_subscriber_into_mailchimp($fname,$lname,$email,$phone,$address,$dob);
			
			$success  = esc_html($this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_success_msg', 'Congratulation! You Just Subscribed to our list.'));
			$already  = esc_html($this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_already_exixts_msg', 'Congratulation! Youre already Subscribed into our list.'));
			$error  = esc_html($this->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_error_msg', 'Danger! Something went wrong, Please try Again.'));
						
			if($check_result==0){
				$sub_info = array($email,$fname,$lname,$dob,$phone,$address);
				apply_filters('wpmsems_send_email', $sub_info);
			  $si = $this->wpmsems_subscriber_create($fname,$lname,$dob,$email,$phone,$address,$cat,$camp,$type,$form,$status);
				if($si){
					$this->wpmsems_send_admin_email_notification($fname,$lname,$email,$phone,$address,$dob);
				  echo '<div class="wpmsems_message wpmsems_success">'.$success.'</div>';
				}else{
				   echo '<div class="wpmsems_message wpmsems_error">'.$error.'</div>';
				}
			   }else{
				echo '<div class="wpmsems_message wpmsems_success">'.$already.'</div>';
			   }
			// 	 
			die();
			}
		
			public function add_new_column_into_subscriber_list($columns){
				unset( $columns['title'] );
				unset( $columns['date'] );

						$columns['wpmsems_sub_fname'] = __( 'First Name', 'simple-email-mailchimp-subscriber' );
						$columns['wpmsems_sub_lname'] = __( 'Last Name', 'simple-email-mailchimp-subscriber' );
						$columns['wpmsems_sub_email'] = __( 'Email', 'simple-email-mailchimp-subscriber' );
						$columns['wpmsems_sub_phone'] = __( 'Phone', 'simple-email-mailchimp-subscriber' );
						$columns['wpmsems_sub_address'] = __( 'Address', 'simple-email-mailchimp-subscriber' );
						$columns['wpmsems_sub_dob'] = __( 'Date of Birth', 'simple-email-mailchimp-subscriber' );
						$columns['wpmsems_sub_status'] = __( 'Status', 'simple-email-mailchimp-subscriber' );
						return $columns;
			}
			

		
			public function add_new_value_column_into_subscriber_list( $column, $post_id ) {
				switch ( $column ) {
					case 'wpmsems_sub_fname' :          
					echo get_post_meta($post_id,'wpmsems_first_name',true); 
					break; 
					case 'wpmsems_sub_lname' :          
					echo get_post_meta($post_id,'wpmsems_last_name',true); 
					break; 
					case 'wpmsems_sub_email' :          
					echo get_post_meta($post_id,'wpmsems_email',true); 
					break; 
					case 'wpmsems_sub_phone' :          
					echo get_post_meta($post_id,'wpmsems_phone',true); 
					break; 
					case 'wpmsems_sub_address' :          
					echo get_post_meta($post_id,'wpmsems_address',true); 
					break; 
					case 'wpmsems_sub_dob' :          
					echo get_post_meta($post_id,'wpmsems_dob',true); 
					break; 
					case 'wpmsems_sub_status' :          
					echo "<span class='wotm-ticket-status-".get_post_meta($post_id,'wpmsems_subs_status',true)."'>".ucwords(get_post_meta($post_id,'wpmsems_subs_status',true))."</span>"; 
					break; 
				}
			}
			
	public function wpmsems_ajax_js($id){
	    global $wpmsems;
	    ob_start();
	    ?>
<script type="text/javascript">
  jQuery( "#wpmsems_simple_form_<?php echo $id; ?>" ).submit(function(e) {
     e.preventDefault();
     // alert('Yes');
	 	if( jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_first_name').length ){
        	wpmsems_fname        	 = jQuery(".wpmsems_simple_form_<?php echo $id; ?> #wpmsems_first_name").val().trim();
		}else{
			wpmsems_fname = '';
		}	
		if( jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_last_name').length ){		
        	wpmsems_lname        	 = jQuery(".wpmsems_simple_form_<?php echo $id; ?> #wpmsems_last_name").val().trim();    
		}else{
			wpmsems_lname = '';
		}	
		if( jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_email').length ){					   
        	wpmsems_email         	 = jQuery(".wpmsems_simple_form_<?php echo $id; ?> #wpmsems_email").val().trim(); 
		}else{
			wpmsems_email = '';
		}	
		if( jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_phone').length ){			      
        	wpmsems_phone        	 = jQuery(".wpmsems_simple_form_<?php echo $id; ?> #wpmsems_phone").val().trim();  
		}else{
			wpmsems_phone = '';
		}	
		if( jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_address').length ){				     
        	wpmsems_address        	 = jQuery(".wpmsems_simple_form_<?php echo $id; ?> #wpmsems_address").val().trim(); 
		}else{
			wpmsems_address = '';
		}		 
		if( jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_dob').length ){		     
       	 	wpmsems_dob        	 	 = jQuery(".wpmsems_simple_form_<?php echo $id; ?> #wpmsems_dob").val().trim();  
		}else{
			wpmsems_dob = '';
		}	

        jQuery.ajax({
          type: "POST",
          url:ajaxurl,
          data: {"action": "wpmsems_simple_subscriber", "fname":wpmsems_fname, "lname":wpmsems_lname, "email":wpmsems_email, "phone":wpmsems_phone, "address":wpmsems_address, "dob":wpmsems_dob},
        beforeSend: function(){
            jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_simple_result').html('<span class=wpmsems_process><?php echo $wpmsems->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_sending_message', 'Sending..') ?></span>');
                },          
        success: function(data)
            { 
              jQuery('.wpmsems_simple_form_<?php echo $id; ?> #wpmsems_simple_result').html(data);
            }
          });
         return false;
      })
    </script>	    
<?php
return ob_get_clean();
	}		
}
global $wpmsems;
$wpmsems = new WpmsemsFunctions();



// Ajax Issue
add_action('wp_head','wpmsems_ajax_url',5);
add_action('admin_head','wpmsems_ajax_url',5);
function wpmsems_ajax_url(){
?>
<script type="text/javascript">
// WooCommerce Event Manager Ajax URL
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<?php
}