<?php
require_once APPPATH.'controllers/base_controller.php';


class Site extends Base_Controller {

	function Site()
	{
		parent::Base_Controller();	

	}


	function create()
	{

		$email = $_data['email'] = $this->_Authentication();

		$_data['site_name'] = $site_name = $this->input->post('site_name');
		$_data['site_url'] = $site_url = $this->input->post('site_url');

		$_data['ask_name'] = $ask_name = $this->input->post('ask_name');
		$_data['firstname'] = $firstname = $this->input->post('firstname');
		$_data['lastname'] = $lastname = $this->input->post('lastname');


		$resp = recaptcha_check_answer ($this->recaptcha_privatekey,
                                $this->input->server('REMOTE_ADDR'),
                                $this->input->post('recaptcha_challenge_field'),
                                $this->input->post('recaptcha_response_field'));

		if(empty($site_name) || !preg_match("/^[a-z0-9\-]+$/i", $site_url) || ((empty($firstname) || empty($lastname)) && !empty($ask_name)) || !$resp->is_valid) {
		// validation is not passed
			$_data['message'] = 'Fill in the form accuracy';
			$validated = FALSE;
		} else {

			$validated = TRUE;
	
			$userData = $this->User_model->getWhere(array('email' => $email), 1);
			if(empty($userData)){
				//adding user
				$userId = $this->User_model->insert($firstname . ' ' . $lastname, $email, $provider = 'google' , date("Y-m-d H:i"));
			} else {
				$userId = $userData[0]['id'];
			}

			$siteData = $this->Site_model->getWhere(array('subdomain' => $site_url), 1);
			if(!empty($siteData)){
				$_data['message'] = 'This site_url already exists';
				$validated = FALSE;
			}else {
				$siteId = $this->Site_model->insert($userId, $site_name, $site_url, NULL, date("Y-m-d"));
				$this->User_is_member_of_site_model->insert($userId, $siteId, NULL, NULL, NULL, 1, NULL);
			}		


		}

		if(!$validated){
			$_data['captcha'] = recaptcha_get_html($this->recaptcha_publickey);
			$this->load->view('owner_registration', $_data);
		} else {
			$this->load->view('owner_registration_success', $_data);
		}

		//print"<pre>";var_dump($userData);print"</pre>";
		

		//adding site




	}


}

