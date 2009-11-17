<?php
require_once APPPATH.'controllers/base_controller.php';
require_once APPPATH.'libraries/Facebook/facebook.php';


class Fbconnect_test extends Base_Controller {

	function Fbconnect_test()
	{
		parent::Base_Controller();	

	}

	function index()
	{
		$this->load->view('fbconnect_test');
	}

}



