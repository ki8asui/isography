<?php

require_once APPPATH.'controllers/base_controller.php';


class Welcome extends Base_Controller {

	function Welcome()
	{
		parent::Base_Controller();	
		$this->_Authentication();
		if(!empty($this->username) && !empty($this->subdomain)) redirect('http://' . $_SERVER['HTTP_HOST'] . '/member'); //if logged in redirect to activity
	}

	function index()
	{

		$_data['subdomain'] = $this->subdomain;
		$_data['site_name'] = $this->site_name;
		$_data['authSubUrl'] = $this->_getAuthSubUrl();
		$this->load->view('signin1', $_data);

	}




}