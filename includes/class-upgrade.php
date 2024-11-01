<?php 
add_action('init','wpmsems_upgrde_old_data_to_new');
function wpmsems_upgrde_old_data_to_new(){
global $wpdb,$wpmsems;
$table_name = $wpdb->prefix.'wpmsems_subscriber';
$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
    if (  $wpdb->get_var( $query ) == $table_name && empty(get_option('wpmsems_upgrade_v1')) && get_option('wpmsems_upgrade_v1') != yes) {
        $passger_query = $wpdb->get_results( "SELECT * FROM $table_name WHERE status=1 ORDER BY subscriber_id DESC" );
        foreach ($passger_query as $_passger) {
            $fname      = $_passger->subscriber_fname;
            $lname      = $_passger->subscriber_lname;
            $email      = $_passger->subscriber_email;
            $phone      = $_passger->subscriber_phone;
            $address    = $_passger->subscriber_address;
            $dob        = $_passger->subscriber_dob;
            $cat        = 1;
            $camp       = 1;
            $type       = 1;
            $form       = 1;
            $status     = 'Active';
           $si = $wpmsems->wpmsems_subscriber_create($fname,$lname,$dob,$email,$phone,$address,$cat,$camp,$type,$form,$status);
        }
        update_option('wpmsems_upgrade_v1', 'yes');
    }
}