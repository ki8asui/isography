<?php
require_once APPPATH.'controllers/utest/base_test.php';

class Sites extends Base_test {

    function Sites()
    {
		parent::Base_test(); 
        $this->load->model('site_model');
		$this->load->model('user_model');
        $this->cur_model = $this->site_model;
    }
    
    function _get_data()
    {
    	return array(
			'owner_id' => $this->user_model->getRandomKey(),
			'name' => $this->_rword(),
			'subdomain' => $this->_rword(6, FALSE),
			'active_y_n' => $this->_rword(1, FALSE)
    	);
    }
}

/* End of file sites.php */
/* Location: ./system/application/controllers/utest/sites.php */