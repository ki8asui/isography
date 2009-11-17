<?php
require_once APPPATH.'controllers/utest/base_test.php';

class User_is_member_of_site extends Base_test {

    function User_is_member_of_site()
    {
		parent::Base_test(); 
        $this->load->model('user_is_member_of_site_model');
        $this->load->model('user_model');
        $this->load->model('site_model');
        $this->cur_model = $this->user_is_member_of_site_model;
    }
    
    function _get_data()
    {
    	return array(
			'user_id' => $this->user_model->getRandomKey(),
			'site_id' => $this->site_model->getRandomKey(),
			'subscribe_y_n' => $this->_rbool(),
			'facebook_pics_y_n' => $this->_rbool(),
			'facebook_vids_y_n' => $this->_rbool(),
			'member_y_n' => $this->_rbool(),
			'facebook_infinite_key' => $this->_rword(6, FALSE)
    	);
    }
}

/* End of file user_is_member_of_site.php */
/* Location: ./system/application/controllers/utest/user_is_member_of_site.php */