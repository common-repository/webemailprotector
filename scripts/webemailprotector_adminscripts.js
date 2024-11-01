function webemailprotector_email_change($emo_nu) {
 $textfieldID='wep_emailtxt_'+$emo_nu;
 $email = document.getElementById($textfieldID).value;
 jQuery.ajax({
     type: "POST",
	 data: {action:'wep_email_change',emo_nu:$emo_nu,email:$email,security:MyAjax.security},
	 url: "admin-ajax.php",
     success: function (response) {
         if (response=="changed") {
           document.getElementById($textfieldID).style.color="red";
         }
         if (response=="unchanged") {
           //document.getElementById($textfieldID).style.color="green";
         }
		 if (response=="error") {
           //document.getElementById($textfieldID).style.color="grey";
         }
     }
 });
}

function webemailprotector_displayname_change($emo_nu,$displayname) {
 $displayname=$displayname.replace("'", "");
 $displayname=$displayname.replace('"', '');
 textfieldID='wep_displaytxt_'+$emo_nu;
 document.getElementById(textfieldID).value=$displayname;
 jQuery.ajax({
     type: "POST",
	 data: {action:'wep_displayname_change',emo_nu:$emo_nu,displayname:$displayname,security:MyAjax.security},
	 url: "admin-ajax.php",
     success: function (response) {
		 //no action
     }    
 });
}

function webemailprotector_emo_new() {
 //alert('hit');
 jQuery.ajax({
     type: "POST",
	 dataType: 'json',
	 data:{action:'wep_emo_new',security:MyAjax.security},
	 url: "admin-ajax.php",
     success: function (response) {
		 if (typeof location.origin === 'undefined')
         location.origin = location.protocol + '//' + location.host;
		 tableID='wep_table';
         var row = document.getElementById(tableID).insertRow(response.row);
		 row.id='wep_tablerow_'+response.id;
		 var openbrackettxt = row.insertCell(0);
		 openbrackettxt.outerHTML = "<td style=\"font-size:30px;padding-bottom:10px;\"></td>";
		 var emailtxt = row.insertCell(1);
		 emailtxt.innerHTML = "<input type=\"text\" id=\"wep_emailtxt_"+response.id+"\" value=\"youremail"+response.id+"@yourdomain\" style=\"color:#A0A0A0;\" onkeyup=\"webemailprotector_email_change('"+response.id+"',this.value)\">";
		 var closebrackettxt = row.insertCell(2);
		 closebrackettxt.outerHTML = "<td style=\"font-size:30px;padding-bottom:10px;\"></td>";
		 var displaytxt = row.insertCell(3);
		 displaytxt.innerHTML = "<input type=\"text\" id=\"wep_displaytxt_"+response.id+"\" value=\"your web text "+response.id+"\" style=\"color:#A0A0A0;\" oninput=\"webemailprotector_displayname_change('"+response.id+"') onchange=\"webemailprotector_displayname_change('"+response.id+"') onkeyup=\"webemailprotector_displayname_change('"+response.id+"')\">";
		 var getkey = row.insertCell(4);
	     getkey.innerHTML = "<input id=\"wep_regiser_"+response.id+"\" type=\"button\" class=\"button getkey\" value=\"GET KEY\" onclick=\"webemailprotector_register('"+response.id+"','"+location.origin+"')\">";
		 var validatekey = row.insertCell(5);
		 validatekey.innerHTML = "<input id=\"wep_verify_"+response.id+"\" type=\"button\" class=\"button verify\" value=\"VERIFY\" onclick=\"webemailprotector_verify('"+response.id+"','"+response.current_user_email+"')\">";
		 var deletekey = row.insertCell(6);
		 deletekey.innerHTML="<input id=\"wep_delete_"+response.id+"\" type=\"button\" class=\"button delete\" value=\"\" onclick=\"webemailprotector_emo_delete('"+response.id+"')\">";
		 textfieldID='wep_emailtxt_'+response.id;
     }    
 });
}

function webemailprotector_emo_delete($emo_nu) {
 if(confirm('delete entry?')){
 jQuery.ajax({
     type: "POST",
	 dataType: 'json',
	 data: {action:'wep_emo_delete',emo_nu:$emo_nu,security:MyAjax.security},
	 url: "admin-ajax.php",
     success: function (response) {
		 rowID='wep_tablerow_'+response.emo_nu;
		 document.getElementById(rowID).parentNode.removeChild(document.getElementById(rowID));
		 }    
 });
}
}

function webemailprotector_donothing(){}


