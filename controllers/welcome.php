<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
         parent::__construct();
         if(!$this->_is_logged_in()){
         	echo "no_login";
         	exit();
         }
        // $this->load->helper('function');
         //$user_agent = mobile_device_detect();
       //  echo $user_agent;
        //echo "hello";
    }

        function _is_logged_in(){
            $logged = $this->session->userdata('user_id');
            if($logged){
                return true;
            }else{
                return false;
            }
        }
	public function index(){
            if(!$this->_is_logged_in()){
                redirect('index.php/landing/');
            }else{

                     $this->load->model('Video_Model');
			$this->load->model('User');
                     $lower_user = $this->User->getUserDetails($this->session->userdata('user_id'));
                     $data['username'] = ucwords($lower_user[0]->username);
			$data['channels'] = $this->Video_Model->get_all_channels();
			$data['this_week'] = $this->Video_Model->populate_week();
			$data['day_dates'] = $this->Video_Model->weekly_dates();
                     $data['day_at_server'] = $this->Video_Model->day_at_server();
			$data['ordered_dates'] = $this->Video_Model->ordered_dates();
                     $data['all_dramas'] = $this->Video_Model->get_all_dramas();
                     $data['thumbnail'] = base_url().'application/images/thumb-bg.jpg';
                     $data['logo'] = base_url().'application/images/logo-thumb.jpg';
			$this->load->view("welcome_view",$data);
            }
                
        }
	public function get_all_episodes(){
              $this->load->model('Video_Model');
              $drama_id = mysql_real_escape_string($_POST['drama_id']);
              if($drama_id){
                     $episodes = $this->Video_Model->get_drama_episodes($drama_id);
                     echo $episodes;
              }
       }
	public function get_videoplayer(){
              $this->load->model('Video_Model');
              $video = $_POST['video_url'];
              if($video){
              	$device = $this->Video_Model->mobile_device_detect();
                if($device[1] == 'Apple iPad'){
                	$video .= '&flavor=ipad';
                }else if($device[1] == 'Apple' || $device[1] == 'Android'){
                	$video .= '&flavor=iphone';
                }

                $video_html = $this->Video_Model->get_video_player($video);
                echo $video_html;
              }              
       }
	
	public function show_tab(){
		$this->load->view('show_tab$s');
	}
	
	public function count_watch_video() {
		if($this->session->userdate('user_id') == '88'){
			echo "success";
			return false;
		}
		$this->load->model('Video_Model');
                $video_id = mysql_real_escape_string($_REQUEST['video_id']);
                $user_id = $this->session->userdata('user_id');

                if(!empty($user_id) && !empty($video_id)){
                    $returned_value = $this->Video_Model->save_recently_watched($video_id,$user_id);
                    if($returned_value){
                        echo "success";
                    }else{
                        echo "wrong";
                    }
                }else{
                    echo "bad_request";
                }
	}
	public function save_favourites(){
		if($this->session->userdate('user_id') == '88'){
			echo "success";
			return false;
		}
		$this->load->model('Video_Model');
		$video_id = mysql_real_escape_string($_REQUEST['video_id']);
        $user_id = $this->session->userdata('user_id');

       if(!empty($user_id) && !empty($video_id)){
            $returned_value = $this->Video_Model->save_favourites($video_id,$user_id);
            if($returned_value){
                echo "success";
            }else{
                echo "already_saved";
            }
        }else{
            echo "bad_request";
        }
	}
	
	public function get_favourites(){
		if($this->session->userdate('user_id') == '88'){
			echo "no_data";
			return false;
		}
		$this->load->model('Video_Model');
		$all_fav =  $this->Video_Model->get_favourites();
		if($all_fav){
			echo $all_fav;
		}else{
			echo 'no_data';
		}
	}
	public function suggest_tags(){
		// Search term from jQuery
		$term = strtolower($this->input->post('tag'));
		$this->load->model('Video_Model');

                 $tags =  $this->Video_Model->get_search_keywords($term);
                 echo $tags;
                 return false;
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
	
	
	public function get_recently_watched(){
			if($this->session->userdate('user_id') == '88'){
				echo "no_data";
				return false;
			}
              $this->load->model('Video_Model');	  
              $recently_watched =	$this->Video_Model->get_recently_watched();
              if($recently_watched){
                     echo $recently_watched;
              }else{
                     echo "no_data";
              }	
	}
	
        public function popular_clips(){
            $clips = array (
                            array(
                                "thumb" => base_url()."/application/images/thumb-bg.jpg",
                                "title"=> "Bulbulay Clip",
                                "desc" => "Views 501 | likes 51",
                                "id" => 1,
                                "tags" => array("hum tv sunday",'sunday show hum tv')
                            ),
                            array(
                                "thumb" => base_url()."/application/images/thumb-bg.jpg",
                                "title"=> "Sandal Clip",
                                "desc" => "Views 306 | likes 24",
                                "id" => 2)
            );
            $jsn_popular = json_encode($clips);
            echo $jsn_popular;
        }
	public function drama_lists(){
            $dramas = array (
                
                            array(
                                "thumb" => base_url()."/application/images/thumb-bg.jpg",
                                "title"=> "Bulbulay (21 Eps.)",
                                "desc" => "Last Ep: 21, 28 Sep 2011",
                                "id" => 1,
                                "tags" => array("hum tv sunday",'sunday show hum tv')
                            ),
                            array(
                                "thumb" => base_url()."/application/images/thumb-bg.jpg",
                                "title"=> "Sandal (15 Eps.)",
                                "desc" => "Last Ep: 15, 19 Nov 2010",
                                "id" => 2)
            );
			$this->load->model('Video_Model');
			$drama_array = $this->Video_Model->get_all_dramas();
            $jsn_dramas = json_encode($dramas);
            echo $drama_array;
        }
	public function get_search_results()
	{	
		$keyword = strtolower($this->input->post('keyword'));
              $this->load->model('Video_Model');
              $output = $this->Video_Model->get_search_results($keyword);
              echo $output;
              /*
		$searchresults = array(
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Bulbulay",
							"desc" => "sunday hum channel 1",
							"id" => 1,
							"tags" => array("hum tv sunday",'sunday show hum tv')
							),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Sandal",
							"desc" => "sunday hum channel 2",
							"id" => 2),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Bulbulay",
							"desc" => "sunday hum channel 3",
							"id" => 3,
							"tags" => array("hum tv sunday",'sunday show hum tv')
							),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Sandal",
							"desc" => "sunday hum channel 4",
							"id" => 4),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Bulbulay",
							"desc" => "sunday hum channel 5",
							"id" => 5,
							"tags" => array("hum tv sunday",'sunday show hum tv')
							),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Sandal",
							"desc" => "sunday hum channel 6",
							"id" => 6)
						);
		
		$jsn_search	=	json_encode($searchresults);				 
		echo $jsn_search; */				
	}
	
	/*public function get_favorites()
	{	
		$favoriteresults = array(
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Bulbulay",
							"desc" => "sunday hum channel 1",
							"id" => 1,
							"tags" => array("hum tv sunday",'sunday show hum tv')
							),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Sandal",
							"desc" => "sunday hum channel 2",
							"id" => 2),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Bulbulay",
							"desc" => "sunday hum channel 3",
							"id" => 3,
							"tags" => array("hum tv sunday",'sunday show hum tv')
							),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Sandal",
							"desc" => "sunday hum channel 4",
							"id" => 4),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Bulbulay",
							"desc" => "sunday hum channel 5",
							"id" => 5,
							"tags" => array("hum tv sunday",'sunday show hum tv')
							),
						array(
							"thumb" => base_url()."/application/images/thumb-bg.jpg",
							"title"=> "Sandal",
							"desc" => "sunday hum channel 6",
							"id" => 6)
						);
		
		$jsn_favorite	=	json_encode($favoriteresults);				 
		echo $jsn_favorite;				
	}*/

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */