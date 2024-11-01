<?php
/*
Plugin Name: WebEmailProtector
Plugin URI: https://www.webemailprotector.com
Description: Safely add your contact email addresses on your WordPress website with the best protection against spammers. Go to the WebEmailProtector <a href="options-general.php?page=webemailprotector_plugin_options.php">Settings</a> menu to configure.
Version: 3.3.6
Author: WebEmailProtector
Author URI: https://www.webemailprotector.com/about.html
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/*  Copyright 2013-2022 DAVID SRODZINSKI WEBEMAILPROTECTOR  (email : david@webemailprotector.com)

    This program is free software for a period; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation. 
    
    The EMO API license key provided requires to be activated after 1 month if
    you are to continue using it. This is on a annual subscription basis unless otherwise stated on the 
    web site. Please visit https://www.webemailprotector.com.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

// be sure to edit in Notepad++ and save with option without BOM otherwise strange character errors result //

//add the additional php modules that do the db updates from the ajax calls
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_emo_new.php'); //adds new entry
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_emo_delete.php'); //deleted entry
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_emo_verify.php'); // validates entry
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_emo_unverify.php'); // in-validates entry
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_emo_default.php'); // sets to default
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_email_change.php'); //updates email in db
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_displayname_change.php'); //updates display text in db
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_email_get.php'); //retrieves email address from db
require_once(plugin_dir_path(__FILE__).'admin/webemailprotector_functions.php'); //general functions

// function to add script code to <head>
function webemailprotector_insertheaderscript() {
 if (!is_admin()) { //any java for published
  // #1 make sure ajax is loaded just inincase not done so already
  // *** load Standard WP jQuery version jquery-1.12.4.min.js
  wp_enqueue_script('jquery'); //incase not already loaded - shite as does not support $.ajax()
  // *** load more secure/newer jQuery version jquery-3.5.1.min- however beware as breaks some sites!
  //wp_deregister_script('jquery');
  //wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), null, true);
  // #2 load the emo script in the header
  $scripturl = 'https://www.webemailprotector.com/cgi-bin/emo.js';
  $randver = rand(1,100000);
  wp_enqueue_script('webemailprotector_headerscripts',$scripturl,array('jquery'),$randver,true);
 }
 if (is_admin()) { //any java for settings etc
  $scripturl = plugin_dir_url(__FILE__).'scripts/webemailprotector_adminscripts.js';
  wp_enqueue_script('jquery'); //incase not already loaded - leave the admin alone though with the oldest and use Jquery.ajax()
  wp_enqueue_script('webemailprotector_adminscripts',$scripturl);
  wp_localize_script( 'webemailprotector_adminscripts', 'MyAjax', array(
    // URL to wp-admin/admin-ajax.php to process the request
    'ajaxurl'          => admin_url( 'admin-ajax.php' ),
    // nonce to check security with ajax calls
    'security' => wp_create_nonce( 'wep-sec' ),
    ));
  }
}
//do it
add_action('wp_print_scripts','webemailprotector_insertheaderscript');

//function to style admin settings pages from the local css
function webemailprotector_admin_style() {
 $cssurl = plugin_dir_url(__FILE__).'css/webemailprotector_adminsettings.css';
 wp_enqueue_style('my-admin-theme', $cssurl);
}
if (file_exists(plugin_dir_path(__FILE__).'css/webemailprotector_adminsettings.css')) {
 add_action('admin_enqueue_scripts', 'webemailprotector_admin_style');
}

function webemailprotector_emailstyle() {
 $cssurl = plugin_dir_url(__FILE__).'css/webemailprotector_emailstyle.css';
 wp_enqueue_style('wep-theme1', $cssurl);
}
if (file_exists(plugin_dir_path(__FILE__).'css/webemailprotector_emailstyle.css')) {
 add_action('wp_enqueue_scripts', 'webemailprotector_emailstyle');
}

function webemailprotector_youremailstyle() {
 $cssurl = plugin_dir_URL(__FILE__).'css/webemailprotector_youremailstyle.css';
 wp_enqueue_style('wep-theme2', $cssurl);
}
if (!file_exists(plugin_dir_path(__FILE__).'css/webemailprotector_youremailstyle.css')) {
 $data='/* PUT YOUR SPECIFIC EMAIL FORMATTING HERE*/'.PHP_EOL.PHP_EOL.'a.wep_email {}'.PHP_EOL.PHP_EOL.'a.wep_email:hover {}'.PHP_EOL;
 file_put_contents(plugin_dir_path(__FILE__).'css/webemailprotector_youremailstyle.css' , $data);
}
if (file_exists(plugin_dir_path(__FILE__).'css/webemailprotector_youremailstyle.css')) {
 add_action('wp_enqueue_scripts', 'webemailprotector_youremailstyle');
}

// function to add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'webemailprotector_settings_link');
function webemailprotector_settings_link($links) {
 $settings_link='<a href="options-general.php?page=webemailprotector_plugin_options.php">Settings</a>';
 array_unshift($links,$settings_link);
 return $links;
}

// function to add plugin settings to admin sidebar
add_action('admin_menu','webemailprotector_admin_sidemenu');
function webemailprotector_admin_sidemenu() {
  add_options_page('My Plugin Options', 'WebEmailProtector', 'manage_options', 'webemailprotector_plugin_options', 'webemailprotector_plugin_options');
}

// function triggered when plugin activated
// but does not work as does not like the echos ..... maybe should do an enque script
function webemailprotector_activate() {
  $wep_current_user = wp_get_current_user();
  $wep_current_user_email = $wep_current_user->user_email;   
  $scripturl = plugin_dir_url(__FILE__).'scripts/webemailprotector_initscripts.js';
  wp_enqueue_script('webemailprotector_initscript',$scripturl,array('jquery'));
}
register_activation_hook( __FILE__, 'webemailprotector_activate' );

//this is the main function to add the settings logic and markup
function webemailprotector_plugin_options() {
  if (!current_user_can('manage_options')) {
    wp_die( __('You do not have sufficient permissions to access this page.'));
  }
  //setup secure code
  $ajax_nonce = wp_create_nonce( "wep-sec-string" );
  // reset database during dev only (can remove later) or on first instantiation create 5 blanks
  $wep_reset_db = false;
  // any emails stored?
  $wep_current_user = wp_get_current_user();
  $wep_current_user_email = $wep_current_user->user_email;
  //set up version ver
  $wep_ver='v3.3.6';
  $wep_init = false;
  if ( get_option('wepdb_wep_ver') == true ) {
   if (get_option('wepdb_wep_ver') != $wep_ver){
     $wep_ver_old=get_option('wepdb_wep_ver');
     $wep_reason='upgrade from '.$wep_ver_old;
	 update_option('wepdb_wep_ver',$wep_ver);
	 $wep_init = true;}
  }
  else { 
   if ( get_option('wepdb_nuemails') == true ) {
    $wep_reason='upgrade from pre v1.1.1';}
   else {
    $wep_reason='new install';}	
   add_option('wepdb_wep_ver',$wep_ver);
   $wep_init = true;
  }
  //log the fact that a new version has been initialised
  if ( $wep_init == true ) {
   echo '<script type="text/javascript">';
   echo 'webemailprotector_emo_init("'.$wep_current_user_email.'","'.$wep_ver.'","'.$wep_reason.'");';
   echo '</script>';
   }
  if (( $wep_reset_db == true ) or ( get_option('wepdb_nuemails') == false )){
   if ( get_option('wepdb_nuemails') == true) {delete_option('wepdb_nuemails');}
   add_option('wepdb_nuemails','5'); //this holds the number stored in the dB
   if ( get_option('wepdb_nextemail') == true) {delete_option('wepdb_nextemail');}
   add_option('wepdb_nextemail','6'); //this holds the next one to add to aid delete & refresh operations
   $wep_nuemails = get_option('wepdb_nuemails');
   for ($i = 1;$i <=$wep_nuemails; $i++) {
    if ( get_option('wepdb_wep_entry_'.$i) == true ) { delete_option('wepdb_wep_entry_'.$i) ;}
	add_option('wepdb_wep_entry_'.$i,'emo_'.$i);
   	if ( get_option('wepdb_wep_email_'.$i) == true ) { delete_option('wepdb_wep_email_'.$i) ; }
	add_option('wepdb_wep_email_'.$i,'youremail'.$i.'@yourdomain');
    if ( get_option('wepdb_wep_emo_'.$i) == true ) { delete_option('wepdb_wep_emo_'.$i) ; }
	add_option('wepdb_wep_emo_'.$i,'xxxx-xxxx-xxxx-xxxx-xxxx');
    if ( get_option('wepdb_wep_display_name_'.$i) == true ) { delete_option('wepdb_wep_display_name_'.$i) ; }
    add_option('wepdb_wep_display_name_'.$i,'your display text '.$i);
	if ( get_option('wepdb_wep_verified_'.$i) == true) { delete_option('wepdb_wep_verified_'.$i) ; }
	add_option('wepdb_wep_verified_'.$i,'false');
    }
  }
  
  // if so then load up the data to local variables for displaying
  if ( get_option('wepdb_nuemails') == true ) { 
   $wep_nextemail = get_option('wepdb_nextemail');
   $l=0;
   for ($i = 1;$i <$wep_nextemail; $i++) {
    //when refresh get rid of any old db that have been deleted to auto compress db
	if (get_option('wepdb_wep_entry_'.$i) == false) { //then has been deleted and need to cleanse that line of the db and shuffle it
	  //do nowt as empty
	  }
	else {
	 $l++;
	 update_option('wepdb_wep_entry_'.$l,'emo_'.$l);
	 ${'wep_email_'.$l} = get_option('wepdb_wep_email_'.$i);
	 update_option('wepdb_wep_email_'.$l,${'wep_email_'.$l});
     ${'wep_emo_'.$l} = get_option('wepdb_wep_emo_'.$i);
	 update_option('wepdb_wep_emo_'.$l,${'wep_emo_'.$l});
     ${'wep_display_name_'.$l} = get_option('wepdb_wep_display_name_'.$i);
	 update_option('wepdb_wep_display_name_'.$l,${'wep_display_name_'.$l});
     ${'wep_verified_'.$l} = get_option('wepdb_wep_verified_'.$i);
	 update_option('wepdb_wep_verified_'.$l,${'wep_verified_'.$l});
	 }
	}
	//delete any left over crud
    for ($i = ($l+1); $i <$wep_nextemail; $i++) {
     delete_option('wepdb_wep_entry_'.$i);
     delete_option('wepdb_wep_email_'.$i);
     delete_option('wepdb_wep_emo_'.$i);
     delete_option('wepdb_wep_display_name_'.$i);
     delete_option('wepdb_wep_verified_'.$i);
    }
   $wep_nuemails=$l;
   update_option('wepdb_nuemails',$l);
   $wep_nextemail = intval($wep_nuemails)+1;
   update_option('wepdb_nextemail',$wep_nextemail); //update on refresh so always pointing to next new one to add
  }
  // do the display stuff
  echo '<div class="webemailprotector_admin_wrap">';
  echo '<br />';
  echo '<br />';
  echo '<div><img class="topblock" src="'.plugin_dir_url(__FILE__).'images/webemailprotector_logo.png" width="398px" height="102px"/>';
  echo '<h1 class="topblock">'.$wep_ver.'&nbsp;&nbsp;&nbsp;Plugin Settings & Instructions Menu</h1>';
  echo '<p class="topblock">';
  echo ' - Get an Email Security Key for each email address and then Verify it <b>(STEP1)</b>.<br>';
  echo ' - Enter the replacement Text that you want to Display On Screen to the user <b>(STEP2)</b>.<br>';
  echo ' - Place your shortcode(s) anywhere on your site <b>(STEP3)</b>.</p></div>';
  
  echo'<br><br><br>';
  
  echo '<form action="" name="wep_settings" method="POST">';
  echo '<table id="wep_table" class="wep_main"><tbody>';
  echo '<tr>';
  echo '<th colspan="3">SECURED EMAIL ADDRESS<br><i>(put your email here)</i></th>';
  echo '<th>TEXT TO DISPLAY ON SCREEN<br><i>(do not put your email here)</i></th>';
  echo '<th colspan="3"></th>';
  echo '</tr>';
  $php_pathname='\''.plugin_dir_url(__FILE__).'admin'.'\'';

  if ( home_url() ) { $wep_domain = home_url(); } // references the General > Settings "Site Address (URL)" field label.
  elseif ( site_url() ) {  $wep_domain = site_url(); } // references the General > Settings  "WordPress Address (URL)" field label.
  elseif ( $_SERVER['SERVER_NAME'] ) { $wep_domain = $_SERVER['SERVER_NAME']; } //from the SERVER
  else { $wep_domain = "error_cannot _determine" ; }

  for ($i = 1;$i <=$wep_nuemails; $i++) {
   echo '<tr id="wep_tablerow_'.$i.'">';
   $emo_email = ${'wep_email_'.$i};
   $display_name = ${'wep_display_name_'.$i};
   $verified = ${'wep_verified_'.$i};
   if ($verified == 'true') {$color = 'color:green';}
   if ($verified == 'false') {$color = 'color:#A0A0A0';}
   if ($verified == 'default') {$color = 'color:#A0A0A0';}
   echo '<td style="font-size:30px;padding-bottom:10px;"></td>';
   echo '<td><input type="text" class="withbrackets" id="wep_emailtxt_'.$i.'" style="'.$color.';" oninput="webemailprotector_email_change(\''.$i.'\')" onchange="webemailprotector_email_change(\''.$i.'\')" onkeyup="webemailprotector_email_change(\''.$i.'\')" name="wep_email_'.$i.'" value="['.$emo_email.']"></td>';
   echo '<td style="font-size:30px;padding-bottom:10px;"></td>';
   echo '<td><input type="text" id="wep_displaytxt_'.$i.'" style="'.$color.';" onkeyup="webemailprotector_displayname_change(\''.$i.'\',this.value)" name="wep_name_'.$i.'" value="'.$display_name.'"></td>';
   if ($verified == 'true') {$keycolor1 = 'color:#A0A0A0';}
   else {$keycolor1 = '';}
   echo '<td><input id="wep_register_'.$i.'" type="button" class="button getkey" value="GET KEY" style="'.$keycolor1.';" onclick="webemailprotector_register(\''.$i.'\',\''.$wep_domain.'\')"></td>';
   if ($verified == 'true') {$keycolor2 = 'background-color:green';}
   else {$keycolor2 = '';}
   echo '<td><input id="wep_verified_'.$i.'" type="button" class="button verify" value="VERIFY" style="'.$keycolor2.';" onclick="webemailprotector_verify(\''.$i.'\',\''.$wep_current_user_email.'\',\''.$wep_domain.'\')"></td>';
   echo '<td><input id="wep_delete_'.$i.'" type="button" class="button delete" value="" onclick="webemailprotector_emo_delete(\''.$i.'\')"></td>';
   echo '</tr>';
  }
 
  echo '</tbody>';
  echo '<tr><td></td><td>';  
  echo '<tr>';
  echo '<td></td><td style="text-align:center;"><green>GREEN = &check; GOOD TO GO (VERIFIED)</green></td>';
  echo '</tr>';
  echo '<tr><td></td></tr>';
  echo '<tr><td></td><td>';  
  echo '<input id="submit" class="button add another" type="button" value="+ ADD ANOTHER LINE" onclick="webemailprotector_emo_new()">';
  echo '</td></tr>';
  echo '</table>';
  //script to keep table updated on refresh properly
  echo '<script>';
  for ($i=1; $i<=$wep_nuemails ; $i++) {
  echo 'document.getElementById(\'wep_emailtxt_'.$i.'\').value = "'.${'wep_email_'.$i}.'";';
  echo 'document.getElementById(\'wep_displaytxt_'.$i.'\').value = "'.${'wep_display_name_'.$i}.'";';
  }
  echo '</script>';
  
  echo '</form>';
  //echo '<p>'.$wep_domain.'</p>';
  
  echo'<br>';
  
  
  echo '<table class="wep_bot"><tbody>';
  echo '<tr><td style="width:80px;"></td>';
  echo '<td style="width:800px;"><h2><u>More details on the STEPS:</u></h2></tr>';
  echo '<tr><td style="width:80px;"></td>';
  echo '<td><h2>STEP 1</h2>Enter each Email Address to secure into the <b>SECURED EMAIL ADDRESS</b> column of the table :<br><br>';
  echo 'Get an Email Security Key for each address with the <input type="button" class="button getkey" value="GET KEY"> button.<br>';
  echo '<br><i>The address must exist as the owner will need to confirm receipt for security. ';
  echo 'Note : you will be redirected to our site (external) and for convenience the form will be autofilled.</i><br>';
  echo '<br>Verify that the Security Key is OK with the <input type="button" class="button verify" value="VERIFY"> button.<br>';
  echo '<br><i>This also copies the reference key back to the Plugin so it is ready to use. ';
  echo 'You will be able to tell that the email address registration was successful because you get a pop-up confirmation message to say so and the email text color will change ';
  echo 'from </i><b><red>red</red></b><i> to </i><b><green>green</green></b><i>.</i>';
  echo '</td></tr>';
  echo '<tr><td style="width:80px;"></td>';
  echo '<td><h2>STEP 2</h2>Enter the associated display text into the <b>TEXT TO DISPLAY ON SCREEN</b> column : <br><br>';
  echo '<i> This is the link text that will appear in place of the ';
  echo 'email address to your user when your WordPress pages are published.';
  echo '<br><br><i>Please don\'t put email addresses in here as they will still be visible!</i>';
  echo '<br><br>The only excluded characters are \' and ".';
  echo '<br><br>Follow the Additional Notes below if you want to style this text.';
  echo '</td></tr>';
  echo '<tr><td style="width:80px;"></td>';
  echo '<td><h2>STEP 3</h2> Now everything should be ready to use.<br><br>';
  echo 'Simply place any of the secured email addresses within square brackets (as is WordPress convention for shortcodes) on your WordPress pages,';
  echo ' menus or widget text e.g. <b>[email@yourdomain.com]</b><br><br>';
  echo '<i>You do not have to place the shortcode within any "&#60;a&#62;" , "mailto" or other marked-up text, ';
  echo 'however to avoid errors the Plugin designed to replace  ';
  echo '<b>mailto:[email@yourdomain.com]</b> or <b>mailto:youremail@yourdomain.com</b> but <u>not</u> <b>youremail@yourdomain.com</b></i>'; 
  echo '</td></tr>';
  echo '</tbody></table>';
  echo '<br><br><br><br>';
  
  echo '<table class="wep_bot"><tbody>';
  
  echo '<tr><td style="width:80px;"></td>';
  echo '<td style="width:800px;"><h2><u>Additional Notes:</u></h2></tr>';
  
  echo '<tr><td style="width:80px;"></td>';
  echo '<td style="width:800px;"><br>1. You can add additional email addresses using the <input id="submit" class="button dummy" type="button" value="+ ADD ANOTHER LINE"> button.</td></tr>';
  
  echo '<tr><td style="width:80px;"></td>';
  echo '<td style="width:800px;"><br>2. You can delete any email addresses using the <input id="delete" class="button dummydelete" type="button" value=""> button.</td></tr>';
  
  echo '<tr><td style="width:80px;"></td>';
  echo '<td style="width:800px;"><br>3. As an option for advanced users you can change the style of the email address appearance using CSS. For those familiar with CSS use the class "wep_email" of ';
  echo 'an a anchor element using the selector a.wep_email {}.<br><br>';
  echo 'A template css file is provided for you to edit the style as you wish,';
  echo ' you can find it within your WordPress insallation plugin directory at : webemailprotector/css/webemailprotector_youremailstyle.css.</td></tr>';
  
  echo '<tr><td style="width:80px;"></td>';
  echo '<td style="width:800px;"><br><br>Enjoy!</td></tr>';
  
  echo '</tbody></table>';
  echo '<br><br><br><br>';

  //set up the spinner
  echo '<div id="wep_spinner">';
  echo '<img src="'.plugin_dir_url(__FILE__).'images/wep_spinner.gif"/>';
  echo '<p> please wait while we connect to the server to verify your Email Security Key . .</p>';
  echo '</div>';
  echo '<div id="wep_dullout">';
  echo '<p><br></p>'; // to force it to display
  echo '</div>';
  echo '</div>'; //of the whole thing
}

