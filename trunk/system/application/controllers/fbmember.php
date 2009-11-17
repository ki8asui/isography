<?php
require_once APPPATH.'controllers/base_controller.php';
require_once APPPATH.'libraries/Facebook/facebook.php';


class Fbmember extends Base_Controller {

	function Fbmember()
	{
		parent::Base_Controller();	
		//$this->subdomain = 'x';
		//$_sitedata = $this->Site_model->getWhere('subdomain = '.$this->subdomain,1);
		//$this->subdomainId = $_sitedata[0]['id'];

		//$this->facebook = new Facebook($this->facebookApiKey,$this->facebookAppSecret);
		//$this->fbUserId = $this->facebook->api_client->users_getLoggedInUser();
		//$_userdata = $this->User_model->getWhere('fb_user_id = '.$this->fbUserId,1);
	//check userdata, if zero - there is no user with such facebookid - so, this user not linked with facebook
		//$this->userSettings = $userSettings = $this->User_is_member_of_site_model->getWhere(array('user_id' => $_userdata[0]['id'], 'site_id' => $this->subdomainId), 1);
	
		
	}


	function index()
	{
		$this->load->view('facebook/index');
	}

/*
	function index()
	{


	        $params = $this->uri->uri_to_assoc();
		@$offset = $params['offset'];
		if($offset) $offset = (int)$offset; else $offset = 0;
		if($offset < 0) $offset = 0;


		if(!empty($_POST))
		{

			$_data['hide_messages'] = $hide_messages = $this->input->post('hide_messages');
			$_data['hide_pictures'] = $hide_pictures = $this->input->post('hide_pictures');
			$_data['hide_videos'] = $hide_videos = $this->input->post('hide_videos');
			$_data['date1'] = $date1 = $this->input->post('date1');
			$_data['date2'] = $date2 = $this->input->post('date2');

		//var_dump($where);

		}
		else
		{

			@$_data['date1'] = $date1 = $params['date1'];
			@$_data['date2'] = $date2 = $params['date2'];
			@$_data['hide_messages'] = $hide_messages = $params['hide_messages'];
			@$_data['hide_pictures'] = $hide_pictures =  $params['hide_pictures'];
			@$_data['hide_videos'] = $hide_videos = $params['hide_videos'];


		}

		$where = 'site_id = ' . (int)$this->subdomainId;
		$where1 = array();
		if(empty($hide_messages)) $where1[] = " post_type = 'message' ";
		if(empty($hide_pictures)) $where1[] = " post_type = 'picture' ";
		if(empty($hide_videos)) $where1[] = " post_type = 'video' ";
		if(!empty($hide_videos) && !empty($hide_pictures) && !empty($hide_messages)) $where1[] = " post_type = 'unknown' ";

		$where_ = ''; $i = 0;
		foreach($where1 as $v)
		{
			if($i > 0) $where_ .= ' or ';
			$where_ .= $v;
			$i++;				
		}                                                                 	
		if(!empty($where_)) $where .= ' and (' . $where_ . ') ';
		if(!empty($date1))
		{
			$date1 = date("Y-m-d 00:00:00", strtotime($date1));
			$where .= " and post_date >= '" . $date1 . "'";
		}
		if(!empty($date2))
		{
			$date2 = date("Y-m-d 23:59:59", strtotime($date2));
			$where .= " and post_date <= '" . $date2 . "'";
		}


		//$_data['posts'] = $posts = $this->Post_model->getList($limit = 2, $offset = ($page - 1) * $limit, $where=array( 'site_id' => $this->subdomainId ), $order='posts.id DESC', array('table' => 'users', 'field1' => 'id', 'field2' => 'user_id'), $select='posts.*, users.username');
		//$_data['posts'] = $posts = $this->Post_model->getList($limit = 100, $offset, $where, $order='posts.id DESC', array('table' => 'users', 'field1' => 'id', 'field2' => 'user_id'), $select='posts.*, users.username');
		$_data['posts'] = $posts = $this->Post_model->getPosts($limit = 100, $offset, $where, $order = 'posts.id DESC');
		$totalRows = $this->Post_model->getListCount($where);
		
		$this->load->view('member_top');
		$this->load->view('member_index', $_data);

		// pagination
		$this->load->library('pagination');

		$config['uri_segment'] = 4;
		$config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . "/member/index/";
		if(!empty($date1)) { $config['base_url'] .= "date1/${date1}/"; $config['uri_segment'] += 2; }
		if(!empty($date2)) { $config['base_url'] .= "date2/${date2}/"; $config['uri_segment'] += 2; }
		if(!empty($hide_messages)) { $config['base_url'] .= "hide_messages/${hide_messages}/"; $config['uri_segment'] += 2; }
		if(!empty($hide_pictures)) { $config['base_url'] .= "hide_pictures/${hide_pictures}/"; $config['uri_segment'] += 2; }
		if(!empty($hide_videos)) { $config['base_url'] .= "hide_videos/${hide_videos}/"; $config['uri_segment'] += 2; }
		$config['base_url'] .= "offset";

		$config['total_rows'] = $totalRows;
		$config['per_page'] = $limit;
		
		//$config['page_query_string'] = TRUE;
		//$config['enable_query_strings'] = FALSE;

		$this->pagination->initialize($config);
		$_d['p'] = $this->pagination->create_links();
		$this->load->view('member_index_pagination', $_d);


	}

*/



