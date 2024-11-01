<?php
/**
 * 2AM Awesome loginbar Settings Controls
 *
 * @version 1.0
 *
 */
if ( !class_exists('WPMSEMS_Setting_Controls' ) ):
class WPMSEMS_Setting_Controls {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WPM_Setting_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }
 
    function admin_menu() {
         add_menu_page( __('Simple Subscriber','wpmsems'), __('Simple Subscriber','wpmsems'), 'manage_options', 'wpmsems_settings_page', array($this, 'plugin_page'), 'dashicons-welcome-widgets-menus');
    }

    function get_settings_sections() {

        $sections = array(
            array(
                'id' => 'wpmsems_email_setting_sec',
                'title' => __( 'Email Notification Settings', 'wpmsems' )
            ),            
            array(
                'id' => 'wpmsems_mailchimp_setting_sec',
                'title' => __( 'Mailchimp Settings', 'wpmsems' )
            ),
            array(
                'id' => 'wpmsems_default_form_setting_sec',
                'title' => __( 'Form Settings', 'wpmsems' )
            ),
            array(
                'id' => 'wpmsems_default_form_message_sec',
                'title' => __( 'Message Settings', 'wpmsems' )
            )            

        );



        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wpmsems_email_setting_sec' => array(
                array(
                    'name' => 'wpmsems_admin_email_notification',
                    'label' => __( 'Enable Admin Email Notification?', 'wpmsems' ),
                    'desc' => __( 'You Can turn on/off admin email notification by Select Yes or No.', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'no',
                    'options' =>  array(
                        'yes' => 'Yes',
                        'no' => 'No'
                    )
                ),
                array(
                    'name' => 'wpmsems_admin_noification_email',
                    'label' => __( 'Notification Email', 'wpmsems' ),
                    'desc' => __( 'Please enter a emailaddress where you want to recieve notification', 'wpmsems' ),
                    'type' => 'text',
                    'default' => get_bloginfo('admin_email')
                ),                 
                array(
                    'name' => 'wpmsems_admin_noification_subject',
                    'label' => __( 'Email Subject', 'wpmsems' ),
                    'desc' => __( 'Please enter notification email subject', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'New Subscriber'
                ),  
                array(
                    'name' => 'wpmsems_admin_noification_form_name',
                    'label' => __( 'Form Name', 'wpmsems' ),
                    'desc' => __( 'Please enter notification email form name', 'wpmsems' ),
                    'type' => 'text',
                    'default' => get_bloginfo('name')
                ),  
                array(
                    'name' => 'wpmsems_admin_noification_form_email',
                    'label' => __( 'Form Email', 'wpmsems' ),
                    'desc' => __( 'Please enter notification email subject', 'wpmsems' ),
                    'type' => 'text',
                    'default' => get_bloginfo('admin_email')
                ),                 
                array(
                    'name' => 'wpmsems_admin_noification_email_body',
                    'label' => __( 'Email Text', 'wpmsems' ),
                    'desc' => __( 'Please enter email text here, available field names are: <strong>{first-name}</strong> <strong>{last-name}</strong> <strong>{email}</strong> <strong>{phone}</strong> <strong>{address}</strong> <strong>{birthday}</strong>', 'wpmsems' ),
                    'type' => 'wysiwyg',
                    'default' =>wpmsems_get_default_notification_email_text()
                ),                                               
            ),
            'wpmsems_mailchimp_setting_sec' => array(
                array(
                    'name' => 'wpmsems_mailchimp_api',
                    'label' => __( 'Mailchimp API Key', 'wpmsems' ),
                    'desc' => __( 'Please Enter API key v-3', 'wpmsems' ),
                    'type' => 'text',
                    'default' => ''
                ),
                array(
                    'name' => 'wpmsems_mailchimp_status',
                    'label' => __( 'Enable MailChimp?', 'wpmsems' ),
                    'desc' => __( 'You Can turn on/off the MailChimp Saveing by Select Yes or No.', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'no',
                    'options' =>  array(
                        'yes' => 'Yes',
                        'no' => 'No'
                    )
                ),
                array(
                    'name' => 'wpmsems_mailchimp_subscriber_list',
                    'label' => __( 'Subscriber List','wpmsems' ),
                    'desc' => __( 'Select A List where you want to save email address', 'wpmsems' ),
                    'type' => 'select',
                    'options' =>  wpmsemse_get_mailchimp_subcriber_list()
                ),
            ),
            'wpmsems_default_form_setting_sec' => array(
                
                array(
                    'name' => 'wpmsems_form_fname',
                    'label' => __( 'First Name', 'wpmsems' ),
                    'desc' => __( 'Select Show/hide to show First Name Field into the Form', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'hidden',
                    'options' =>  array(
                        'text' => 'Show',
                        'hidden' => 'Hide'
                    )
                ),   
                array(
                    'name' => 'wpmsems_form_fname_label',
                    'label' => __( 'First Name Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Field Label text & Placeholder text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'First Name'
                ),                             
                array(
                    'name' => 'wpmsems_form_lname',
                    'label' => __( 'Last Name', 'wpmsems' ),
                    'desc' => __( 'Select Show/hide to show Last Name Field into the Form', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'hidden',
                    'options' =>  array(
                        'text' => 'Show',
                        'hidden' => 'Hide'
                    )
                ),
                array(
                    'name' => 'wpmsems_form_lname_label',
                    'label' => __( 'Last Name Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Field Label text & Placeholder text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Last Name'
                ),                                
                array(
                    'name' => 'wpmsems_form_email',
                    'label' => __( 'Email', 'wpmsems' ),
                    'desc' => __( 'Select Show/hide to show Email Field into the Form', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'email',
                    'options' =>  array(
                        'email' => 'Show',
                        'hidden' => 'Hide'
                    )
                ), 
                array(
                    'name' => 'wpmsems_form_email_label',
                    'label' => __( 'Email Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Field Label text & Placeholder text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Your Email Address'
                ),                               
                array(
                    'name' => 'wpmsems_form_phone',
                    'label' => __( 'Phone', 'wpmsems' ),
                    'desc' => __( 'Select Show/hide to show Phone Field into the Form', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'hidden',
                    'options' =>  array(
                        'text' => 'Show',
                        'hidden' => 'Hide'
                    )
                ), 
                array(
                    'name' => 'wpmsems_form_phone_label',
                    'label' => __( 'Phone Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Field Label text & Placeholder text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Your Phone Number'
                ),                               
                array(
                    'name' => 'wpmsems_form_address',
                    'label' => __( 'Address', 'wpmsems' ),
                    'desc' => __( 'Select Show/hide to show Address Field into the Form', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'hidden',
                    'options' =>  array(
                        'show' => 'Show',
                        'hidden' => 'Hide'
                    )
                ), 
                array(
                    'name' => 'wpmsems_form_address_label',
                    'label' => __( 'Address Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Field Label text & Placeholder text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Your Address'
                ),                               
                array(
                    'name' => 'wpmsems_form_dob',
                    'label' => __( 'Date of Birth', 'wpmsems' ),
                    'desc' => __( 'Select Show/hide to show Date of Birth Field into the Form', 'wpmsems' ),
                    'type' => 'select',
                    'default' => 'hidden',
                    'options' =>  array(
                        'date' => 'Show',
                        'hidden' => 'Hide'
                    )
                ),
                array(
                    'name' => 'wpmsems_form_dob_label',
                    'label' => __( 'Date of Birth Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Field Label text & Placeholder text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Select your Birthdate'
                ),                

                array(
                    'name' => 'wpmsems_form_bn_label',
                    'label' => __( 'Subscribe Button Label', 'wpmsems' ),
                    'desc' => __( 'This Text will be show as Button text', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Subscribe NOW!'
                ),
            ),
              'wpmsems_default_form_message_sec' => array(
                
                array(
                    'name' => 'wpmsems_form_sending_msg',
                    'label' => __( 'Sending Message', 'wpmsems' ),
                    'desc' => __( 'This Text will be show after after click the subscriber button', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Sending...'
                ),                 
                array(
                    'name' => 'wpmsems_form_sucess_msg',
                    'label' => __( 'Success Message', 'wpmsems' ),
                    'desc' => __( 'This Text will be show after successfully subscribed', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Congratulation! You Just Subscribed to our list.'
                ),                
                array(
                    'name' => 'wpmsems_form_already_sucess_msg',
                    'label' => __( 'Alredy subscribed Message', 'wpmsems' ),
                    'desc' => __( 'This Text will be show after already subscribed email', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Congratulation! Youre already Subscribed into our list.'
                ),                
                array(
                    'name' => 'wpmsems_form_error_msg',
                    'label' => __( 'Error Message', 'wpmsems' ),
                    'desc' => __( 'This Text will be show in error', 'wpmsems' ),
                    'type' => 'text',
                    'default' => 'Danger! Something went wrong, Please try Again.'
                ),
              )








        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

$settings = new WPMSEMS_Setting_Controls();



function wpmsems_get_option( $option, $section, $default = '' ) {
    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}