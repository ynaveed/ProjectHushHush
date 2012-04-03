<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Up!</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/style_signup.css" type="text/css"  />
<script src="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>application/js/tab_jquery/jquery-1.7.1.js"></script>
<script>
function form_submit(){
    var error_string = '';
    var error_count = 0;
    var email = $('#username').val();
    if(!validate_email(email)){
        error_string += "<p>Please enter a correct email address</p>";
        error_count ++;
    }
    var password = $('#password').val();
    if( password == ''){
        error_string += "<p>Please enter a password</p>";
        error_count ++;
    }
    if(error_count > 0){
        $('#error_div_inner').html(error_string);
        $('#error_div').show();
    }
    if(error_count == 0){
        $('#error_div').hide(function(){
             $('#error_div_inner').html('');
        });
        $('#spinner_wait_signin').show();
        ajax_signup();
    }
   
}
function ajax_signup(){
    var serialized_form = $('#signin_form').serialize();
    $.ajax({
            type : 'POST',
            url : "<?php echo site_url('index.php/landing/loginverify'); ?>",
            data: serialized_form,
            success : function(data){
                    $('#spinner_wait_signin').hide();
                    //alert(data);
                    if(data == 'success'){
                        window.location = "<?php echo site_url('index.php/welcome/');?>";
                    }else if(data == 'wrong'){
                            $('#error_div_inner').html('<p>Either email address or password is wrong</p>');
                            $('#error_div').show();
                    }

            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert("error: "+errorThrown);
            }
    });
}
function validate_email(email){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(reg.test(email) == false) {
        return false;
    }
    return true;
}
function hide_error(){
    $('#error_div').hide('900',function(){
        $('#error_div_inner').html('');
    });
}
</script>
</head>

<body>
	<div class="wrap">
        <!-- Header Starts -->
    <div class="clearfix" id="header">
        	<div class="floatleft">
            <a href="#"><img src="<?php echo base_url()?>application/css/images/logo.png" width="225" height="54" alt="" /></a>
            </div>
            <div class=" floatright" id="topnav" style="">
           	<a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Help</a>
           
            </div>
      </div>
        <!-- Header Ends -->
        
         
        
       
        
        <!-- Content Starts -->
        
        <div id="content">
         		
            
         	<!-- Inner Content -->
<div class="boxround box_signup" style="width:50%;margin: auto;margin-top:50px;margin-bottom:100px;padding:50px;padding-right:0;" id="innercont">
            	
    <div style="">
        <div class="field_names">
            <form id="signin_form" method="post" action="" onsubmit="return false;">
            <p style="font-size: 18px;padding-bottom: 24px;">Email: <br><input type="text" style="" name="username" id="username" /></p>
            <p style="font-size: 18px;margin-top:8px;">Password: <input style="margin-left: 3px;" type="password" name="password" id="password" /></p>
            <hr style="margin-top: 26px;width: 446px;margin-right: 45px;">
            <div class="btngnr_signup">
               <img id="spinner_wait_signin" src="<?php echo base_url()?>application/css/images/spinner.gif">
               <a href="javascript://noo" onclick="form_submit();">Sign In</a>
            </div>
            <p style="margin-left: 110px;">Don't have an account? <a href="<?php echo base_url();?>index.php/landing/signup/">Sign Up!</a></p>
        </div>
     
        <div class="field_input">
            
           
        </div>
    </div>
       <div id="error_div" class="alert alert-block alert-error fade in" style="float:left;margin-left: 4px; display: none;">
              <a class="close" href="javascript: ///noo();" onclick="hide_error();">×</a>
              <h4 class="alert-heading">Oh snap! You got an error!</h4>
              <div id="error_div_inner">
              </div>
          </div>
            
        </div>
        
        <!-- Content Ends -->
       
         
    </div>
     <!-- Footer Starts >
     <div class=" footer" style="float:left;width:100%;" >
    	 <div class="footercloud">
         	 <div class="wrap clearfix">
             	 <div class="floatleft ftlogo">
                 	<a href="#"><img src="<?php// echo base_url()?>application/css/images/footerlogo.gif" width="230" height="50" alt="" /></a>
                 </div>
                 <div class="floatleft">
                 <h4>About PHH</h4>
                 <ul>
                 	<li><a href="#">About</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Team</a></li>
                    <li><a href="#">Press</a></li>
                 </ul>
                 </div>
                 <div class="floatleft">
                 <h4>Legal</h4>
                 <ul>
                 	<li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy</a></li>
                    
                 </ul>
                 </div>
                 <div class="floatleft">
                 <h4>Partner Page</h4>
                 <ul>
                 	<li><a href="#">ARY</a></li>
                    <li><a href="#">GEO</a></li>
                    <li><a href="#">HUM</a></li>
                    <li><a href="#">ATV</a></li>
                    <li><a href="#">PT</a></li>
                 </ul>
                 </div>
               <div class="floatleft">
                 <h4>Follow Us</h4>
                 <ul>
                 	<li><a href="#"><img src="<?php //echo base_url()?>application/css/images/icon-fb.png" width="36" height="34" alt="" /></a></li>
                    <li><a href="#"><img src="<?php //echo base_url()?>application/css/images/icon-tw.png" width="36" height="34" alt="" /></a></li>
                    <li><a href="#"><img src="<?php //echo base_url()?>application/css/images/icon-rss.png" width="36" height="34" alt="" /></a></li>
                     
                 </ul>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer Ends-->

     </div>
              <!-- Footer Starts -->
     <div class=" footer" id="footerarea" style="clear:both;">
    	 <div class="footercloud">
         	 <div class="wrap clearfix">
             	 <div class="floatleft ftlogo">
                 	<a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/footerlogo.gif" width="230" height="50" alt="" /></a>
                 </div>
                 <div class="floatleft">
                 <h4>About PHH</h4>
                 <ul>
                 	<li><a href="#">About</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Team</a></li>
                    <li><a href="#">Press</a></li>
                 </ul>
                 </div>
                 <div class="floatleft">
                 <h4>Legal</h4>
                 <ul>
                 	<li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy</a></li>
                    
                 </ul>
                 </div>
                 <div class="floatleft">
                 <h4>Partner Page</h4>
                 <ul>
                 	<li><a href="#">ARY</a></li>
                    <li><a href="#">GEO</a></li>
                    <li><a href="#">HUM</a></li>
                    <li><a href="#">ATV</a></li>
                    <li><a href="#">PT</a></li>
                 </ul>
                 </div>
               <div class="floatleft">
                 <h4>Follow Us</h4>
                 <ul>
                 	<li><a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-fb.png" width="36" height="34" alt="" /></a></li>
                    <li><a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-tw.png" width="36" height="34" alt="" /></a></li>
                    <li><a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-rss.png" width="36" height="34" alt="" /></a></li>
                     
                 </ul>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer Ends-->
</body>
</html>
