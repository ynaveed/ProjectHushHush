<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Email Verification</title>
</head>
<body>
<h1>Email Verification!</h1>
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
     <p><?php echo $msg;?></p>       
    <?php }?>
</body>
</html>