	function settings()
	{

		$_data = array();

		if(!empty($_POST['submit']))
		{
			$subscribe = $this->input->post('email');
			$facebook_vids = $this->input->post('send_pictures_to_facebook');
			$facebook_pics = $this->input->post('send_videos_to_facebook');
			
			$this->User_is_member_of_site_model->update($this->getUserId(), $this->subdomainId, $subscribe, $facebook_pics, $facebook_vids, 1, NULL);
			//var_dump($_POST);
			$savedFlag = true;

		}
		
		$userSettings = $this->User_is_member_of_site_model->getWhere(array('user_id' => $this->getUserId(), 'site_id' => $this->subdomainId), 1);

		if(!empty($userSettings))
		{
			$_data = $userSettings[0];
		}

		if(!empty($savedFlag))	$_data['message']= 'Settings have been saved';


		$this->load->view('member_top');
		$this->load->view('member_settings', $_data);
		$this->load->view('footer');
	}

	function facebooklink()
	{
		$this->load->view('facebook_link');
	}

	
	function postmessage()
	{
		$this->load->view('member_post_message');
	}


	function postpicture()
	{	
                if($albums = $this->_getAlbums())
		{

			$_data['albums'] = $albums;
			$this->load->view('member_post_picture', $_data);

		}
	}


	function postvideo()
	{	
		$_data = array();
		$this->load->view('member_post_video', $_data);
	}

	function addmessage()
	{
		//$_data = array('message' => $this->input->post('message'));
		//$this->Post_model->newPost($_data, $this->getUserId());

		$message =  $this->input->post('message');		

		if(!empty($message))
		{
			$this->Post_model->insert($this->getUserId(), $this->subdomainId, date("Y-m-d H:i"), 'message', NULL, NULL, $message);
			$this->load->view('member_post_message_success');
			$sitedata = $this->Site_model->getById($this->subdomainId);
			$users = $this->User_is_member_of_site_model->getList(0,0,array('subscribe_y_n'=>1,'site_id'=>$this->subdomainId),'',array('table'=>'users','field1'=>'id','field2'=>'user_id'));
			foreach ($users as $user):
			{			
				$this->_sendemail('newpost',array('sitename'=>$sitedata['name'],'subdomain'=>$sitedata['subdomain'],'email'=>$user['email']));
			}
			endforeach;

		}
		else
		{
			$_data['message'] = 'Please enter a message';
			$this->load->view('member_post_message', $_data);
		}

	}

