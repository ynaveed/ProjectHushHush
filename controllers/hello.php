<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hello extends CI_Controller {

	function __construct() {
		parent::__construct();	 
		//$this->load->helper('form');
		$this->load->model('Hello_model');
	}
	public function index()
	{
		echo "I am hello world controler!!!";
	}
	
	
	public function days_data()
	{	
		$days_arr = array(
						"sun"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/1.jpg","Bulbulay","sunday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/2.jpg","Sandal","sunday hum channel 2")	
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/3.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/4.jpg","Sandal","sunday geo channel 2")
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/5.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/6.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/7.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/8.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/7.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/8.jpg","Sandal","sunday geo channel 2")
								)
							),
						"mon"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/9.jpg","Bulbulay","monday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/10.jpg","Sandal","sunday hum channel 2")
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/11.jpg","Bulbulay","monday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/12.jpg","Sandal","monday geo channel 2")
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/13.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/14.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/15.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/16.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/7.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/8.jpg","Sandal","sunday geo channel 2")
								)
							),
						"tue"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/17.jpg","Bulbulay","tuesday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/18.jpg","Sandal","tuesday hum channel 2")
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/19.jpg","Bulbulay","tuesday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/20.jpg","Sandal","sunday geo channel 2")										
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/21.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/22.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/23.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/24.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/25.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/26.jpg","Sandal","sunday geo channel 2")
								)
							),	
						"wed"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/27.jpg","Bulbulay","wednesday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/28.jpg","Sandal","wednesday hum channel 2")
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/29.jpg","Bulbulay","wednesday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/30.jpg","Sandal","wednesday geo channel 2")										
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/31.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/32.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/33.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/34.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/35.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/36.jpg","Sandal","sunday geo channel 2")
								)
							),
						"thu"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/37.jpg","Bulbulay","thursday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/38.jpg","Sandal","thursday hum channel 2")
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/39.jpg","Bulbulay","thursday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/40.jpg","Sandal","thursday geo channel 2")										
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/1.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/2.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/3.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/4.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/5.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/6.jpg","Sandal","sunday geo channel 2")
								)
							),	
						"fri"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/7.jpg","Bulbulay","friday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/8.jpg","Sandal","friday hum channel 2")
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/9.jpg","Bulbulay","friday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/10.jpg","Sandal","friday geo channel 2")										
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/11.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/12.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/13.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/14.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/15.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/16.jpg","Sandal","sunday geo channel 2")
								)
							),							
						"sat"=>array(
								"hum"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/17.jpg","Bulbulay","saturday hum channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/18.jpg","Sandal","saturday hum channel 2")
								),
								"geo"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/19.jpg","Bulbulay","saturday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/20.jpg","Sandal","saturday geo channel 2")
								),
								"ary"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/21.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/22.jpg","Sandal","sunday geo channel 2")
								),
								"atv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/23.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/24.jpg","Sandal","sunday geo channel 2")
								),
								"ptv"=>array(
											"one"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/25.jpg","Bulbulay","sunday geo channel 1"),
											"two"=>array("http://".$_SERVER['SERVER_NAME']."/application/images/26.jpg","Sandal","sunday geo channel 2")
								)	
							)
							
						);
		$jsn_days	=	json_encode($days_arr);				 
		return $jsn_days;				
	}

	
	public function testme()
	{
		$data['jdays']	=	$this->days_data();
		$this->load->view("hello_view",$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */