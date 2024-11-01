<?php
//change email address in db

add_action('wp_ajax_wep_email_change','webemailprotector_email_change');

function webemailprotector_email_change(){
 global $wpdb; //this is how your access the sql db
 check_ajax_referer( 'wep-sec', 'security' );
 if($_SERVER['REQUEST_METHOD']=='POST'){
  $i=$_POST['emo_nu'];
  $email=$_POST['email'];
  $old_email=get_option('wepdb_wep_email_'.$i);
  //if (wep_ctype_digit($i) and filter_var($email, FILTER_VALIDATE_EMAIL)) { 
   if ($email != $old_email) {
    update_option('wepdb_wep_email_'.$i,$email);
    update_option('wepdb_wep_verified_'.$i,'default');
    echo "changed";
   }
   else {
    echo "unchanged";
   }
  //}
  //else { echo "error"; }
 }
 die();// you need this
}

?>