<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Forgot Password</title>
</head>
<body>
<form action="<?php echo base_url();?>user/forgot" method="post" id="forgotpass_form" enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="0" align="center">
<?php $this->load->view('header');?>
<tr>
<td>
<h1>Forgot Password!</h1>
  <table>
        <?php 
		$CI =& get_instance();
		$error = $CI->getError();
		$CI->clearError();
		$msg="";
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
            <td>Username Or Email:</td>
            <td>                        
                <?php $data = array('name'=>'userval','id'=>'userval','value'=>'','type'=>'text');
                echo form_input($data);?>       
            </td>
       </tr>
        <tr>
          <td></td>
           <td>                        
               <?php $data = array('name'=>'submit','id'=>'submit','value'=>'Send Password','type'=>'submit');
               echo form_input($data);?>       
          </td>
       </tr>
   </table>
</td>
</tr>
</table>
</form>
</body>
</html>