	function uploadpicture()
	{
		//uploading photo to server


		$_data['new_album_name'] = $newAlbumName = $this->input->post('new_album_name');
		$_data['album_id'] = $albumId =  $this->input->post('album_id');
		//var_dump($_SESSION);
		
		if(!($albumId || $newAlbumName))
		{ 
			//echo "test";
			$_data['msg'] = $msg = 'You should select album or enter new album name';
			$_data['albums'] = $this->_getAlbums();

		}
		elseif (!empty($_FILES['image']))
		{
		
			$uploaddir = BASEPATH . '../pictures';
			$fname = $_FILES['image']['name'];
			$fsize = $_FILES['image']['size'];
			$ftmpname = $_FILES['image']['tmp_name'];
	
			$ext = '';
			if(preg_match("/.+(\..+)$/i",$fname,$matches))
				$ext = strtolower($matches[1]);//file extension
	
	
			$filename = $this->_genFileName($ext,$uploaddir);
			$uploadfile = $uploaddir . '/' . $filename;
			//debug: //echo $uploadfile;
			
			//$fsize < 3000000  //allow to upload only pics that less then file_upload_size bytes
			if(in_array($ext, array(".gif",".png",".jpg")) )
			{
		
				if(move_uploaded_file($ftmpname, $uploadfile))
				{
					//uploaded
					$uploaded = TRUE;
					
				}
				else
				{
					//Error while uploading file
				}
			}
			else
			{
				//Picture shouldn't exceed file_upload_size bytes
	
				$_data['msg'] = $msg = 'Uploaded file should be a picture';
			}
	
		}
		else
		{

			$_data['msg'] = $msg = 'You should select picture to upload';

		}

		if(empty($uploaded))
		{

			if(empty($msg))
			{
				$_data['msg'] = $msg = 'Cannot upload file';
			}

			$_data['albums'] = $this->_getAlbums();
			$this->load->view('member_post_picture', $_data);
			//exit;

		}
		else
		{

	
			$photoName = "Test";
			$photoCaption = "Uploaded to Picasa Web Albums via PHP.";
			$photoTags = "";
	
			$fd = $this->gp->newMediaFileSource($uploadfile);
			$fd->setContentType("image/jpeg");
	
			// Create a PhotoEntry
			$photoEntry = $this->gp->newPhotoEntry();
	
			$photoEntry->setMediaSource($fd);
			$photoEntry->setTitle($this->gp->newTitle($photoName));
			$photoEntry->setSummary($this->gp->newSummary($photoCaption));
	
			// add some tags
			$keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
			$keywords->setText($photoTags);
			$photoEntry->mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
			$photoEntry->mediaGroup->keywords = $keywords;
	
			// We use the AlbumQuery class to generate the URL for the album
			$albumQuery = $this->gp->newAlbumQuery();

			$albumQuery->setUser($this->username);
			if($albumId)
			{
				$albumQuery->setAlbumId($albumId);
			}
			else
			{

				$entry = new Zend_Gdata_Photos_AlbumEntry();
				$entry->setTitle($this->gp->newTitle($newAlbumName));
				$entry->setSummary($this->gp->newSummary(""));
				$createdEntry = $this->gp->insertAlbumEntry($entry);
				//$albumQuery->setAlbumName($newAlbumName);
				$albumQuery->setAlbumId((string)$createdEntry->gphotoId);
	
				//Zend_Debug::dump((string)$createdEntry->gphotoId);


			}

			// We insert the photo, and the server returns the entry representing
			// that photo after it is uploaded
			$insertedEntry = $this->gp->insertPhotoEntry($photoEntry, $albumQuery->getQueryUrl()); 

			if ($insertedEntry->getMediaGroup()->getContent() != null)
			{
	
				$mediaContentArray = $insertedEntry->getMediaGroup()->getContent();
				$contentUrl = $mediaContentArray[0]->getUrl();
		              print"<pre>";var_dump($contentUrl);print"</pre>";

              		if(!empty($this->fbUserId) && !empty($this->userSettings) && $this->userSettings[0]['facebook_pics_y_n'] == 1 )
				{
					// uploading picture to Facebook

					//$Albums = $this->facebook->api_client->photos_getAlbums($this->fbUserId, null);
					//if(!empty($Albums)) $AlbumId = $Albums[0]['aid']; else $AlbumId = null;
					//print"<pre>";var_dump($AlbumId);print"</pre>";


			          	try
					{
						$this->facebook->api_client->photos_upload($uploadfile, null, "Uploading image with ".$this->conf['site_name'], $this->fbUserId);
						//$this->facebook->api_client->photos_upload($uploadfile, $AlbumId, "Uploading image with pep6", $this->fbUserId);

					}
					catch (Exception $ex)
					{
						echo $ex->getMessage();
						//echo "Cannot upload picture to facebook";
					}


				}


				$lastMessage = $this->Post_model->getWhere(null , $limit=1, $offset=0, $order='id DESC');
	
				if(!empty($lastMessage) && $lastMessage[0]['user_id'] == $this->getUserId() && $lastMessage[0]['site_id'] == $this->subdomainId && $lastMessage[0]['post_type'] == 'picture')
				{

					$this->Post_pictures_model->insert($lastMessage[0]['id'], $contentUrl);
	
				}
				else
				{
	
					$this->Post_model->insert($this->getUserId(), $this->subdomainId, date("Y-m-d H:i"), 'picture', $contentUrl, NULL, NULL);

				}

				$this->load->view('member_post_picture_success', $_data);
		
				$sitedata = $this->Site_model->getById($this->subdomainId);
				$users = $this->User_is_member_of_site_model->getList(0,0,array('subscribe_y_n'=>1,'site_id'=>$this->subdomainId),'',array('table'=>'users','field1'=>'id','field2'=>'user_id'));
				foreach ($users as $user):
				{
					$this->_sendemail('newpost',array('sitename'=>$sitedata['name'],'subdomain'=>$sitedata['subdomain'],'email'=>$user['email']));
				}
				endforeach;

				@unlink($uploadfile);



			}
		}
	}

