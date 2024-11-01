<?php
//add additional emo to db

add_action('wp_ajax_wep_emo_verify','webemailprotector_emo_verify');

function webemailprotector_emo_verify(){
 global $wpdb; //this is how your access the sql db
 check_ajax_referer( 'wep-sec', 'security' );
 if($_SERVER['REQUEST_METHOD']=='GET'){
  $wep_code_1=$_GET['code_1'];
  $wep_code_2=$_GET['code_2']; 
  $wep_code_3=$_GET['code_3'];
  $wep_code_4=$_GET['code_4'];
  $wep_code_5=$_GET['code_5'];
  $i=$_GET['emo_nu'];
  $wep_email=$_GET['email']; //just a pass through and out for the js alert
  if (wep_ctype_digit($i) and wep_ctype_alnum($wep_code_1) and wep_ctype_alnum($wep_code_2) and wep_ctype_alnum($wep_code_3) and wep_ctype_alnum($wep_code_4) and wep_ctype_alnum($wep_code_5) ){
   $wep_code=$wep_code_1.'-'.$wep_code_2.'-'.$wep_code_3.'-'.$wep_code_4.'-'.$wep_code_5;
   update_option('wepdb_wep_verified_'.$i,'true');
   update_option('wepdb_wep_emo_'.$i,$wep_code);
   $arr = array(
    'code'=>$wep_code,
    'emo_nu'=>$i,
	'email'=>$wep_email
   );
   echo json_encode($arr);
  }
 }
 die(); // you need this
}

?>