<?php
$PATH = realpath(dirname(__FILE__));
require_once $PATH . '/system/application/libraries/Facebook/facebook.php';


function installform($validation){
	extract($_POST);

?>


<form id='installform' method="POST" action="install.php" >

<div style="width: 1100px;">

<div style="float: left; margin: 0px 20px 10px 0px; padding: 4px; border: solid 1px #666666; background: #ffffff;"><object width="340" height="285"><param name="movie" value="http://www.youtube.com/v/7trUHFV6x08&hl=en&fs=1&rel=0&border=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/7trUHFV6x08&hl=en&fs=1&rel=0&border=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="340" height="285"></embed></object></div>

<div style="float: left; width: 280px; ">
<h2>Basic Settings</h2><br/><br/>

<div style="float: left; width: 110px; margin-top: 10px;">Site Title:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="site_title" value="<?=@$site_title?>" <?if(isset($validation['site_title'])):?>style="border: solid 1px red;"<?endif;?> /></div>
<div style="clear: left; "></div>

<div style="float: left; width: 90px; margin-top: 10px;">Site url:</div>
<div style="float: left; margin-top: 10px;">http://<input type="text" name="site_name" value="<?=@$site_name?>" <?if(isset($validation['site_name'])):?>style="border: solid 1px red; width: 130px;"<?else:?>style="width: 130px;"<?endif;?> /></div>
<div style="clear: left; "></div>

<div style="float: left; width: 110px; margin-top: 10px;">Admin username:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="admin_username" value="<?=@$admin_username?>" <?if(isset($validation['admin_username'])):?>style="border: solid 1px red;"<?endif;?> /></div>
<div style="clear: left; "></div>

<div style="float: left; width: 110px; margin-top: 10px;">Admin password:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="admin_password" value="<?=@$admin_password?>" <?if(isset($validation['admin_password'])):?>style="border: solid 1px red;"<?endif;?> /></div>
<div style="clear: left; "></div>


<br/><br/><h2>Facebook Settings</h2><br/><br/>

<?if(isset($validation['fb'])):?>
<div style="color: red;">Wrond facebook api key or secret</div>
<?endif;?>

<div style="float: left; width: 110px; margin-top: 10px;">FB api key:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="fb_api_key" value="<?=@$fb_api_key?>" <?if(isset($validation['fb_api_key'])):?>style="border: solid 1px red; "<?endif;?> /></div>
<div style="clear: left;"></div>

<div style="float: left; width: 110px; margin-top: 10px;">FB app secret:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="fb_app_secret" value="<?=@$fb_app_secret?>" <?if(isset($validation['fb_app_secret'])):?>style="border: solid 1px red; "<?endif;?> /></div>
<div style="clear: left;"></div>

</div>


<div style="float: left; width: 380px; ">
<h2>MySQL Database Settings</h2><br/><br/>

<?if(isset($validation['db_connect'])):?>
<div style="color: red;">Wrond database settings: Cannot connect to specified database</div>
<?endif;?>

<div style="float: left; width: 110px; margin-top: 10px;">Hostname:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="db_hostname" value="<?=@$db_hostname?>" <?if(isset($validation['db_hostname'])):?>style="border: solid 1px red; "<?endif;?> /></div>
<div style="clear: left;"></div>

<div style="float: left; width: 110px; margin-top: 10px;">Username:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="db_username" value="<?=@$db_username?>" <?if(isset($validation['db_username'])):?>style="border: solid 1px red; "<?endif;?> /></div>
<div style="clear: left;"></div>

<div style="float: left; width: 110px; margin-top: 10px;">Password:</div>
<div style="float: left; margin-top: 10px;"><input type="password" name="db_password" value=""  /></div>
<div style="clear: left;"></div>

<div style="float: left; width: 110px; margin-top: 10px;">Database:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="db_database" value="<?=@$db_database?>" <?if(isset($validation['db_database'])):?>style="border: solid 1px red; "<?endif;?> /></div>
<div style="clear: left;"></div>

<br/><br/><h2>Other Settings</h2><br/><br/>
<div style="float: left; width: 180px; ">Google Developer Key:</div>
<div style="float: left; "><input type="text" name="developer_key" value="<?=@$developer_key?>" <?if(isset($validation['fb_api_key'])):?>style="border: solid 1px red; "<?endif;?>  /></div>
<div style="clear: left;"></div>

<div style="float: left; width: 180px; margin-top: 10px;">Recaptcha Public Key:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="recaptcha_publickey" value="<?=@$recaptcha_publickey?>" <?if(isset($validation['recaptcha_publickey'])):?>style="border: solid 1px red; "<?endif;?>  /></div>
<div style="clear: left;"></div>

<div style="float: left; width: 180px; margin-top: 10px;">Recaptcha Private Key:</div>
<div style="float: left; margin-top: 10px;"><input type="text" name="recaptcha_privatekey" value="<?=@$recaptcha_privatekey?>" <?if(isset($validation['recaptcha_privatekey'])):?>style="border: solid 1px red; "<?endif;?>  /></div>
<div style="clear: left;"></div>

</div>


<div style="clear: left; width: 100%; height: 20px; border-bottom: solid 1px #e0e0e0;"></div>
<?php if(!empty($validation)) echo "<font style=\"color: red; font-size: 11px; \">* You should fill in highlighted fields</font><br/>"; ?>

<br/><input style="font-size: 24px; float: left; margin-left: 360px; padding: 10px;" type="submit" value="Install" />
<div style="font-size: 10px; float: left; width: 500px; margin: -5px 0px 0px 50px; color: #999;" >
Make sure that files system/application/config/config.php and system/application/config/database.php and admin6/ directory are rewriteable.
<br/><br/>
<span style="font-size: 17px;">IMPORTANT: After installation remove install.php file</span></div>
</div>
</form>


<?php
}