	function uploadvideo()
	{

		if (!empty($_FILES['image'])) {
		
		$uploaddir = BASEPATH . '../video';
		$fname = $_FILES['image']['name'];
		$fsize = $_FILES['image']['size'];
		$ftmpname = $_FILES['image']['tmp_name'];

		$ext = '';
		if(preg_match("/.+(\..+)$/",$fname,$matches))
			$ext = strtolower($matches[1]);//file extension


		$filename = $this->_genFileName($ext,$uploaddir);
		$uploadfile = $uploaddir . '/' . $filename;
		//debug: //echo $uploadfile;
		
		//$fsize < 3000000  //allow to upload only pics that less then file_upload_size bytes
		if(in_array($ext, array('.avi','.3gp','.mov','.mp4','.mpeg','.flv','.swf','.mkv')) ){
	
			if(move_uploaded_file($ftmpname, $uploadfile)){
				//uploaded
				$uploaded = TRUE;
				
			}else{
				//Error while uploading file
			}
		}else{
			//Picture shouldn't exceed file_upload_size bytes

			$_data['msg'] = $msg = 'Uploaded file should be a video';
		}

		} else {

			$_data['msg'] = $msg = 'You should select a video to upload';

		}


		if(empty($uploaded)) {

			if(empty($msg)){
				$_data['msg'] = $msg = 'Cannot upload file';
			}

			$this->load->view('member_post_video', $_data);

		} else {


		$yt = new Zend_Gdata_YouTube($this->client);
		// create a new Zend_Gdata_YouTube_VideoEntry object
		$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

		// create a new Zend_Gdata_App_MediaFileSource object
		$filesource = $yt->newMediaFileSource($uploadfile);
		$filesource->setContentType('video/quicktime');
		// set slug header
		$filesource->setSlug($uploadfile);

		// add the filesource to the video entry
		$myVideoEntry->setMediaSource($filesource);

		// create a new Zend_Gdata_YouTube_MediaGroup object
		$mediaGroup = $yt->newMediaGroup();
		$mediaGroup->title = $yt->newMediaTitle()->setText('My Movie');
		$mediaGroup->description = $yt->newMediaDescription()->setText('My Movie Description');

		// the category must be a valid YouTube category
		// optionally set some developer tags (see Searching by Developer Tags for more details)
		$mediaGroup->category = array(  
		  $yt->newMediaCategory()->setText('Autos')->setScheme('http://gdata.youtube.com/schemas/2007/categories.cat'), 
		  //$yt->newMediaCategory()->setText('mydevelopertag')->setScheme('http://gdata.youtube.com/schemas/2007/developertags.cat'),
		  //$yt->newMediaCategory()->setText('anotherdevelopertag')->setScheme('http://gdata.youtube.com/schemas/2007/developertags.cat')
		  );

		// set keywords
		$mediaGroup->keywords = $yt->newMediaKeywords()->setText('test');
		$myVideoEntry->mediaGroup = $mediaGroup;

		// set video location
		//$yt->registerPackage('Zend_Gdata_Geo');
		//$yt->registerPackage('Zend_Gdata_Geo_Extension');
		//$where = $yt->newGeoRssWhere();
		//$position = $yt->newGmlPos('37.0 -122.0');
		//$where->point = $yt->newGmlPoint($position);
		//$entry->setWhere($where);

		// upload URL for the currently authenticated user
		$uploadUrl = 'http://uploads.gdata.youtube.com/feeds/users/default/uploads';

		try {

		  $newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
 		  //print"<pre>";var_dump($newEntry->getVideoWatchPageUrl());print"</pre>";


                if(!empty($this->fbUserId) && !empty($this->userSettings) && $this->userSettings[0]['facebook_vids_y_n'] == 1 ){
		// uploading video to Facebook

          	try{
			$this->facebook->api_client->video_upload($uploadfile, "Uploading video with ".$this->conf['site_name'], null);
		} catch (Exception $ex) {
			echo $ex->getMessage();
			//echo "Cannot upload video to facebook";
		}


		}


		$lastMessage = $this->Post_model->getWhere(null , $limit=1, $offset=0, $order='id DESC');

		if(!empty($lastMessage) && $lastMessage[0]['user_id'] == $this->getUserId() && $lastMessage[0]['site_id'] == $this->subdomainId && $lastMessage[0]['post_type'] == 'video') {

			$this->Post_videos_model->insert($lastMessage[0]['id'], $newEntry->getVideoWatchPageUrl());
	
		} else {

			$this->Post_model->insert($this->getUserId(), $this->subdomainId, date("Y-m-d H:i"), 'video', NULL, $newEntry->getVideoWatchPageUrl(), NULL);

		}


		  $this->load->view('member_post_video_success');

		$sitedata = $this->Site_model->getById($this->subdomainId);
		$users = $this->User_is_member_of_site_model->getList(0,0,array('subscribe_y_n'=>1,'site_id'=>$this->subdomainId),'',array('table'=>'users','field1'=>'id','field2'=>'user_id'));
		foreach ($users as $user):
		{
			$this->_sendemail('newpost',array('sitename'=>$sitedata['name'],'subdomain'=>$sitedata['subdomain'],'email'=>$user['email']));
		}
		endforeach;

		  //$this->load->view('member_post_video_success', $_data);

		} catch (Zend_Gdata_App_Exception $e) {
		    echo $e->getMessage();
		}

	        @unlink($uploadfile);


		}

	}

