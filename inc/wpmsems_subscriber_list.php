<?php 

add_action( 'admin_menu', 'wpmsems_subscriber_list_menu' );

function wpmsems_subscriber_list_menu() {
  add_submenu_page('wpmsems_settings_page', __('Subscribers List','wpmsems'), __('Subscribers List','wpmsems'), 'manage_options', 'wpmsems_subscriber_lists', 'wpmsems_subscriber_list');
}


function wpmsems_subscriber_list(){
global $wpdb;
$table_name = $wpdb->prefix."wpmsems_subscriber";
 
if(isset($_GET['action'])&&$_GET['action']=='delete_subscriber'){
  // echo 'Yes Did';
  $sb = sanitize_text_field($_GET['sb']);
  $status =3;
    $del = $wpdb->query( $wpdb->prepare("UPDATE $table_name 
                SET status = %d 
             WHERE subscriber_id = %d",$status, $sb)
    );
    if($del){
      ?>
<div id="message" class="updated notice notice-success is-dismissible"><p><?php _e('Subscriber Deleted','wpmsems'); ?> <a href="?page=wpmsems_subscriber_lists&action=undo_delete_subscriber&sub=<?php echo md5($sb); ?>&sb=<?php echo $sb; ?>&subscriber=<?php echo md5($sb); ?>"><?php _e('Undo?','wpmsems'); ?></a></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
    }
}


if(isset($_GET['action'])&&$_GET['action']=='undo_delete_subscriber'){
  // echo 'Yes Did';
  $sb = sanitize_text_field($_GET['sb']);
  $status =1;
    $del = $wpdb->query( $wpdb->prepare("UPDATE $table_name 
                SET status = %d 
             WHERE subscriber_id = %d",$status, $sb)
    );
    if($del){
      ?>
<div id="message" class="updated notice notice-success is-dismissible"><p><?php _e('Subscriber Restored','wpmsems'); ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.','wpmsems'); ?></span></button></div>
      <?php
    }
}
?>
<div class="wrap">
<h2><?php _e('Subscribers List','wpmsems'); ?></h2>
<form action="<?php echo get_admin_url(); ?>edit.php?post_type=wbtm_bus&page=passenger_list" method="get">
<table>
  <tr>

     <td class="the_select">
      <select name="wpmsems_form_id" id="wpmsems_form_id">
      <!-- <option value="0"><?php _e('Please Select a Form','wpmsems'); ?></option> -->
      <option value="1"><?php _e('Default Form','wpmsems'); ?></option>
      <?php do_action('wpmsems_after_form_dropdown_list'); ?>
      </select>
     </td>
     <td class="the_select">
      <select name="wpmsems_source_id" id="wpmsems_source_id">
      <!-- <option value="0"><?php _e('Please Select a Source','wpmsems'); ?></option> -->
      <option value="1"><?php _e('Default Source','wpmsems'); ?></option>
      <?php do_action('wpmsems_after_source_dropdown_list'); ?>
      </select>
     </td>
     <td class="the_select">
      <select name="wpmsems_offer_id" id="wpmsems_offer_id">
      <!-- <option value="0"><?php _e('Please Select a Offer','wpmsems'); ?></option> -->
      <option value="1"><?php _e('Default Offer','wpmsems'); ?></option>
      <?php do_action('wpmsems_after_offer_dropdown_list'); ?>
      </select>
     </td>
     <td class="the_select">
      <button type="submit" id="wpmsems_filter_list"><?php _e('Filter List','wpmsems'); ?></button>
     </td>
</tr>
</table>
<div id="wpmsems_admin_email_result">
 <table class='wp-list-table widefat fixed striped posts'>
<thead>
    <tr>
        <th><?php _e('First Name','wpmsems'); ?></th>
        <th><?php _e('Last Name','wpmsems'); ?></th>
        <th><?php _e('Email','wpmsems'); ?></th>
        <th><?php _e('Phone','wpmsems'); ?></th>
        <!-- <th><?php _e('Address','wpmsems'); ?></th> -->
        <th><?php _e('Birthday','wpmsems'); ?></th>
        <th><?php _e('Form Name','wpmsems'); ?></th>
        <th><?php _e('Source','wpmsems'); ?></th>
        <th><?php _e('Offer','wpmsems'); ?></th>
        <th><?php _e('Action','wpmsems'); ?></th>
        <!--<th><?php _e('Add Datetime','wpmsems'); ?></th>-->
    </tr>
</thead>
<tbody>
    <?php 
      $passger_query = $wpdb->get_results( "SELECT * FROM $table_name WHERE status=1 ORDER BY subscriber_id DESC LIMIT 0,20" );
      foreach ($passger_query as $_passger) {
    ?>
    
       <tr>
        <td><?php echo $_passger->subscriber_fname; ?></td>
        <td><?php echo $_passger->subscriber_lname; ?></td>
        <td><?php echo $_passger->subscriber_email; ?></td>
        <td><?php echo $_passger->subscriber_phone; ?></td>
        <!-- <td><?php echo $_passger->subscriber_address; ?></td> -->
        <td><?php echo $_passger->subscriber_dob; ?></td>
        <td><?php echo wpmsems_get_form_name($_passger->subscriber_form); ?></td>
        <td><?php echo wpmsems_get_source_name($_passger->subscriber_type); ?></td>
        <td><?php echo wpmsems_get_offer_name($_passger->subscriber_camp); ?></td>
        <td><a href="?page=wpmsems_subscriber_lists&action=delete_subscriber&sub=<?php echo md5($_passger->subscriber_id); ?>&sb=<?php echo $_passger->subscriber_id; ?>&subscriber=<?php echo md5($_passger->subscriber_id); ?>"><span style="background: red;color: #fff;font-size: 13px;padding: 2px 10px;">X</span></a></td>
        <!--<td><?php echo $_passger->add_datetime; ?></td>-->
    </tr> 
    <?php } ?>
</tbody>
</table>   
    
</div>
<script type="text/javascript">
  jQuery( "#wpmsems_filter_list" ).click(function(e) {
     e.preventDefault();
     // alert('Yes');
        wpmsems_form_id           = jQuery("#wpmsems_form_id").val().trim();     
        wpmsems_source_id         = jQuery("#wpmsems_source_id").val().trim();     
        wpmsems_offer_id          = jQuery("#wpmsems_offer_id").val().trim();     
     
        jQuery.ajax({
          type: 'POST',
           url:ajaxurl,
          data: {"action": "wpmsems_subscriber_filter", "wpmsems_form_id":wpmsems_form_id, "wpmsems_source_id":wpmsems_source_id, "wpmsems_offer_id":wpmsems_offer_id},
        beforeSend: function(){
            jQuery('#wpmsems_admin_email_result').html('<span class=search-text style="display:block;background:#ddd:color:#000:font-weight:bold;text-align:center">Searching...</span>');
                },          
        success: function(data)
            { 
              jQuery('#wpmsems_admin_email_result').html(data);
            }
          });
         return false;
      })  


  jQuery( ".wpmsems_del_email_item" ).click(function(e) {
     e.preventDefault();
     // alert('Yes');
        wpmsems_capm_id           = jQuery(this).data("id").trim();  
alert(wpmsems_capm_id);

        // jQuery.ajax({
        //   type: 'POST',
        //   url:sebc_ajax.sebc_ajaxurl,
        //   data: {"action": "wpmsems_email_list_by_campaign", "wpmsems_capm_id":wpmsems_capm_id},
        // beforeSend: function(){
        //     jQuery('#wpmsems_admin_email_result').html('<span class=search-text style="display:block;background:#ddd:color:#000:font-weight:bold;text-align:center">Searching...</span>');
        //         },          
        // success: function(data)
        //     { 
        //       jQuery('#wpmsems_admin_email_result').html(data);
        //     }
        //   });
         return false;
      })
</script>
<?php
}