if($_POST) {


	$validation = array();
	$DATA = $_POST;
	foreach ($DATA as $k=>$v) $DATA[$k] = addslashes($v);
	extract($DATA);

	if(empty($db_hostname)) $validation['db_hostname'] = true;
	if(empty($db_username)) $validation['db_username'] = true;
	if(empty($db_database)) $validation['db_database'] = true;

	if(empty($validation)) {
	@$link = mysql_connect($db_hostname, $db_username, $db_password);
	if(!$link) {
			$db_failed = true;
	} else {
		if(!mysql_select_db($db_database, $link)) {
			$db_failed = true;
		}
	}	

	if(isset($db_failed)) {

		$validation['db_hostname'] = true;
		$validation['db_username'] = true;
		$validation['db_database'] = true;
		$validation['db_connect'] = true;
	}
	}


	if(empty($fb_api_key)) $validation['fb_api_key'] = true;
	if(empty($fb_app_secret)) $validation['fb_app_secret'] = true;

	if( empty($validation['fb_api_key']) && empty($validation['fb_app_secret']) ) {
		try{
        		$facebook = new Facebook($fb_api_key, $fb_app_secret);
			$info = $facebook->api_client->application_getPublicInfo(null, $fb_api_key);
			//var_dump($info);
	        } catch(Exception $ex) { /*echo $ex->getMessage();*/ $validation['fb_api_key'] = true; $validation['fb_app_secret'] = true; $validation['fb'] = true;}
        }

	if(empty($admin_username)) $validation['admin_username'] = true;
	if(empty($admin_password)) $validation['admin_password'] = true;
	if(empty($site_name)) $validation['site_name'] = true;
	if(empty($site_title)) $validation['site_title'] = true;
	if(empty($developer_key)) $validation['developer_key'] = true;
	if(empty($recaptcha_publickey)) $validation['recaptcha_publickey'] = true;
	if(empty($recaptcha_privatekey)) $validation['recaptcha_privatekey'] = true;


	if(empty($validation)) {
	//installing

		//creating database
		if(!empty($db_password))
			$command = '/usr/bin/mysql -u' . $db_username . ' -p' . $db_password . ' ' . $db_database . ' < ' . $PATH . '/install/scheme.sql';
		else
			$command = '/usr/bin/mysql -u' . $db_username . ' ' . $db_database . ' < ' . $PATH . '/install/scheme.sql';

		echo "Creating database: $command <br/>";
		system($command);
		echo "<br/>";

		//rewriting .htpasswd for admin access
		$command = '/usr/bin/htpasswd -bc ' . $PATH . '/admin6/.htpasswd ' . $admin_username . ' ' . $admin_password;
		echo "Creating .htpasswd: $command <br/>";
		system($command);
		echo "<br/>";

		//rewriting new config.php
		echo "Creating configuration file <br/><br/>";
		$config = file_get_contents($PATH . '/install/config.php');
		$search = array('_SITE_TITLE', '_SITE_NAME', '_RECAPTCHA_PUBLICKEY', '_RECAPTCHA_PRIVATEKEY', '_DEVELOPER_KEY', '_FACEBOOK_API_KEY', '_FACEBOOK_APP_SECRET');
		$replace = array('"'.$site_title.'"', '"'.$site_name.'"', '"'.$recaptcha_publickey.'"', '"'.$recaptcha_privatekey.'"', '"'.$developer_key.'"', '"'.$fb_api_key.'"', '"'.$fb_app_secret.'"');
		$config = str_replace($search,$replace,$config);
		file_put_contents($PATH . '/system/application/config/config.php', $config);

		//rewriting new database.php
		echo "Creating database settings <br/><br/>";
		$config = file_get_contents($PATH . '/install/database.php');
		$search = array('_HOSTNAME', '_USERNAME', '_PASSWORD', '_DATABASE');
		$replace = array('"'.addslashes($db_hostname).'"', '"'.$db_username.'"', '"'.@$db_password.'"', '"'.$db_database.'"');
		$config = str_replace($search,$replace,$config);
		file_put_contents($PATH . '/system/application/config/database.php', $config);

		echo "Installation is completed. You should remove install.php";
		exit;
	}

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Isography</title>

<style type="text/css">
<!--
@import url("styles/layout1.css");
-->

input{border: solid 1px #ccc;}
</style>

</head>
<body>

<div id="layout">
  <div id="header"><img src="images/isologo.gif" alt="" class="logo"/></div>
</div>

<div id="body_container" style="margin: 20px 0px 40px 20px;">


<?php @installform($validation);?>

</div>

<div id="footer">
  <div class="inner_footer"> <img src="images/isography.gif" alt="" />
    <p>&copy; 2009 isography.com, All Right Reserved.</p>
  </div>

</div>

</body>
</html>
