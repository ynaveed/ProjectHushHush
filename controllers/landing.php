<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {
    
    public function index(){
        if($this->_is_logged_in()){
            redirect('index.php/welcome/','refresh');
        }else{
            $this->load->view("welcome_landing");
        }
    }
    public function signin(){
    	if($this->_is_logged_in()){
            redirect('index.php/welcome/','refresh');
        }else{
            $this->load->view("main_landing");
        }
    }
    public function signup(){
        if($this->_is_logged_in()){
            redirect('index.php/welcome/','refresh');
        }else{
            $this->load->view("signup");
        }
    }
    public function logout(){
        $this->session->sess_destroy();
        redirect('index.php/landing/');
    }
    public function guest_visit(){
    	$this->session->sess_destroy();
    	$this->load->model('User');
        $username = 'guest@phh.com';
        $password = 'guest';
        
        $user_string = $this->User->login($username,$password);
        if($user_string){
            $this->session->set_userdata('user_id',$user_string);
            redirect('index.php/welcome');   
        }else{
        	echo "you idiot";
        }

    }
    public function ajax_signup(){
        $this->load->model('User');
        if($_POST){
           $get_errors = $this->User->validate_form($_POST);
           if($get_errors['count'] > 0){
               echo json_encode($get_errors);
               return false;
           }else{
               $insert_id = $this->User->newUser($_POST);
               $this->session->set_userdata('user_id',$insert_id);
               $this->session->set_userdata('username',$_POST['first_name'].' '.$_POST['last_name']);
               $this->session->set_userdata('email',$_POST['email']);
               echo "success";
               return false;
           }
        }else{
            echo "empty_request";  
        }
    }
    public function thankyou(){
        if($this->_is_logged_in()){
            $data = array();
            $data['username'] = $this->session->userdata('username');
            $this->load->view('signup_thanks',$data);
        }else{
            //$this->load->view('signup');
            redirect('index.php/landing/signup','refresh');
        }
        
    }
    public function loginverify(){  
        if($_POST){
            $this->load->model('User');
            $username = mysql_real_escape_string($_REQUEST['username']);
            $password = mysql_real_escape_string($_REQUEST['password']);
            
            $user_string = $this->User->login($username,$password);
            if($user_string){
                $this->session->set_userdata('user_id',$user_string);
                echo "success";   
            }else{
                echo "wrong";
            }
        }
    }
    function _is_logged_in(){
        $logged = $this->session->userdata('user_id');
        if($logged){
            return true;
        }else{
            return false;
        }
    }
}