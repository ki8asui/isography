<?php

require_once APPPATH . 'libraries/recaptchalib.php';
require_once APPPATH . 'libraries/Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_Photos');
Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');
Zend_Loader::loadClass('Zend_Gdata_Photos_AlbumQuery');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_YouTube');



class Base_controller extends Controller {
	protected $user_id;
	public $model;

	public $recaptcha_publickey;	//http://recaptcha.net
	public $recaptcha_privatekey;	//http://recaptcha.net
	public $developerKey; 		//http://code.google.com/intl/ru/apis/base/signup.html
	public $facebookApiKey;		//http://facebook.com
	public $facebookAppSecret;	//http://facebook.com

	public $subdomain;
	public $subdomainId;
	public $site_name;
	public $client;			//google client
	public $gp;			//Google Photos
	public $username;		//Google user name
	public $email;			//google email

	function getPrimaryModel() {return NULL;}
	function getOptions() {return array();}
	function getUserId() {return $this->user_id;}

	function isMemberOfSite()
	{
	        if(empty($this->subdomainId) || empty($this->user_id)) return false;
		
		$isMember = $this->User_is_member_of_site_model->getWhere(array('user_id' => $this->user_id, 'site_id' => $this->subdomainId, 'member_y_n' => '1'), 1);
		if(empty($isMember)) return false;

		return true;		
	}
	function isSuperUser()
	{
		$adminname = 'mreider';
		//if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!=$adminname)
		if (!isset($_SERVER['PHP_AUTH_USER']))
		{
			echo 'nopspauth';
			return FALSE;
		}
		return TRUE;
	}

	function isOwnerOfSite()
	{
	        if(empty($this->subdomainId) || empty($this->user_id)) return false;
		
		$isOwner = $this->Site_model->getWhere(array('owner_id' => $this->user_id, 'id' => $this->subdomainId), 1);
		if(empty($isOwner)) return false;

		return true;		
	}	

	/**
	 * Constructor
	 *
	 * @return Base_controller
	 */
	function Base_controller()
	{
		parent::Controller();
		if( !$this->config->item('installed') ) redirect( 'http://' . $_SERVER['HTTP_HOST'] . '/install.php' );


		$this->load->model('User_model');
		$this->load->model('Site_model');
		$this->load->model('User_is_member_of_site_model');
		$this->load->model('Post_model');
		$this->load->model('Post_videos_model');
		$this->load->model('Post_pictures_model');
		$this->conf['site_name'] = $this->config->item('site_name');

		$this->recaptcha_publickey = $this->config->item('recaptcha_publickey');
		$this->recaptcha_privatekey = $this->config->item('recaptcha_privatekey');
		$this->developerKey = $this->config->item('developer_key');
		$this->facebookApiKey = $this->config->item('facebook_api_key');
		$this->facebookAppSecret = $this->config->item('facebook_app_secret');


		//checking if exists subdomain
		//if(preg_match("/http:\/\/(.+?)\.".str_replace('.','\.',$this->conf['site_name'])."/", base_url(), $matches)) $this->subdomain = $matches[1];
		if(preg_match("/(.+?)\.".str_replace('.','\.',$this->conf['site_name'])."/", $_SERVER["HTTP_HOST"], $matches)){
			$siteData = $this->Site_model->getWhere(array('subdomain' => $matches[1]), 1);
			if(!empty($siteData) && $siteData[0]['active_y_n'] != '0'){ 
				$this->subdomain = $matches[1];
				$this->site_name = $siteData[0]['name'];
				$this->subdomainId = $siteData[0]['id'];
			}
		}

		//var_dump($siteData[0]);
                  
		$data = array();
		//$data['flashmsg'] = $this->session->flashdata('flashmsg');
		//$data['sitename'] = $this->config->item('sitename');
		$this->load->vars($data);
	}

	function _sendemail($type,$data)
	{
		$this->load->library('email');
		if ($type=='apply')
		{
			$msg = "Dear ".$data['username'].",\n\nThanks for applying for membership to ".$data['sitename']."\nWe will respond within 24 hours with an approval message.\n\nSincerely,\n".$data['sitename']." Mail Robot";
			$this->email->subject('Thanks for Applying');
		}
		elseif ($type=='approval')
		{
			$msg = "Dear ".$data['username'].",\n\nGood news! You have been approved to use the ".$data['sitename']." website. \nLogin at http://".$data['subdomain'].".".$this->conf['site_name'].".\n\n".$data['sitename']." Mail Robot";
			$this->email->subject('Thanks for Applying');
		}
		elseif ($type=='denial')
		{
			$msg = "Dear ".$data['username'].",\n\nSorry! Your application to the ".$data['sitename']." website has been denied.\nHave a great day!\n\n".$data['sitename']." Mail Robot";
			$this->email->subject('Denied!');
		}
		elseif ($type=='newpost')
		{
			$msg = "A new message was posted on ".$data['sitename']." site.\n\nCheck it on http://".$data['subdomain'].".".$this->conf['site_name']."/.\n\n".$data['sitename']." mail robot";;
			$this->email->subject('New post');			
		}
		$this->email->from('admin@'.$this->conf['site_name'], $this->conf['site_name']);
		$this->email->to($data['email']);
		$this->email->message($msg);
		$this->email->send();
	}


