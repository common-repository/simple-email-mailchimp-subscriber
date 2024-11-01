<?php 
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

// Enqueue Scripts for frontend
add_action('wp_enqueue_scripts', 'wpmsems_enqueue_scripts');
function wpmsems_enqueue_scripts() {
   wp_enqueue_script('jquery');
   wp_enqueue_style('sebc-bus-style',plugin_dir_url( __DIR__ ).'css/style.css',array());
}


function wpmsems_ajax_call_url(){
    wp_localize_script('jquery', 'wpmsems_ajax', array( 'wpmsems_ajaxurl' => admin_url( 'admin-ajax.php')));
}
add_action('admin_enqueue_scripts','wpmsems_ajax_call_url');
add_action('wp_enqueue_scripts','wpmsems_ajax_call_url');