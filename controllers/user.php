<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

	public $username = '';
	public $email_address 	 = '';
	public $success =0;
	public $error =0;
	
	function __construct() {
		parent::__construct();	 
		$this->load->helper('form');
		$this->load->library('email');
		$this->load->helper('email');
		$this->load->helper('function');
		$this->load->model('Users_Model');
	}
	public function index()
	{
		
		//$this->session->set_userdata('user_id'
		//$this->session->userdata('session_id');
		//$this->session->logged_in
		
		echo $this->session->userdata('user_id');
		//exit;
		
		if ($this->session->userdata('user_id'))
		{
			redirect('dashboard');
		}
		else
		{
			///////this code is only for testing 
			
//			$this->session->set_userdata('user_id', 'Rashid');
	//		redirect('dashboard');
			///////////////////////////
			
			$this->load->view('login');	
		}
	}	
	function add()
	{
		if($_POST)
		{
			$this->username      = $_POST['username'];
			$this->email_address = $_POST['email'];	
			try
			{
				$_POST = array_map("trim",$_POST);
				if($_POST['username'] == ""){ throw new Exception ('Please provide username');}
				$regex_username = '/^[a-zA-Z0-9]{6,15}$/';
				if (!preg_match($regex_username,$_POST['username'])) { throw new Exception ('Username must be alpha-numeric, between 6-15 characters');}
				if($_POST['password'] == ""){ throw new Exception ('Please provide password');}
				if( strlen($_POST['password']) < 6 ) { throw new Exception ('Password cannot be less than six characters');}
				if( !valid_email($_POST['email']) ) { throw new Exception ('Invalid email address'); }
				$userExist = $this->Users_Model->checkUser(array("userValue"=>$_POST['username']));
				if($userExist){throw new Exception ('Username Already Exists. Please choose another');}
				$emailExist = $this->Users_Model->checkUser(array("userValue"=>$_POST['email'],"type"=>"email"));
				if($emailExist){throw new Exception ('Email Already Exists');}
			} 
			catch (Exception $ex) 
			{
				$exception = $ex->getMessage();
				$this->setError($exception);
			}
			if($this->getError() == ""){
				
				$return = $this->Users_Model->addUser($_POST);
				
				if($return)
				{	
					$this->sendVerificationEmail();
					$this->setSuccess("User Created Successfully. An email has been sent to you containing account confirmation link");
				}
			}
		}
		$this->load->view('register');
	}
	function short_reg()
	{
		$this->load->view('short-reg');
	}
	
	
		
	
	function sendVerificationEmail(){
		$name = $this->username;
		$hash = bin2hex(encoded($name,ENCODED_KEY));
		$link = base_url().'user/email_verification/'.$hash;
		$this->email->clear();
		$this->email->set_newline("\r\n");
		$this->email->to($this->email_address);
		$this->email->from('mail.mindblazetech@googlemail.com', 'phh');
		$this->email->subject('phh Verfication Link');
		$this->email->message('Hi '.$name.', <br /><br />Here is your phh email verification link: <br /><br /><a href="' . $link . '" target="_blank">'.$link.'</a><br /><br />');
		$this->email->send();
	}
	
	function sendVerificationEmailOnSongUpload()
	{
		$name = $this->username;
		//$hash = bin2hex(encoded($name,ENCODED_KEY));
		//$link = base_url().'user/email_verification/'.$hash;
		$this->email->clear();
		$this->email->set_newline("\r\n");
		$this->email->to($this->email_address);
		$this->email->from('mail.mindblazetech@googlemail.com', 'phh');
		$this->email->subject('phh Verfication Link');
		$this->email->message('Hi '.$name.', <br /><br />You have uploaded song successfully!!!<br /><br />');
		$this->email->send();
	}

