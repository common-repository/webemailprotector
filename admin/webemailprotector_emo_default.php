<?php
//remove emo from db

add_action('wp_ajax_wep_emo_default','webemailprotector_emo_default');

function webemailprotector_emo_default(){
 global $wpdb; //this is how your access the sql db
 check_ajax_referer( 'wep-sec', 'security' );
 if($_SERVER['REQUEST_METHOD']=='GET'){
  $i=$_GET['emo_nu'];
  $wep_email=$_GET['email']; //just a pass through and out for the js alert
  if (ctype_digit($i)){
   update_option('wepdb_wep_verified_'.$i,'default');
   update_option('wepdb_wep_emo_'.$i,'xxxx-xxxx-xxxx-xxxx-xxxx');
   $arr = array(
    'emo_nu'=>$i,
	'email'=>$wep_email
   );
   echo json_encode($arr);
  }
 }
 die();
}

?>