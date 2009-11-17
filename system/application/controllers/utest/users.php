<?php
require_once APPPATH.'controllers/utest/base_test.php';

class Users extends Base_test {

    function Users()
    {
		parent::Base_test(); 
        $this->load->model('user_model');
        $this->cur_model = $this->user_model;
    }
    
    function _get_data()
    {
    	return array(
			'username' => $this->_rword(),
			'email' => $this->_rmail(),
			'provider' => $this->_rword(),
			'last_login_date' => $this->_rstamp()
    	);
    }
}

/* End of file users.php */
/* Location: ./system/application/controllers/utest/users.php */