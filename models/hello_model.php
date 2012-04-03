<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hello_model extends CI_Model {

	public function img_path()
	{	
		$img_paths=array("http://".$_SERVER['SERVER_NAME']."/application/images/all_channel/bbl.jpg",		
						 "http://".$_SERVER['SERVER_NAME']."/application/images/all_channel/sndl.jpg",
						 "http://".$_SERVER['SERVER_NAME']."/application/images/all_channel/kaurm.jpg",
						 "http://".$_SERVER['SERVER_NAME']."/application/images/all_channel/hmsfr.jpg");
						 
		$jsn_img_paths	=	json_encode($img_paths);				 
		return $jsn_img_paths;
	}
	public function img_title()
	{	
		$img_titles=array("Bulbulay","Sandal","Khauda Aur Muhabbat","Humsafar");
		$jsn_img_titles	=	json_encode($img_titles);	
		return $jsn_img_titles;
	}
	public function img_desc()
	{	
		$img_descs	=array("Comedy Drama","Bonga Drama","Romantic Drama","Love Story");
		$jsn_img_desc	=	json_encode($img_descs);	
		return $jsn_img_descs;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */