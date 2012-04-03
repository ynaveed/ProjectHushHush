<?php
class Users_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function addUser($data) {
		$email 		= mysql_real_escape_string($data['email']);
		$password 	= mysql_real_escape_string($data['password']);
		$username 	= mysql_real_escape_string($data['username']);
		$userType 	="user";
		$checkAdmin = $this->session->userdata('user_type');
		if( $checkAdmin =="root" || $checkAdmin=="admin" )
		{
			$userType 	= mysql_real_escape_string($data['userType']);
		}
		
		
		
		//	if(isset($userType))
		//	{
		//		if($userType)
		//		{
					//$usertype 	= mysql_real_escape_string($data['userType']);
					$this->db->query("INSERT INTO users SET username='{$username}',type='{$userType}', password='".md5($password)."', email='{$email}',addedDate=NOW(),modifiedDate=NOW()");		
	//			}
	//		}
	//	else
	//	{
	//	$this->db->query("INSERT INTO users SET username='{$username}', password='".md5($password)."', email='{$email}',addedDate=NOW(),modifiedDate=NOW()");
		//}
		if( $this->db->insert_id() > 0 ) { 
			return $this->db->insert_id();
		}
	}
	function  API_verifyUser($data)
	{
		$username = $data['username'];
		if($this->db->query( "SELECT * FROM users WHERE username='{$username}' LIMIT 1")){
			$this->db->query( "UPDATE users SET verified = 'Yes' WHERE username='{$username}' LIMIT 1");	
			if( $this->db->affected_rows() > 0){
				return 1;
			}
			else
			return 0;
		}
		else
		return 0;
	}
	function API_authenticate($data) {
		$username = mysql_real_escape_string($data['username']);
		$pass 	  = md5(mysql_real_escape_string($data['password']));
		$query = $this->db->query("SELECT * FROM users WHERE username='{$username}' AND password='{$pass}'");
		if($query)
		{
			$results=$query->result();
			
			//$this->session->set_userdata('user_id',$results[0]->);
			
			if($results[0]->verified == "No")
				return -1;
			elseif($results[0]->verified == "Yes")	
			{
				$this->session->set_userdata('user_type', $results[0]->type);
				return 1;		
			}
		}
		else
			return 0;
	}
	function changepass($data)
	{
		$password = md5($data['newpass']);
		$username =  $this->session->userdata('user_id');
		$this->db->query("UPDATE users SET password='{$password}' WHERE username='{$username}' LIMIT 1");
		if($this->db->affected_rows() > 0){return 1;}
	}
	function forgotpass($data)
	{
		$userval = mysql_real_escape_string($data['userval']);
		$query = $this->db->query("SELECT username,email FROM users WHERE username='{$userval}' OR email='{$userval}'");
		if($query->num_rows > 0)
		{
			$results=$query->result();
			if($results[0]->email != "")
			{
				$username = $results[0]->username;
				$forgotKey = md5($username.time());
				$this->db->query("UPDATE users SET forgotKey='{$forgotKey}' WHERE username='{$username}' LIMIT 1");
				if($this->db->affected_rows() > 0){return "SUC##".$forgotKey."##".$username."##".$results[0]->email;}
			}
		}
		else
		{
			return "ERR##Wrong Username/Email";
		}
	}
	function resetpass($data)
	{
		$fcode = mysql_real_escape_string($data['fcode']);
		$newpass = mysql_real_escape_string($data['newpass']);
		$password = md5($newpass);
		$query = $this->db->query("SELECT uId FROM users WHERE forgotKey='{$fcode}' LIMIT 1");
		if($query->num_rows > 0)
		{
			$results=$query->result();
			if($results[0]->uId != "")
			{
			  $this->db->query("UPDATE users SET forgotKey=NULL,password='{$password}' WHERE forgotKey='{$fcode}' LIMIT 1");
			  if($this->db->affected_rows()>0){return "SUC##";}
			}
		}
		else
		{
			return "ERR##Invalid email link";
		}
	}
	function API_getUserDetails($data) {
		$email 	= mysql_real_escape_string(@$data['email']);
		$pro_id	= mysql_real_escape_string(@$data['protimenumber']);
		if( !empty($email) ) {
			return $this->db->query( "SELECT * FROM users WHERE email='{$email}'" );
		} else {
			return $this->db->query( "SELECT * FROM users WHERE protime_id='{$pro_id}'" );
		}
	}
	
	function API_updateServerKey($data) {
		$serverKey	= mysql_real_escape_string($data['serverkey']);
		$proNumber 	= mysql_real_escape_string($data['protimenumber']);
		$this->db->query( "UPDATE users SET server_key='{$serverKey}' WHERE protime_id='{$proNumber}'" );
		if( $this->db->affected_rows() > 0 ) { return 1; }
		return 0;
	}
	
	function updateImage($bool, $userId = NULL) {
		if($userId == NULL) { $userId = $this->getId(); }
		
		$this->db->query("UPDATE users SET image_uploaded='{$bool}' WHERE id='{$userId}'");
		if( $this->db->affected_rows() > 0 ) { $this->setImage(1);return 1; }
		return 0;
	}
	
	function updateVerification($data, $email = NULL) {
		if ( $email == NULL ) { $email = $this->getEmail(); }
		$this->db->query("UPDATE users SET verified='{$data}' WHERE email='{$email}'");
		if( $this->db->affected_rows() > 0 ) { return 1; }
		return 0;
	}
	
	
	function getAllAdmins(){
		return $this->db->query("SELECT * FROM users WHERE type='root' or type='admin'");
		}
	
	function getVerification($data) {
		return $this->db->query("SELECT * FROM users WHERE verified='{$data}'");
	}
	
	function generateProId() {
		$m = microtime();
		$k = substr($m, 2, 8);
		$j = substr($m, -8);
		return substr( ($k + $j), 0, 8);
	}
	function checkUser($data)
	{
		$usertype = $data['type'];
		$userValue = $data['userValue'];
		if($usertype == "")$usertype="username";
		$q = $this->db->query("SELECT uId FROM users WHERE {$usertype} = '{$userValue}'");
		if($q->num_rows > 0){return 1;}
		return 0;
	}
	function fullTextSearch($param) {
		
		$results= $this->db->query("SELECT * FROM users WHERE MATCH (first_name,last_name,email,country,city,address,state)
    	AGAINST ('*".$param."*' IN BOOLEAN MODE);");
		
		return $results;
	}
}