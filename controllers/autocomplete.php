<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller {

	function index()
	{
		$this->load->view('autocomplete');
	}

	function suggest_tags()
	{
		// Search term from jQuery
		$term = strtolower($this->input->post('tag'));
		
		// Do mysql query or what ever

		$tag_json = array("tags" => array('hum','bulbulay','momo','tumtv','humsafar','mahira','ashar','batool khala','ashar .... mera kasoor kya hai'));	
		$tags = $tag_json['tags'];
		$filtered_tags = array();
		
		foreach($tags as $tag)
		{
			if (preg_match ("/$term/i", "$tag")) 
			{
				$filtered_tags[] = $tag;
			}
		}
		// Return data
		echo json_encode($filtered_tags);
	}
}

/* End of file autocomplete.php */
/* Location: ./application/controllers/autocomplete.php */