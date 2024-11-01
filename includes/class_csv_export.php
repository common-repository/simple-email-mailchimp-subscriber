<?php
 add_action( 'admin_notices','wpmsems_default_export_btn');
 function wpmsems_default_export_btn() {
     global $typenow;
     if ($typenow == 'wpmsems_subscriber') {
         global $_GET;
         ?>
         <div class="wrap alignright">
             <form method='get' action="edit.php?post_type=wpmsems_subscriber">         
             <input type="hidden" name='action' value='wpmsems_subscriber_default_csv'>       
             <input type="submit" name='export' id="csvExport" value="<?php _e('Export CSV','simple-email-mailchimp-subscriber'); ?>"/>
             </form>
         </div>
         <?php
     }
 }

function wpmsems_csv_head_row($post_id=''){
    global $woocommerce, $post;
    $head_row = array(
        'First Name',
        'Last Name',
        'Email',        
        'Phone',                
        'Address',                
        'Date of Birth'             
    );
    return $head_row;
}

function wpmsems_csv_subscriber_data($post_id=''){
    $subscriber_data = array(
            get_post_meta( $post_id, 'wpmsems_first_name', true ),
            get_post_meta( $post_id, 'wpmsems_last_name', true ),  
            get_post_meta( $post_id, 'wpmsems_email', true ),              
            get_post_meta( $post_id, 'wpmsems_phone', true ),              
            get_post_meta( $post_id, 'wpmsems_address', true ),              
            get_post_meta( $post_id, 'wpmsems_dob', true )                        
    );
return $subscriber_data;
}


// Add action hook only if action=download_csv
if ( isset($_GET['action'] ) && $_GET['action'] == 'wpmsems_subscriber_default_csv' )  {
  // Handle CSV Export
  add_action( 'admin_init', 'wpmsems_export_default_form') ;
}

function wpmsems_export_default_form() {
    // Check for current user privileges 
    if( !current_user_can( 'manage_options' ) ){ return false; }
    // Check if we are in WP-Admin
    if( !is_admin() ){ return false; }
    ob_start();
    $domain = $_SERVER['SERVER_NAME'];
    $filename = 'Subscriber_form' . $domain . '_' . time() . '.csv';
    $header_row      = wpmsems_csv_head_row();   
    $data_rows = array();
    $args_search_qqq = array (
        'post_type'        => array( 'wpmsems_subscriber' ),
        'posts_per_page'   => -1                     
    ); 
    $loop = new WP_Query( $args_search_qqq );

	while ($loop->have_posts()) {
            $loop->the_post();
            $post_id  = get_the_id();

            if (get_post_type($post_id) == 'wpmsems_subscriber') {
                $row      =  wpmsems_csv_subscriber_data($post_id);  
            }
            $data_rows[] = $row;
    }
    wp_reset_postdata();
    $fh = @fopen( 'php://output', 'w' );
    fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Content-Description: File Transfer' );
    header( 'Content-type: text/csv' );
    header( "Content-Disposition: attachment; filename={$filename}" );
    header( 'Expires: 0' );
    header( 'Pragma: public' );
    fputcsv( $fh, $header_row );
    foreach ( $data_rows as $data_row ) {
        fputcsv( $fh, $data_row );
    }
    fclose( $fh );    
    ob_end_flush();    
    die();
}