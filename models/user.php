<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author y-nav
 */
class User extends CI_Model{
    function getUserDetails($user_id){
        $query = $this->db->query('select * from users where id ="'.$user_id.'" limit 1');
        if($query){
            return $query->result();
        }
        else{
            return false;
        }
    }
   function login($email, $password){
        $query = $this->db->query('select id,username,password from users where email ="'.$email.'" and password ="'.md5($password).'" limit 1');
        if($query -> num_rows() == 1){
            $row = $query->row();
            return $row->id;
        }
        else{
            return false;
        }
    }
    function newUser($data){
                $data['username'] = $data['first_name']." ".$data['last_name'];
                $email 		= mysql_real_escape_string($data['email']);
		$password 	= mysql_real_escape_string($data['password']);
		$username 	= mysql_real_escape_string($data['username']);
		$this->db->query("INSERT INTO users SET username='{$username}', password='".md5($password)."', email='{$email}',addedDate=NOW(),modifiedDate=NOW()");		
		if( $this->db->insert_id() > 0 ) { 
			return $this->db->insert_id();
		}
    }
    function validate_form($data){
        $errors = array();
        $errors['count'] = 0;
        if($data){
            $data['username'] = $data['first_name']." ".$data['last_name'];
            $data['username'] = mysql_real_escape_string($data['username']);
            if($this->user_exists($data['username'])){
                $errors['count'] = 1;
                $errors['user'] = "userexists";
            }
            $data['email'] = mysql_real_escape_string($data['email']);
            if($this->email_exists($data['email'])){
                $errors['count'] = 1;
                $errors['email'] = "emailexists";
            }
        }
        return $errors;
    }
    function user_exists($username){
        $query = $this->db->query('select username from users where username ="'.$username.'" limit 1');
        if($query -> num_rows() == 1){
            return true;
        }
        else{
            return false;
        }
    }
    function email_exists($email){
        $this->load->helper('email');
        if(!valid_email($email)){
            return false;
        }
        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('email ='."'".$email."'");
        $this->db->limit(1);
        $query = $this->db->query('select email from users where email = "'.$email.'" limit 1');
        if($query -> num_rows() == 1){
            return true;
        }
        else{
            return false;
        }
    }
}

?>