function webemailprotector_text_replace($text) {
 $newtext=$text;
 if ( get_option('wepdb_nuemails') == true){
  $wep_nuemails = get_option('wepdb_nuemails');
  for ($i = 1;$i <= $wep_nuemails; $i++) {
    $wep_email = get_option('wepdb_wep_email_'.$i);
    $wep_emo = get_option('wepdb_wep_emo_'.$i);
    $wep_display_name = get_option('wepdb_wep_display_name_'.$i);
	$wep_verified = get_option('wepdb_wep_verified_'.$i);
	if ($wep_verified == 'true'){
		// 1. replace {} brackets with [] to avoid confusions
		$newtext = str_replace('mailto:{'.$wep_email.'}','mailto:['.$wep_email.']',$newtext);
		// 2. remove any unwanted Subject/Content fields
		$thepattern='/(?<=<a\s)(.*?)(href="mailto:\['.$wep_email.'\])([?].*?")(.*?)(?=>.*<\/a>)/';
		$newtext = preg_replace($thepattern,'$1$2"$4',$newtext);
		// 3. remove target="blank" before email call
		$thepattern = '/(?<=<a\s)(.*)(target="_blank")(.*)(?=href="mailto:\['.$wep_email.'\])/';
		$newtext = preg_replace($thepattern,'$1$3',$newtext);
		// 4. remove target="blank" after email call
		$thepattern = '/(?<=href="mailto:\['.$wep_email.'\])(.*)(target="_blank")(.*)(?=>.*<\/a>)/';
		$newtext = preg_replace($thepattern,'$1$3',$newtext);
		// 5. mutate of form mailto: (does not overwrite existing class)
		$newswaptext='JavaScript:emo(\''.$wep_emo.'\')';
		$newtext = str_replace('mailto:'.$wep_email,$newswaptext,$newtext);
		// 6. mutate of form mailto:[email] - just in case added this way (does not overwrite existing class)
		$newswaptext='JavaScript:emo(\''.$wep_emo.'\')';
		$newtext = str_replace('mailto:['.$wep_email.']',$newswaptext,$newtext);	 
		// 7. mutate of form [email] (adds class to style)
		$newswaptext='<a class="wep_email" href="JavaScript:emo(\''.$wep_emo.'\')" title="'.$wep_display_name.'">'.$wep_display_name.'</a>';
		$newtext = str_replace('['.$wep_email.']',$newswaptext,$newtext);
	}
  }
 }
 return $newtext;
}
// use it before outputting the pages

// new as of 2.0.0

function buffer_start_wep() { ob_start("webemailprotector_text_replace"); }
function buffer_end_wep() { ob_end_flush(); }

add_action('wp_head', 'buffer_start_wep');
add_action('wp_footer', 'buffer_end_wep');

?>