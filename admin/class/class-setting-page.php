<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

class WpmsemsSettingPage{
    public function __construct(){
        $this->settings_page();
    }

public function settings_page(){
global $wpmsems;

    
$form_builder = array(
    'page_nav' 	=> __( '<i class="far fa-dot-circle"></i> Subscriber Form', 'simple-email-mailchimp-subscriber' ),
    'priority' => 10,
    'page_settings' => array(
        'section_0' => array(
            'options' 	=> array(
                array(
                    'id'		=> 'wpmsems_subscriber_form',
                    'title'		=> __('Form Builder','simple-email-mailchimp-subscriber'),
                    'details'	=> __('Build Your Subcriber Form','simple-email-mailchimp-subscriber'),
                    'collapsible'=>true,
                    'type'		=> 'repeatable',
                    'title_field' => 'label_text',
                    'fields'    => array(                   
                        array(
                            'type'=>'text', 
                            'default'=>'', 
                            'item_id'=>'label_text', 
                            'name'=>'Label Text'
                        ),                                            
                        array(
                            'type'=>'select', 
                            'default'=>'email', 
                            'item_id'=>'form_inputs', 
                            'name'=>'Select Form Item', 
                            'args'=> array(
                                'first_name'=>'First Name Input', 
                                'last_name'=>'Last Name Input', 
                                'email'=>'Email',
                                'phone'=>'Phone',
                                'address'=>'Address',
                                'dob'=>'Date of Birth',
                                'submit'=>'Submit Button',
                            )
                        ),                       
                    ),
                )
            )
        ),
    ),
);


$email_notification = array(
    'page_nav' 	=> __( '<i class="far fa-dot-circle"></i> Email Notification Settings', 'simple-email-mailchimp-subscriber' ),
    'priority' => 10,
    'page_settings' => array(
        'section_0' => array(
            'options' 	=> array(             
                array(
                    'id'		=> 'enable_email_notificaion',
                    'title'		=> __('Enable Admin Email Notification?','simple-email-mailchimp-subscriber'),
                    'details'	=> __('You Can turn on/off admin email notification by Select Yes or No.
                    ','simple-email-mailchimp-subscriber'),
                    'default'		=> 'no',
                    'multiple'		=> false,
                    'type'		=> 'select',
                    'args'		=> array(
                        'yes'	=> __('Yes','simple-email-mailchimp-subscriber'),
                        'no'	=> __('No','simple-email-mailchimp-subscriber')
                    ),
                ),          
                array(
                    'id'		    => 'wpmsems_notification_email',
                    'title'		    => __('Notification Email','simple-email-mailchimp-subscriber'),              
                    'type'		    => 'text',
                ),
                array(
                    'id'		    => 'wpmsems_email_subject',    
                    'title'		    => __('Email Subject','simple-email-mailchimp-subscriber'),   
                    'type'		    => 'text',
                ),
                array(
                    'id'		    => 'wpmsems_form_name',                                
                    'title'		    => __('Form Name','simple-email-mailchimp-subscriber'), 
                    'type'		    => 'text',
                ),
                array(
                    'id'		    => 'wpmsems_form_email',                                
                    'title'		    => __('Form Email','simple-email-mailchimp-subscriber'),
                    'type'		    => 'text',
                ),                                                
                array(
                    'id'		=> 'wpmsems_email_text',
                    'title'		=> __('Email Texts','simple-email-mailchimp-subscriber'),
                    'details'	=> __(' Please enter email text here, available field names are: <strong>{first-name}</strong> <strong>{last-name}</strong> <strong>{email}</strong> <strong>{phone}</strong> <strong>{address}</strong> <strong>{birthday}</strong>','simple-email-mailchimp-subscriber'),
                  //  'editor_settings'=>array('textarea_name'=>'wp_editor_field_obela', 'editor_height'=>'150px'),
                    'placeholder' => __('wp_editor value','simple-email-mailchimp-subscriber'),
                    'default'		=> $wpmsems->wpmsems_get_default_notification_email_text(),
                    'type'		=> 'wp_editor',
                ),
            )
        ),
    ),
);

$message_settings = array(
    'page_nav' 	=> __( '<i class="far fa-dot-circle"></i> Message Settings', 'simple-email-mailchimp-subscriber' ),
    'priority' => 10,
    'page_settings' => array(
        'section_0' => array(
            'options' 	=> array(             
         
                array(
                    'id'		    => 'wpmsems_sending_message',
                    'title'		    => __('Sending Message','simple-email-mailchimp-subscriber'),              
                    'type'		    => 'text',
                    'default'		=> 'Sending...',
                    'details'		=> 'This Text will be show after after click the subscriber button',
                ),
                array(
                    'id'		    => 'wpmsems_success_msg',    
                    'title'		    => __('Success Message','simple-email-mailchimp-subscriber'),   
                    'type'		    => 'text',
                    'default'		=> 'Congratulation! You Just Subscribed to our list.',
                    'details'		=> 'This Text will be show after successfully subscribed',                    
                ),
                array(
                    'id'		    => 'wpmsems_already_exixts_msg',
                    'title'		    => __('Alredy subscribed Message','simple-email-mailchimp-subscriber'), 
                    'type'		    => 'text',
                    'default'		=> 'Congratulation! Youre already Subscribed into our list.',
                    'details'		=> 'This Text will be show after already subscribed email
                    ',                    
                ),
                array(
                    'id'		    => 'wpmsems_error_msg',                                
                    'title'		    => __('Error Message','simple-email-mailchimp-subscriber'),
                    'type'		    => 'text',
                    'default'		=> 'Danger! Something went wrong, Please try Again.',
                    'details'		=> 'This Text will be show in error',                       
                ),                                                
            )
        ),
    ),
);


$mailchimp_settings = array(
    'page_nav' 	=> __( '<i class="far fa-dot-circle"></i> Mailchimp Settings', 'simple-email-mailchimp-subscriber' ),
    'priority' => 10,
    'page_settings' => array(
        'section_0' => array(
            'options' 	=> array(             
                array(
                    'id'		=> 'enable_mailchimp',
                    'title'		=> __('Enable MailChimp?','simple-email-mailchimp-subscriber'),
                    'details'	=> __('You Can turn on/off the MailChimp Saveing by Select Yes or No.','simple-email-mailchimp-subscriber'),
                    'default'		=> 'no',
                    'multiple'		=> false,
                    'type'		=> 'select',
                    'args'		=> array(
                        'yes'	=> __('Yes','simple-email-mailchimp-subscriber'),
                        'no'	=> __('No','simple-email-mailchimp-subscriber')
                    ),
                ),         
                array(
                    'id'		    => 'wpmsems_mailchimp_api_key',
                    'title'		    => __('Mailchimp API Key','simple-email-mailchimp-subscriber'),              
                    'type'		    => 'text',
                    'default'		=> '',
                    'details'		=> 'Please Enter API key v-3',
                ), 
                array(
                    'id'		=> 'mailchimp_subscriber_list',
                    'title'		=> __('Subscriber List','simple-email-mailchimp-subscriber'),
                    'details'	=> __('Please Select a Subscriber List where you want to save subscriber information','simple-email-mailchimp-subscriber'),
                    'default'		=> 'no',
                    'multiple'		=> false,
                    'type'		=> 'select',
                    'args'		=> wpmsemse_get_mailchimp_subcriber_list(),
                ),               
                




            )
        ),
    ),
);






$args = array(
	'add_in_menu'       => true,
	'menu_type'         => 'sub',
    'menu_name'         => __( 'Settings', 'simple-email-mailchimp-subscriber' ),
	'menu_title'        => __( 'Settings', 'simple-email-mailchimp-subscriber' ),
	'page_title'        => __( 'Settings', 'simple-email-mailchimp-subscriber' ),
	'menu_page_title'   => __( 'Settings', 'simple-email-mailchimp-subscriber' ),
	'capability'        => "manage_options",
	'cpt_menu'          => "edit.php?post_type=wpmsems_subscriber",
	'menu_slug'         => "wpmsems-settings",
    'option_name'       => "wpmsems_settings",
    'menu_icon'         => "dashicons-image-filter",

    'item_name'         => "Simple Subscriber Settings",
    'item_version'      => "1.0.0",
    'panels' 	        => apply_filters('wpmsems_submenu_setings_panels', array(
		'form-buider'        => $form_builder,
		'email_notification' => $email_notification,
		'message_settings ' => $message_settings,
		'mailchimp_settings ' => $mailchimp_settings,

    )),
);
$AddThemePage = new AddThemePage( $args );
}
}
new WpmsemsSettingPage();