	function admin($action='',$count=0,$sort='',$ord='')
	{
		$this->load->model('Owner_model');
		$this->load->view('member_top');
		$this->load->view('owner_top');
		
		if (!$this->isOwnerOfSite()) //---only owners can access admin area
		{
			show_error('You have no access to this area. Please, log in as owner.');
			exit();
		}
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
					$this->_sendemail('approval',array('username'=>$userdata['username'],'sitename'=>$sitedata['sitename'],'subdomain'=>$sitedata['subdomain'],'email'=>$userdata['email']));
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
					$this->_sendemail('denial',array('username'=>$userdata['username'],'sitename'=>$sitedata['name'],'email'=>$userdata['email']));
				}
				endforeach;
			}
			//---show page
			$this->load->library('pagination');
			$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/';
			$config['total_rows'] = $this->User_is_member_of_site_model->getListCount(array('site_id'=>$this->subdomainId, 'member_y_n'=>NULL));
			$config['per_page'] = '20'; 
			$this->pagination->initialize($config); 
			$_data['query'] = $this->Owner_model->getAppUsers($count,$dsort,$this->subdomainId);
			$_data['count'] = $count;
			$_data['csort'] = $sort;
			$_data['cord'] = $ord;
			$this->load->view('owner_app_queue',$_data);
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
			$adata['csort'] = $sort;
			$adata['cord'] = $ord;
			$this->load->library('pagination');
			$this->load->helper('url');
			$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/';
			$config['total_rows'] = $this->Owner_model->getListCount(array('site_id'=>$this->subdomainId));
			$config['per_page'] = '100'; 
			$this->pagination->initialize($config); 
			$this->load->view('owner_moderate_posts',$adata);
		}
		elseif ($action=='editPost')
		{
			$id=$count;
			$data = $this->Owner_model->getPost($id);	
			$adata['query'] = $data;
			$adata['id'] = $id;
			$this->load->helper('url');
			$this->load->view('owner_post_edit',$adata);
		}
		elseif ($action=='deletePost')
		{
			$id=$count;
			$type = $sort;
			if ($type=='message') $this->Owner_model->deletepost($id);
			elseif ($type=='video') $this->Post_videos_model->delete($id);
			elseif ($type=='picture') $this->Post_pictures_model->delete($id);
			$adata['site'] = $site;
			$this->load->view('owner_post_delete',$adata);

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
			$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/members/';
			$config['total_rows'] = $this->User_is_member_of_site_model->getListCount(array('site_id'=>$this->subdomainId, 'member_y_n'=>NULL));
			$config['per_page'] = '20'; 
			$this->pagination->initialize($config); 
			$_data['query'] = $this->Owner_model->getUsers($count,$sort,$this->subdomainId);
			$_data['count'] = $count;
			$_data['csort'] = $sort;
			$_data['cord'] = $ord;
			$this->load->view('owner_members',$_data);

		}


	}


}


	 