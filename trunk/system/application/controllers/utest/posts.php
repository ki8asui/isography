<?php
require_once APPPATH.'controllers/utest/base_test.php';

class Posts extends Base_test {

    function Posts()
    {
		parent::Base_test(); 
		$this->load->model('site_model');
		$this->load->model('user_model');
		$this->load->model('post_model');
		$this->cur_model = $this->post_model;
    }
    
    function _get_data()
    {
	return array(
			'user_id' => $this->user_model->getRandomKey(),
			'site_id' => $this->site_model->getRandomKey(),
			'post_date' => $this->_rstamp(),
			'post_type' => $this->_rword(6),
			'pic_url' => $this->_rword(15, FALSE),
			'vid_url' => $this->_rword(15, FALSE),
			'message' => $this->_rword(50, FALSE)
    	);
    }
}

/* End of file sites.php */
/* Location: ./system/application/controllers/utest/sites.php */