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
    if($('#first_name').val() == ''){
        error_string += "<p>Please enter first name</p>";
        error_count ++;
    }
    if($('#last_name').val() == ''){
        error_string += "<p>Please enter last name</p>";
        error_count ++;
    }
    var email = $('#email').val();
    var re_email = $('#email_repeat').val();
    if(!validate_email(email)){
        error_string += "<p>Please enter a correct email address</p>";
        error_count ++;
    }
    if(email != re_email){
        error_string += "<p>Email address do not match</p>";
        error_count ++;
    }
    if($('#captcha').val() == ''){
        error_string += "<p>Please enter Captcha word</p>";
        error_count ++;
    }
    var password = $('#password').val();
    var re_password = $('#password_repeat').val();
    if(password != re_password){
        error_string += "<p>Passwords don't match</p>";
        error_count ++;
    }
    if( password == re_password && password == ''){
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
        $('#spinner_wait').show();
        ajax_signup();
    }
   
}
function ajax_signup(){
    var serialized_form = $('#sign_up_form').serialize();
    $.ajax({
            type : 'POST',
            url : "<?php echo site_url('index.php/landing/ajax_signup/'); ?>",
            data: serialized_form,
            success : function(data){
                    var error_string = "";
                    $('#spinner_wait').hide();
                    //alert(data);
                    if(data == 'success'){
                        window.location = "<?php echo site_url('index.php/landing/thankyou/');?>";
                    }else if(data == 'empty_request'){
                        
                    }else{
                        try{
                            var error_obj = jQuery.parseJSON(data);
                            if(error_obj.email = "emailexists"){
                                error_string += "<p>This email address already exist</p>";
                            }
                            if(error_obj.user = "userexists"){
                                error_string += "<p>This username already exist</p>";
                            }
                            if(error_string != ""){
                                 $('#error_div_inner').html(error_string);
                                    $('#error_div').show();
                            }
                        }catch(err){
                            $('#error_div_inner').html('<p>Sorry, we encountered a problem in the server... It will be fixed ASAP</p>');
                            $('#error_div').show();
                        }
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
function package_change(object_changed){
  for(var i=1; i<4; i++){
    $('#package_'+i).parent().parent().removeClass('package_bg');
  }
  $('#'+object_changed.id).parent().parent().addClass('package_bg');

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
            <div class=" floatright" id="topnav">
           	<a href="#">Home</a>
            <a href="#">FAQs</a>
            <a href="#">Account Settings</a>
            <a href="#">Logout</a>
            </div>
      </div>
        <!-- Header Ends -->
        
         
        
       
        
        <!-- Content Starts -->
        
        <div id="content">
         		
                <div  id="joinnow">
                	<h1>Join Now</h1>
                </div>
            
         	<!-- Inner Content -->
<div class="boxround box_signup " id="innercont">
            	
                 
  <div class="vidbx  ">        
  					 
               		<div>
                    <table border="0" cellpadding="0" cellspacing="0" style="width:950px; margin-bottom:20px; position:relative; left:-20px">
   
  <tr>
    <td align="center"> 
      <label>
      <img class="cursor_pointer" src="<?php echo base_url()?>application/css/images/icon-visa.png" width="105" height="66" alt="" /><br />

        <input class="margin_top cursor_pointer" type="radio" name="radio" id=" v " value="radio" checked="checked" />
      </label>
     </td>
    <td> </td>
    <td align="center">
    <label>
      <img class="cursor_pointer" src="<?php echo base_url()?>application/css/images/icon-paypal.png" width="105" height="66" alt="" /><br />

        <input class="margin_top cursor_pointer" type="radio" name="radio" id="p" value="radio" />
      </label>
      </td>
    <td align="center">
    <label>
      <img class="cursor_pointer" src="<?php echo base_url()?>application/css/images/icon-sms.png" width="105" height="66" alt="" /><br />

        <input class="margin_top cursor_pointer" type="radio" name="radio" id="s" value="radio" />
      </label>
      </td>
    <td align="center">
    <label>
      <img class="cursor_pointer" src="<?php echo base_url()?>application/css/images/icon-scratch.png" width="105" height="66" alt="" /><br />

        <input class="margin_top cursor_pointer" type="radio" name="radio" id="c" value="radio" />
      </label>
      </td>
      
      <td align="center">
    <label>
      <img class="cursor_pointer" src="<?php echo base_url()?>application/css/images/icon-easy.png" width="105" height="66" alt="" /><br />

        <input class="margin_top cursor_pointer" type="radio" name="radio" id="e" value="radio" />
      </label>
      </td>
  </tr>
                    </table>
		<hr />
        
        <div class="clearfix">
        
          <div class="floatleft boxround box_pcksel package_bg cursor_pointer">
             <label class="cursor_pointer">
             <h3>1 Month</h3> 
             <h1>Rs. 999/ -</h1> 
             <h3 class="color3">Save: Rs.100</h3> 
             <input id="package_1" checked="checked" name="pay" type="radio" value="" onchange="package_change(this);"/></label>
          </div>
          
          <div class="floatleft boxround box_pcksel cursor_pointer">
             <label class="cursor_pointer">
             <h3>3 Month</h3> 
             <h1>Rs. 2499/ -</h1> 
             <h3 class="color3">Save: Rs.500</h3> 
             <input id="package_2" name="pay" type="radio" value="" onchange="package_change(this);" /></label>
          </div>
          
          <div class="floatleft boxround box_pcksel cursor_pointer" style="margin-right:0">
             <label class="cursor_pointer">
             <h3>6 Month</h3> 
             <h1>Rs. 5000/ -</h1> 
             <h3 class="color3">Save: Rs.999</h3> 
             <input id="package_3" name="pay" type="radio" value="" onchange="package_change(this);" /></label>
          </div>
          
        
             
        </div>
          
          <div class="clearfix">
          
          <div class="floatleft boxround box_cnbinfo">
          <h2>Card Info</h2>
           <table border="0" cellpadding="5" style="margin:auto; width:300px; margin-top:30px">
  <tr>
    <td colspan="2">Card Number:</td>
    </tr>
  <tr>
    <td colspan="2"> 
        <input type="text" name="textfield" id="textfield" />
   </td>
    </tr>
  <tr>
    <td colspan="2">Card Holder Name:</td>
    </tr>
  <tr>
    <td colspan="2"><input type="text" name="textfield2" id="textfield2" /></td>
    </tr>
  <tr>
    <td colspan="2">Expiry Date:</td>
  </tr>
  <tr>
    <td width="145"> 
        <select name="select" id="select">
    <option value='01'>January</option>
    <option value='02'>February</option>
    <option value='03'>March</option>
    <option value='04'>April</option>
    <option value='05'>May</option>
    <option value='06'>June</option>
    <option value='07'>July</option>
    <option value='08'>August</option>
    <option value='09'>September</option>
    <option value='10'>October</option>
    <option value='11'>November</option>
    <option value='12'>December</option>
        </select>
      
    </td>
    <td width="145"> <select name="select" id="select">
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            
            
        </select></td>
  </tr>
  <tr>
    <td>Security Code:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="text" name="textfield3" id="textfield3" /></td>
    </tr>
           </table>

          </div>
          
           <div class="floatright boxround box_cnbinfo">
          <h2>Billing Info</h2>
          <table border="0" style="margin:auto; width:300px; margin-top:30px">
  <tr>
    <td colspan="2">Address Line1:</td>
    </tr>
  <tr>
    <td colspan="2"> 
        <input type="text" name="textfield" id="textfield" />
   </td>
    </tr>
  <tr>
    <td colspan="2">Address Line2:</td>
    </tr>
  <tr>
    <td colspan="2"><input type="text" name="textfield2" id="textfield2" /></td>
    </tr>
  <tr>
    <td>City:</td>
    <td>State:</td>
  </tr>
  <tr>
    <td width="145"> 
        <select name="select" id="select">
        </select>
      
    </td>
    <td width="145"> <select name="select" id="select">
            <option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
        </select></td>
  </tr>
  <tr>
    <td>Country</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><select name="select2" id="select2">
    </select></td>
    </tr>
           </table>
          </div>
          
          <div>
          <h2>Account Information</h2>
          <hr />
          <div id="error_div" class="alert alert-block alert-error fade in" style="display:none;">
              <a class="close" href="javascript: ///noo();" onclick="hide_error();">×</a>
              <h4 class="alert-heading">Oh snap! You got an error!</h4>
              <div id="error_div_inner">
              </div>
          </div>
          <table width="100" border="0" style="width:730px; margin:20px auto 0 auto; font-size:18px" id="accntinf">
  <tr>
    <td width="323">First Name:</td>
    <td width="90">&nbsp;</td>
    <td width="323">Last Name:</td>
  </tr>
  <tr>
      <form id="sign_up_form" action="" method="post" onsubmit="return false;"> 
    <td><input type="text" name="first_name" id="first_name" /></td>
    <td>&nbsp;</td>
    <td><input type="text" name="last_name" id="last_name" /></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td>&nbsp;</td>
    <td>Retype Email:</td>
  </tr>
  <tr>
    <td><input type="text" name="email" id="email" /></td>
    <td>&nbsp;</td>
    <td><input type="text" name="email_repeat" id="email_repeat" /></td>
  </tr>
  <tr>
    <td>Password</td>
    <td>&nbsp;</td>
    <td>Retype Password:</td>
  </tr>
  <tr>
    <td><input type="password" name="password" id="password" /></td>
    <td>&nbsp;</td>
    <td><input type="password" name="password_repeat" id="password_repeat" /></td>
  </tr>
  <tr>
    <td> Enter the text below into the text field on the right</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="<?php echo base_url()?>application/css/images/captcha_dummy.png"  name="captcha_image" id="captcha_image" /></td>
    <td align="center"><img src="<?php echo base_url()?>application/css/images/arrow-righ.png" width="51" height="19" alt="" /></td>
    <td><input type="text" name="captcha" id="captcha" /></td>
  </tr>
          </form>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
          </table>
		<hr />
        <div class="btngnr">
          <a href="javascript: ///noo()" onclick="form_submit();">Submit</a>
          <img id="spinner_wait" src="<?php echo base_url()?>application/css/images/spinner.gif">
          </div> 
          <p align="center">By  pressing submit you are agree with PHH terms and fair usage policy  </p>
        </div>
          
          </div>
 
			</div> 
               
            </div>
            
            
            
            
            
            
            
            
            <!-- Inner Content Ends -->
            
            
          
        
        	
         	<!-- Inner Content -->
 
            
            
        </div>
        
        <!-- Content Ends -->
       
         
    </div>
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
