<?php
require_once APPPATH.'controllers/base_controller.php';


class Signin extends Base_Controller {

	function Signin()
	{
		parent::Base_Controller();	

	}

	function index()
	{

		$_data['subdomain'] = $this->subdomain;
		$_data['site_name'] = $this->site_name;
		$_data['authSubUrl'] = $this->_getAuthSubUrl();
		$this->load->view('signin1', $_data);

	}

	function callback()
	{



		$this->_Authentication();
		$email = $_data['email'] = $this->email;

		$userData = $this->User_model->getWhere(array('email' => $email), 1);
		//print"<pre>";var_dump($userData);print"</pre>";
		
		//if(empty($this->getUserId())){
		if( empty($this->user_id) ){

			if(empty($this->subdomain)) $notRegisteredOwner = TRUE; else $notRegisteredMember = TRUE;
			$_data['ask_name'] = TRUE;

		} else {

			if(empty($this->subdomain)){
				//checking if user is the owner
				$siteData = $this->Site_model->getWhere(array('owner_id' => $this->getUserId()), 1);
				if(empty($siteData)) $notRegisteredOwner = TRUE;
				else $registeredOwner = TRUE;
			} else{

				//checking if user is the member of site
				$siteData = $this->Site_model->getWhere(array('subdomain' => $this->subdomain), 1);
				$_data['subdomain_id'] = $siteData[0]['id'];
				$isMember = $this->User_is_member_of_site_model->getWhere(array('user_id' => $this->getUserId(), 'site_id' => $siteData[0]['id']), 1);
				if(empty($isMember)) $notRegisteredMember = TRUE;

			}
	       }
			$_data['site_name'] = $this->site_name;
			$_data['firstname'] = '';
			$_data['lastname'] = '';

		if(!empty($notRegisteredOwner)){
			//not registered owner

			$_data['captcha'] = recaptcha_get_html($this->recaptcha_publickey);
			$_data['site_url'] = '';

			$this->load->view('owner_registration', $_data);

		} elseif(!empty($notRegisteredMember)) {

			$this->load->view('member_registration', $_data);

		} elseif(!empty($this->subdomain)) {


			if($isMember[0]['member_y_n']){
			//member approved
				redirect( 'http://' . $_SERVER['HTTP_HOST'] . '/member/');
			} else{
			//member not approed
				//print "You have not been approved yet.";
				$this->load->view('member_not_approved');

			}

		} elseif(!empty($registeredOwner)) {
		// redirecting owner to his subdomain
			//redirect( 'http://' . $siteData[0]['subdomain'] . '.'.$this->conf['site_name'].'/member/');

			$_data['captcha'] = recaptcha_get_html($this->recaptcha_publickey);
			$_data['site_url'] = '';

			$this->load->view('owner_registration', $_data);


		}
	}




}