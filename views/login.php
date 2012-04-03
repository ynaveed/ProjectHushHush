<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <title>User Login</title>
</head>
<body>
<form action="<?php echo base_url();?>user/authenticate" method="post" id="login_form" enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="" align="center">
<?php $this->load->view('header');?>
<tr>
<td>
<h1>User Signin!</h1>
  <table>
        <?php 
		$CI =& get_instance();
		$error = $CI->getError();
		$CI->clearError();
		$msg ="";
		$success="";
		if($error != "")
		$msg = "<font color='#FF0000'>".$error."</font>";
		else
		{	
			$success = $CI->getSuccess();
			if($success != "")
			$msg = "<font color='#33CC33'>".$success."</font>";
		}
		if($msg != ""){?>
          <tr><td colspan="2"><?php echo $msg;?></td></tr>       
        <?php }?>
        <tr>
	        <td><label>Username:</label></td>
            <td>
				<?php $data = array('name'=>'username','id'=>'username','value'=>($success == "" ? set_value('username') : ""),'type'=>'text');
                echo form_input($data);?>
    		</td>
        </tr>
   		<tr>
            <td><label>Password:</label></td>
            <td>                        
                <?php $data = array('name'=>'password','id'=>'password','value'=>'','type'=>'password');
                echo form_input($data);?>       
            </td>
       </tr>
        <tr>
          <td></td>
           <td>                        
               <?php $data = array('name'=>'submit','id'=>'submit','value'=>'Submit','type'=>'submit');
               echo form_input($data);?>       
          </td>
       </tr>
   </table>
</td>
</tr>
</table></form>
</body>
</html>