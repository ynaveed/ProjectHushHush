
<?php 
$userType = $this->session->userdata('user_type');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>User Registration</title>
</head>
<body>
<form action="<?php echo base_url();?>user/add" method="post" id="register_form" enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="0" align="center">
<?php $this->load->view('header');?>
<tr>
<td>
<h1>User Registration!</h1>
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
	        <td>Username:</td>
            <td>
				<?php $data = array('name'=>'username','id'=>'username','value'=>($success == "" ? set_value('username') : ""),'type'=>'text');
                echo form_input($data);?>
    		</td>
        </tr>
   		<tr>
            <td>Password:</td>
            <td>                        
                <?php $data = array('name'=>'password','id'=>'password','value'=>'','type'=>'password');
                echo form_input($data);?>       
            </td>
       </tr>
       <tr>
          <td>Email:</td>
           <td>                        
               <?php $data = array('name'=>'email','id'=>'email','value'=>($success == "" ? set_value('email') : ""),'type'=>'text');
               echo form_input($data);?>       
          </td>
       </tr>
       
       
       <?php if(isset($userType))
	   {
		   if($userType=="root"|| $userType=="admin")
		   {
			 ?>  
			 
       <tr>
          <td>User Type:</td>
           <td>                        
               <?php 
			 		$options = array(
                  'admin'  => 'Admin',
                  'user'    => 'Normal User',
                );
			echo form_dropdown('userType', $options, 'user');  
			   ?>       
          </td>
       </tr>
       <?php
         }
		   }
		   ?>
       
       
       
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
</table>
</form>
</body>
</html>