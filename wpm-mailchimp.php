<?php
/**
* Plugin Name: Simple Email & MailChimp Subscriber
* Plugin URI: https://wpmonkeys.com/
* Description: A Ajax powred mailchimp Subscriber form by WP Monkeys.
* Version: 2.2.3
* Author: WP Monkey's
* Author URI: https://wpmonkeys.com
* Text Domain: simple-email-mailchimp-subscriber
* Domain Path: /languages/
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once(dirname(__FILE__) . "/lib/MailChimp.php");
use \DrewM\MailChimp\MailChimp;

function wpmsems_activate_mage_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-activator.php';
}

function wpmsems_deactivate_mage_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-deactivator.php';
}

register_activation_hook( __FILE__, 'wpmsems_activate_mage_plugin' );
register_deactivation_hook( __FILE__, 'wpmsems_deactivate_mage_plugin' );


class WpmSemsBase{
	
	public function __construct(){
		$this->define_constants();
		$this->load_main_class();
		$this->run_plugin();
	}

	public function define_constants() {
		define( 'WPMSEMS_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
		define( 'WPMSEMS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'WPMSEMS_PLUGIN_FILE', plugin_basename( __FILE__ ) );
		define( 'WPMSEMS_TEXTDOMAIN', 'mage-plugin' );
	}

	public function load_main_class(){
		require WPMSEMS_PLUGIN_DIR . 'includes/class-plugin.php';
	}

	public function run_plugin() {
		$plugin = new WpmsemsPlugin();
		$plugin->run();
	}
}
new WpmSemsBase();

function wpmsemse_get_mailchimp_subcriber_list(){
	global $wpmsems;
	$api = $wpmsems->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_mailchimp_api_key','' );
		if(!empty($api)){
		  $MailChimp = new MailChimp($api);
		  $result = $MailChimp->get('lists');
		  $subscriber_arr = $result['lists'];
		  $mc_list = array();
			  foreach ($subscriber_arr as $_sub_arr) {
						$name         = $_sub_arr['name'];
						$id         = $_sub_arr['id'];
						$total_sub  = $_sub_arr['stats']['member_count'];
						$mc_list[$id] = $name." (".$total_sub.")";
			  }
		}else{
		  $mc_list = array('0' => 'Please Save API Key First');
		}
		return $mc_list;
}

function wpmsems_add_subscriber_into_mailchimp($fname,$lname,$email,$phone,$address,$dob){
	global $wpmsems;
	$api = $wpmsems->wpmsems_get_option( 'wpmsems_settings', 'wpmsems_mailchimp_api_key','' );
	$api_status  = $wpmsems->wpmsems_get_option( 'wpmsems_settings', 'enable_mailchimp','no' );
	$api_subscriber_list 	 = $wpmsems->wpmsems_get_option( 'wpmsems_settings', 'mailchimp_subscriber_list','0' );
	if($api_status == 'yes'){
	$MailChimp = new MailChimp($api);
	$result = $MailChimp->post("lists/$api_subscriber_list/members", [
				'email_address' => $email,
				'status'        => 'subscribed',
					"merge_fields" => array(
					'FNAME'     => $fname,
					'LNAME'     => $lname,
					"PHONE"		=> $phone,
					"ADDRESS"	=> $address
				)
			]);
	}
}

