<?php $fCode= $this->uri->segment(3);?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reset Password</title>
</head>
<body>
<form action="<?php echo base_url();?>user/resetp/<?php echo $fCode;?>" method="post" id="resetpass_form" enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="0" align="center">
<?php $this->load->view('header');?>
<tr>
<td>
<h1>Reset Password!</h1>
  <table>
        <?php 
		$CI =& get_instance();
		$error = $CI->getError();
		$CI->clearError();
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
        <input type="hidden" name="fcode" id="fcode" value="<?php echo $fCode;?>" />
        <tr>
	        <td>New password:</td>
            <td>
				<?php $data = array('name'=>'newpass','id'=>'newpass','value'=>'','type'=>'password');
                echo form_input($data);?>
    		</td>
        </tr>
   		<tr>
            <td>Confirm New Password:</td>
            <td>                        
                <?php $data = array('name'=>'newconpass','id'=>'newconpass','value'=>'','type'=>'password');
                echo form_input($data);?>       
            </td>
       </tr>
        <tr>
          <td></td>
           <td>                        
               <?php $data = array('name'=>'submit','id'=>'submit','value'=>'Reset Password','type'=>'submit');
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