	function _getAuthSubUrl()
	{

		if(!empty($this->subdomain)){
		    $next = 'http://' . $_SERVER["HTTP_HOST"] . '/' . 'signin/callback/';
		} else {
		    $next = $this->config->item('base_url') . 'signin/callback/';
		}
		
	    $scope = 'http://gdata.youtube.com http://picasaweb.google.com/data';
	    $secure = false;
	    $session = true;
	    return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure,$session);

	}



	function _getAuthSubHttpClient()
	{
	    //if (!isset($_SESSION['sessionToken']) && !isset($_GET['token']) ){
	    if (!isset($_COOKIE['sessionToken']) && !isset($_GET['token']) ){

	        //echo '<a href="' . $this->_getAuthSubUrl() . '">Login!</a>';
	        //exit;

		redirect( 'http://' . $_SERVER['HTTP_HOST'] . '/signin' );

	    //} else if (!isset($_SESSION['sessionToken']) && isset($_GET['token'])) {
	    } else if (!isset($_COOKIE['sessionToken']) && isset($_GET['token'])) {

	        $sessionToken = $_SESSION['sessionToken'] = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);

		$this->load->helper('cookie');
		$cookie = array(
                   'name'   => 'sessionToken',
                   'value'  => $sessionToken,
                   'expire' => '86500',
               );
		set_cookie($cookie); 

	    }

	    //var_dump($_COOKIE);
	    if(!empty($_COOKIE['sessionToken'])) $client = Zend_Gdata_AuthSub::getHttpClient($_COOKIE['sessionToken']);
		else  $client = Zend_Gdata_AuthSub::getHttpClient($sessionToken);

	    //$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
	    $client->setHeaders('X-GData-Key', "key=" . $this->developerKey);
	    $client->setAuthSubPrivateKeyFIle('/var/www/myrsakey.pem',null,true);
	    return $client;

/*

	    if (!isset($_SESSION['sessionToken']) && !isset($_GET['token']) ){

	        echo '<a href="' . $this->_getAuthSubUrl() . '">Login!</a>';
	        exit;

	    } else if (isset($_GET['token'])) {

		try{

		        $_SESSION['sessionToken'] = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);

	        } catch(Exception $ex) { }
	    }


		try{
		    $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
			    return $client;
		}  catch(Exception $ex) { }
		
		return FALSE;
*/

	}


	function _Authentication()
	{
		session_start();

		$client = $this->_getAuthSubHttpClient();


		// update the second argument to be CompanyName-ProductName-Version
		try{
			$gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");
			// $gp->enableRequestDebugLogging('/tmp/gp_requests.log');

			$user = $gp->getUserFeed();
			$email = $user->getGphotoUser() . '@gmail.com';

		} catch (Exception $ex) {
			//echo $ex->getMessage() . '<br/><br/>';
			echo "You need To <a href='https://www.google.com/accounts/NewAccount?hl=en&continue=http%3A%2F%2Fpicasaweb.google.com%2Flh%2Flogin%3Fcontinue%3Dhttp%253A%252F%252Fpicasaweb.google.ru%252Fhome&followup=http%3A%2F%2Fpicasaweb.google.ru%2Flh%2Flogin%3Fcontinue%3Dhttp%253A%252F%252Fpicasaweb.google.com%252Fhome&service=lh2&ltmpl=gp&passive=true'>Register with Picasa</a> to proceed";
			exit;

		}


		$userData = $this->User_model->getWhere(array('email' => $email), 1);
		if(!empty($userData)){
			$this->user_id = $userData[0]['id'];
		}
		$this->client = $client;
		$this->gp = $gp;
		$this->username = (string)$user->getGphotoUser();
		$this->email = $email;
		return $email;


	}


	    function _genWord($length = 12)
	    {
		$str = "23456789wertpasdfhkzxcvbnmQWERTPASDFGHKZXCVBNM";
		$word = "";
		$i = 0;
		while($i<$length){
			$pos = rand(0,strlen($str)-1)	;
			$word .= $str[$pos];
			$i++;
		}
		return $word;
	    }

	    function _genFileName($ext,$path)
	    {
	    	$flag = false;
	    	while (!$flag) {    		
	    	$fname = $this->_genWord() . $ext;
	    	$files = scandir($path);
		if(count($files) < 3) break;
	    	foreach ($files as $v){
	    		if($v == '.' || $v == '..') continue;
	    		if($fname == $v) break;
	    		$flag = true;
	    	}
	    	}
	    	return $fname;
	    }


	function _getAlbums()
	{

		try {

		    $i = 0;
		    $albums = array();
		    $userFeed = $this->gp->getUserFeed("default");

		    //print "<pre>";var_dump($userFeed);print "</pre>";
		    foreach ($userFeed as $userEntry) {

		        $albums[$i]['name'] = (string)$userEntry->title->text;
			$albums[$i]['id'] = (string)$userEntry->getGphotoId();
			$i++;			
		    }
			return $albums;

		} catch (Zend_Gdata_App_HttpException $e) {
		    echo "Error: " . $e->getMessage() . "<br />\n";
		    if ($e->getResponse() != null) {
		        echo "Body: <br />\n" . $e->getResponse()->getBody() . 
	        	     "<br />\n"; 
		    }
		    // echo "Request: <br />\n" . $e->getRequest() . "<br />\n";
		} catch (Zend_Gdata_App_Exception $e) {
		    echo "Error: " . $e->getMessage() . "<br />\n"; 
		}
	
		return false;
	}



}// END OF BASE CONTROLLER CLASS

/* End of file base_controller.php */
/* Location: ./system/application/controllers/base_controller.php */