//the new one v3.0.0
function webemailprotector_register($emo_nu,$url_website) {
 $email='undefined';
 textfieldID='wep_emailtxt_'+$emo_nu;
 $email=document.getElementById(textfieldID).value;
 $urlToOpen = "https://www.webemailprotector.com/cgi-bin/registerform.py?email=".concat($email,"&cms=wp","&website=",$url_website)
 window.open($urlToOpen)
}

function webemailprotector_verify($emo_nu,$current_user_email,$url_website) { //$current_user_email is the admin person
 //start spinner
 document.getElementById('wep_spinner').style.display='block';
 document.getElementById('wep_dullout').style.display='block';
 setTimeout('webemailprotector_donothing()',1000); // to make sure any update to the email address has reached the db
 email='undefined';
 textfieldID='wep_emailtxt_'+$emo_nu;
 $email=document.getElementById(textfieldID).value;
 //first get the email address from db associated with emo_nu as may have been updated since last php load
 jQuery.ajax({
     type:"GET",
	 data: {action:'wep_email_get',emo_nu:$emo_nu,security:MyAjax.security},
	 url: "admin-ajax.php",
	 //then if successful interrogate the server
     success: function (response) {
         email=response;
		 //alert(email);
         //jsonp as cross domain
         jQuery.ajax({
           url: 'https://www.webemailprotector.com/cgi-bin/verify_wp.py?callback=?',
           type: "POST",
           crossDomain: true,
           data: {'email':$email,'emo_nu':$emo_nu,'current_user_email':$current_user_email,'website':$url_website},
           dataType: "jsonp", 
           cache: false,
           jsonpCallback: "webemailprotector_emocb" });
     }    
     });	 
}

function webemailprotector_emocb(response) {
  //alert('callback');
  document.getElementById('wep_spinner').style.display='none';
  if (response.success == "true") {
   alert (response.message);
   // update the verification status for that element in db with another ajax call
   jQuery.ajax({
     type: "GET",
	 data: {action:'wep_emo_verify',code_1:response.code_1,code_2:response.code_2,code_3:response.code_3,code_4:response.code_4,
	 code_5:response.code_5,emo_nu:response.emo_nu,security:MyAjax.security},
	 dataType: 'json',
	 url: "admin-ajax.php",
     success: function (next_response) {
		//alert (next_response.emo_nu);
		textfield1ID='wep_emailtxt_'+next_response.emo_nu;
        document.getElementById(textfield1ID).style.color="green";
		textfield2ID='wep_displaytxt_'+next_response.emo_nu;
		document.getElementById(textfield2ID).style.color="green";
		textfield3ID='wep_register_'+next_response.emo_nu;
		document.getElementById(textfield3ID).style.color="#A0A0A0";
		textfield4ID='wep_verified_'+next_response.emo_nu;
		document.getElementById(textfield4ID).style.backgroundColor="green";
     }    
    });
  }
  if (response.success == "false") {
   alert (response.message);
   // update the un-verification status in the db with another ajax
   jQuery.ajax({
     type: "GET",
	 data: {action:'wep_emo_unverify',emo_nu:response.emo_nu,security:MyAjax.security},
	 dataType: 'json',
	 url: "admin-ajax.php",
     success: function (next_response) {  
        textfield1ID='wep_emailtxt_'+next_response.emo_nu;
        document.getElementById(textfield1ID).style.color=null;
		textfield2ID='wep_displaytxt_'+next_response.emo_nu;
		document.getElementById(textfield2ID).style.color=null;
		textfield3ID='wep_register_'+next_response.emo_nu;
		document.getElementById(textfield3ID).style.color=null;
		textfield4ID='wep_verified_'+next_response.emo_nu;
		document.getElementById(textfield4ID).style.backgroundColor=null;
	 }
	});
  }
document.getElementById('wep_dullout').style.display='none';
}

function webemailprotector_emo_init($current_user_email,$wep_ver,$wep_reason) {
  jQuery.ajax({
    url: 'https://www.webemailprotector.com/cgi-bin/emo_init_wp.py', ////!!!!!
    type: "POST",
    crossDomain: true,
    data: {'adminemail':$current_user_email,'wep_ver':$wep_ver,'wep_reason':$wep_reason},
    dataType: "jsonp", 
    cache: false });
}    

function webemailprotector_emo_act($current_user_email) {
  jQuery.ajax({
    url: 'https://www.webemailprotector.com/cgi-bin/emo_act_wp.py', ////!!!!!
    type: "POST",
    crossDomain: true,
    data: {'current_user_email':$current_user_email},
    dataType: "jsonp", 
    cache: false });
}