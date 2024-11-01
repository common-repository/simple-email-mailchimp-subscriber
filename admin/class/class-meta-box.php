<?php

if ( ! defined('ABSPATH')) exit;  // if direct access 


class WpmsemsMetaBoxs{

    public function __construct(){
        $this->meta_boxs();
    }
    public function meta_boxs(){
            $page_1_options = array(        
                'sections' => array(


                    'section_0' => array(
                        'title' 	=> 	__('General Information','text-domain'),
                        'description' 	=> __('','text-domain'),
                        'options' 	=> array(
                        
                            array(
                                'id'		    => 'wpmsems_first_name',                                
                                'title'		    => __('Firs Name','simple-email-mailchimp-subscriber'),                              
                                'type'		    => 'text',
                            ),
                        
                            array(
                                'id'		    => 'wpmsems_last_name',                                
                                'title'		    => __('Last Name','simple-email-mailchimp-subscriber'),                              
                                'type'		    => 'text',
                            ),
                        
                            array(
                                'id'		    => 'wpmsems_email',                                
                                'title'		    => __('Email','simple-email-mailchimp-subscriber'),                              
                                'type'		    => 'text',
                            ),
                        
                            array(
                                'id'		    => 'wpmsems_phone',                                
                                'title'		    => __('Phone','simple-email-mailchimp-subscriber'),                              
                                'type'		    => 'text',
                            ),
                        
                            array(
                                'id'		    => 'wpmsems_address',                                
                                'title'		    => __('Address','simple-email-mailchimp-subscriber'),                              
                                'type'		    => 'text',
                            ),
                        
                            array(
                                'id'		    => 'wpmsems_dob',                                
                                'title'		    => __('Date of Birth','simple-email-mailchimp-subscriber'),                              
                                'type'		    => 'datepicker',
                            ),
                        )
                    ),
                ),
            );
            $args = array(
                'meta_box_id'       => 'wpmsems_subscriber_meta',
                'meta_box_title'    => __( 'Subscriber Information', 'simple-email-mailchimp-subscriber' ),
                //'callback'       => '_meta_box_callback',
                'screen'            => array( 'wpmsems_subscriber'),
                'context'           => 'normal', // 'normal', 'side', and 'advanced'
                'priority'          => 'high', // 'high', 'low'
                'callback_args'     => array(),
                'nav_position'      => 'none', // right, top, left, none
                'item_name'         => "WP Monkeys",
                'item_version'      => "1.0.2",
                'panels' 	        => array(
                    'panelGroup-1'        => $page_1_options,

                ),
            );

            $AddMenuPage = new AddMetaBox( $args );
    }
}
new WpmsemsMetaBoxs();