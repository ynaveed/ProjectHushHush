<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();	 
		$this->load->helper('form');
		$this->load->library('email');
		$this->load->helper('email');
		$this->load->helper('function');
		$this->load->model('Users_Model');
		//if (!$this->session->logged_in)
		
		if (!$this->session->userdata('user_id'))
		redirect('user');
	}
	public function index()
	{
		$this->load->view('dashboard');	
	}
	public function logout()
	{
		$this->session->sess_destroy(); 
		
		redirect('user');
	}	
	public function changepass()
	{
		if($_POST)
		{
			try
			{
				$_POST = array_map("trim",$_POST);
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
				$return = $this->Users_Model->changepass($_POST);
				if($return){$this->setSuccess("Password Changed Successfully");}
			}
		}
		$this->load->view('changepass');
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