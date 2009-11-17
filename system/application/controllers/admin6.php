<?php
require_once APPPATH.'controllers/base_controller.php';

class Admin6 extends Base_Controller
{
	function Admin6()
	{
		parent::Base_controller();
		if(!empty($this->subdomain) && $this->uri->segment(2)!='siteadmin') exit('This controller is not for subdomains.'); // This controller is not for subdomains.
		if (!$this->isSuperUser())
		{
			show_error('You have no access. Please, autorize.');
			exit();
		}
		$this->load->model('Admin6_model');
	}
	function index($item=0,$sort='',$ord='')
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('admin6/index');
		$config['total_rows'] = $this->Site_model->getListCount();
		$config['per_page'] = '100'; 
		$this->pagination->initialize($config); 
		if ($sort=='')
		{
			$dsort='id DESC';
			$sort='id';
		}
		else
		{
			if ($ord=='') $ord='ASC';
			$dsort = $sort.' '.$ord;
		}
		$_data['query'] = $this->Admin6_model->getSiteList($item,$dsort);
		$_data['count'] = $item;
		$_data['csort'] = $sort;
		$_data['cord'] = $ord;
		$this->load->view('superuserarea',$_data);
	}
	function unplug($subdomain)
	{
		$site = $this->Site_model->getWhere(array('subdomain'=>$subdomain),1,0,'');
		$this->Site_model->update($site[0]['id'],$site[0]['owner_id'],$site[0]['name'],$site[0]['subdomain'],'0',$site[0]['created']);
		$_data['dm'] = $subdomain;		
		$this->load->view('superuser_site_unplugged',$_data);
	}
	function activate($subdomain)
	{
		$site = $this->Site_model->getWhere(array('subdomain'=>$subdomain),1,0,'');
		$this->Site_model->update($site[0]['id'],$site[0]['owner_id'],$site[0]['name'],$site[0]['subdomain'],'1',$site[0]['created']);
		$_data['dm'] = $subdomain;		
		$this->load->view('superuser_site_activated',$_data);

	}
	function destroy($subdomain)
	{
		$site = $this->Site_model->getWhere(array('subdomain'=>$subdomain),1,0,'');
		$this->Post_model->deleteWhere(array('site_id'=>$site[0]['id']));
		$this->User_is_member_of_site_model->deleteWhere(array('site_id'=>$site[0]['id']));
		$this->Site_model->delete($site[0]['id']);
		$_data['dm'] = $subdomain;
		$this->load->view('superuser_site_destroyed',$_data);
	}


	function siteadmin($site, $action='',$count=0,$sort='',$ord='')
	{
		if(empty($site)) exit('This controller is only for subdomains.'); // This controller is only for subdomains.
		$this->load->model('Owner_model');
		$_ddata['site'] = $site;
		$this->load->view('admin6_owner_top', $_ddata);
		$_tdata = $this->Site_model->getWhere(array('subdomain' => $site),1);
		$this->subdomainId = $_tdata[0]['id'];
		if ($sort=='')
		{
			$dsort='id DESC';
			$sort='id';
		}
		else
		{
			if ($ord=='') $ord='ASC';
			$dsort=$sort.' '.$ord;
		}
		if ($action=='') $action='appQueue';
		if ($action=='appQueue') //---first tab. Application Queue
		{
			if ($this->input->post('action'))
			{
				$_ddata = $this->Owner_model->getAppUsers($count,$dsort,$this->subdomainId);
				foreach ($_ddata as $imember):
				if ($this->input->post('radio'.$imember['user_id'])=='approve')
				{
				//---approve member
					$uid = array(
						'site_id'=>$this->subdomainId,
						'user_id'=>$imember['user_id']
					);
					$_data1=array('member_y_n'=>1);
					$this->User_is_member_of_site_model->update_array($uid,$_data1);
					$_data['changelist'][]='User '.$imember['username'].' (#'.$imember['user_id'].') approved!';
				//---send approval email
					$userdata=$this->User_model->getById($imember['user_id']);
					$sitedata=$this->Site_model->getById($this->subdomainId);
					_sendemail('approval',array('username'=>$userdata['username'],'sitename'=>$sitedata['sitename'],'subdomain'=>$sitedata['subdomain'],'email'=>$userdata['email']));
				}
				elseif ($this->input->post('radio'.$imember['user_id'])=='deny')
				{
				//---deny member
					$uid = array(
						'site_id'=>$this->subdomainId,
						'user_id'=>$imember['user_id']
					);
					$_data1=array('member_y_n'=>0);
					$this->User_is_member_of_site_model->update_array($uid,$_data1);
					$_data['changelist'][]='User '.$imember['username'].' (#'.$imember['user_id'].') denied!';
				//---send denied email
					$userdata=$this->User_model->getById($imember['user_id']);
					$sitedata=$this->Site_model->getById($this->subdomainId);
					_sendemail('denial',array('username'=>$userdata['username'],'sitename'=>$sitedata['name'],'email'=>$userdata['email']));
				}
				endforeach;
			}
			//---show page
			$this->load->library('pagination');
			$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/admin6/siteadmin/appQueue/';
			$config['total_rows'] = $this->User_is_member_of_site_model->getListCount(array('site_id'=>$this->subdomainId, 'member_y_n'=>NULL));
			$config['per_page'] = '20'; 
			$this->pagination->initialize($config); 
			$_data['query'] = $this->Owner_model->getAppUsers($count,$dsort,$this->subdomainId);
			$_data['count'] = $count;
			$_data['site'] = $site;
			$_data['csort'] = $sort;
			$_data['cord'] = $ord;
			$this->load->view('admin6_owner_app_queue',$_data);
		}
		elseif ($action=='moderatePosts') //---second tab. Moderate
		{
			if ($this->input->post('action'))	//---saving edited post
			{
				$data['message'] = $this->input->post('message');
				$this->Owner_model->updatePost($this->input->post('id'), $data);
			}
			//---load posts and display page
			$where='site_id = '.$this->subdomainId;
			$data = $this->Post_model->getPosts(100, $count, $where, $dsort);

			$adata['query'] = $data;
			$adata['count'] = $count;
			$this->load->library('pagination');
			$this->load->helper('url');
			$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/admin6/siteadmin/moderatePosts/';
			$config['total_rows'] = $this->Owner_model->getListCount(array('site_id'=>$this->subdomainId));
			$config['per_page'] = '100'; 
			$this->pagination->initialize($config); 
			$adata['site'] = $site;
			$adata['csort'] = $sort;
			$adata['cord'] = $ord;
			$this->load->view('admin6_owner_moderate_posts',$adata);
		}
		elseif ($action=='editPost')
		{
			$id=$count;
			$data = $this->Owner_model->getPost($id);	
			$adata['query'] = $data;
			$adata['id'] = $id;
			$adata['site'] = $site;
			$this->load->helper('url');
			$this->load->view('admin6_owner_post_edit',$adata);
		}
		elseif ($action=='deletePost')
		{
			$id=$count;
			$type = $sort;
			if ($type=='message') $this->Owner_model->deletepost($id);
			elseif ($type=='video') $this->Post_videos_model->delete($id);
			elseif ($type=='picture') $this->Post_pictures_model->delete($id);
			$adata['site'] = $site;
			$this->load->view('admin6_owner_post_delete',$adata);
		}


		elseif ($action=='members') //---third tab. Members
		{
			if ($this->input->post('action'))
			{
				$_ddata = $this->Owner_model->getUsers($count,$dsort,$this->subdomainId);
				foreach ($_ddata as $imember):
				if ($this->input->post('rem'.$imember['user_id'])=='remove')
				{
					//remove member
					$uid = array(
						'site_id'=>$this->subdomainId,
						'user_id'=>$imember['user_id']
					);
					$this->User_is_member_of_site_model->delete($uid);
					$_data['changelist'][]='User '.$imember['username'].' (#'.$imember['user_id'].') removed!';
				}
				endforeach;
			}
			$this->load->library('pagination');
			$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/admin6/siteadmin/members/';
			$config['total_rows'] = $this->User_is_member_of_site_model->getListCount(array('site_id'=>$this->subdomainId, 'member_y_n'=>NULL));
			$config['per_page'] = '20'; 
			$this->pagination->initialize($config); 
			$_data['query'] = $this->Owner_model->getUsers($count,$dsort,$this->subdomainId);
			$_data['count'] = $count;
			$_data['site'] = $site;
			$_data['csort'] = $sort;
			$_data['cord'] = $ord;
			$this->load->view('admin6_owner_members',$_data);

		}


	}



}
?>