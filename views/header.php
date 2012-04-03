<!-- Jquery Tab files-->
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/js/tab_jquery/themes/base/jquery.ui.all.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/js/tab_jquery/archive_info/demos.css" />
<script src="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/js/tab_jquery/jquery-1.7.1.js"></script>
<script src="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/js/tab_jquery/ui/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/js/tab_jquery/ui/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/js/tab_jquery/ui/jquery.ui.tabs.js"></script>
<!-- Jquery Tab files-->

<!-- usr management-->
<?php 
$CI =& get_instance(); 
$curUser = $CI->session->userdata('user_id');
$userType = $CI->session->userdata('user_type');
?>
<link type="text/css" rel="stylesheet" href="http://<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/css/css.css" />
<?php if($curUser != ""){
?>
<tr><td>
Welcome <strong><?php echo $curUser;?></strong>
<br/><br />
<a href="<?php echo base_url();?>dashboard/changepass">Change Password</a> | 
<a href="<?php echo base_url();?>dashboard">Dashboard</a>  | 

<?php
	if($userType=="root" || $userType=="admin")
	{
		?>
		<a href="<?php echo base_url();?>user/add">Add new User</a> | 
		
 <?php	
	}
?>

<a href="<?php echo base_url();?>dashboard/logout">Logout</a> 
<?php } else{?>
<a href="<?php echo base_url();?>user/add">Register</a> | 
<a href="<?php echo base_url();?>user">Login</a>  | 
<a href="<?php echo base_url();?>user/forgot">Forgot Passwrod</a> 
<?php }?>
<br /><br /><br />
</td></tr>
<!-- usr management-->




<!-- Original design File-->
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>/application/css/style.css" />

<!-- Original design File-->