function testemail()
{
	$this->sendVerificationEmailOnSongUploadToAdmin();
	}
	function sendVerificationEmailOnSongUploadToAdmin()
	{
		
		//$admins=$this->Users_Model->getAllAdmins();
		//$hash = bin2hex(encoded($name,ENCODED_KEY));
		//$link = base_url().'user/email_verification/'.$hash;
		$this->email->clear();
		$this->email->set_newline("\r\n");
		$this->email->to('haxanstudios@gmail.com');	//$this->email->to('rashid.ali000@gmail.com');
		$this->email->from('mail.mindblazetech@googlemail.com', 'phh');
		$this->email->subject('phh Verfication Link');
		$this->email->message('Hi Hassan, <br /><br />Here is your phh email verification link: <br /><br /><br /><br />');
		//$this->email->message('Hi , <br /><br />A new song is uploaded in library!!!<br /><br /><br /><br />');
		$this->email->send();
		print_r($this->email);
		/*foreach($admins->result_array() as $row)
		{
			
			if($row['type']=='root')
			$this->email->to($row['email']);
			else
			$this->email->cc($row['email']); 
		}*/
		
	}
	
	function sendForgotEmail($arr){
		$hash = $arr['forgotKey'];
		$username = $arr['username'];	
		$email = $arr['email'];
		$link =  base_url().'user/resetp/'.$hash;
		$this->email->clear();
		$this->email->to($email);
		$this->email->from('ma.mindblaze@gmail.com','phh');
		$this->email->subject('Reset Password');
		$this->email->message('Hi '.$username.', <br/>Please click <a href="'.$link.'" target="_blank">Here</a> to Reset Password: ');
		$this->email->send();
	}
	function email_verification($hash)
	{
		$username = encoded(decoded($hash),ENCODED_KEY);
		if($username != "")
		{
			$return = $this->Users_Model->API_verifyUser(array("username"=>$username));
			if($return)
				$this->setSuccess("User Verified Successfully. Please <a href='".base_url()."/user'>Login</a> to continue.");
			else
				$this->setError("Invalid User!");	
		}
		else
		$this->setError("Invalid Email Link!");
		$this->load->view('email_verify');		
	}
	
	function authenticate()
	{
		if($_POST)
		{
			try
			{
				$_POST = array_map("trim",$_POST);
				if($_POST['username'] == ""){ throw new Exception ('Please provide username');}
				if($_POST['password'] == ""){ throw new Exception ('Please provide password');}
			} 
			catch (Exception $ex)
			{
				$exception = $ex->getMessage();
				$this->setError($exception);
			}
			if($this->getError() == ""){
				$return = $this->Users_Model->API_authenticate($_POST);
				if($return == -1)
				$this->setError("User not verified");
				if($return == 0)
				$this->setError("Invalid username/password");
				elseif($return == 1){
					$this->session->set_userdata('user_id', $_POST['username']);
					redirect('dashboard');
				}
			}
		}
		$this->load->view('login');		
	}
	function forgot()
	{
		if($_POST)
		{
			try
			{
				$_POST = array_map("trim",$_POST);
				if($_POST['userval'] == ""){ throw new Exception ('Please provide username/email');}
			} 
			catch (Exception $ex)
			{
				$exception = $ex->getMessage();
				$this->setError($exception);
			}
			if($this->getError() == ""){
				$return = $this->Users_Model->forgotpass($_POST);
				$return = explode("##",$return);
				if($return[0] == "ERR")
				$this->setError($return[1]);
				elseif($return[0] == "SUC")
				{
					$forgotKey =  $return[1];
					$username  =  $return[2];
					$email 	   =  $return[3];
					$this->sendForgotEmail(array("forgotKey"=>$forgotKey,"username"=>$username,"email"=>$email));
					$this->setSuccess("Password email sent successfully");
				}
			}
		}
		$this->load->view('forgotpass');		
	}
	function resetp($code)
	{
		if($_POST)
		{
			try
			{
				$_POST = array_map("trim",$_POST);
				if($_POST['fcode'] == "" || strlen($_POST['fcode']) != 32 ) { throw new Exception ('"Invalid email link"');}
				if($_POST['newpass'] == ""){ throw new Exception ('Please provide new password');}
				if($_POST['newconpass'] == ""){ throw new Exception ('Please provide confirm new password');}
				if( strlen($_POST['newpass']) < 6 ) { throw new Exception ('Password cannot be less than six characters');}
				if( $_POST['newpass'] !=  $_POST['newconpass']) { throw new Exception ('Password didnt match');}
			} 
			catch (Exception $ex)
			{
				$exception = $ex->getMessage();
				$this->setError($exception);
			}
			if($this->getError() == ""){
				$return = $this->Users_Model->resetpass($_POST);
				$return = explode("##",$return);
				if($return[0] == "ERR")
				$this->setError($return[1]);
				elseif($return[0] == "SUC")
				{
					$this->setSuccess("Password has been reset successfully");
				}
			}
		}
		$this->load->view('resetpass');		
	}
	function getError() {
		if($this->error == 1) {
			return $this->error_var;
		}return;
	}	
	function setError($errorString) {
		$this->error_var = $errorString;
		$this->error = 1;
	}
	function clearError() {
		$this->error_var = '';
		$this->error = 0;
	}
	function getSuccess() {
		if($this->success == 1) {
			return $this->success_var;
		}return;
	}
	function setSuccess($successString) {
		$this->success_var = $successString;
		$this->success = 1;
	}
	function clearSuccess() {
		$this->success_var = '';
		$this->success = 0;
	}
}