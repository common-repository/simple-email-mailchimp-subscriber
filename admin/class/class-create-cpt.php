<?php 
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
class WpmsemsCpt{
	
	public function __construct(){
		add_action( 'init', array($this, 'register_cpt' ));
	}
	public function register_cpt(){
	    $labels = array(
	        'name'                  => _x( 'Subscriber List', 'simple-email-mailchimp-subscriber' ),
	    );
	    $args = array(
	        'public'                => true,
	        'labels'                => $labels,
	        'menu_icon'             => 'dashicons-layout',
	        'supports'              => array('title'),
	        'rewrite'               => array('slug' => 'subscriber')

	    );
	   	 register_post_type( 'wpmsems_subscriber', $args );

	}

}
new WpmsemsCpt();