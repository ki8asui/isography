<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<script>

function facebook_onlogin() {

	//alert('You have been linked with Facebook!');
	window.location="http://<?=$_SERVER['HTTP_HOST']?>/member/settings";

}


</script>
</head>
<body>










<fb:login-button onlogin="facebook_onlogin()"></fb:login-button> <br/><br/>
<a href="http://<?=$_SERVER['HTTP_HOST']?>/member/settings">Back to settings</a>




  <script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

  <script type="text/javascript">
    var Appapikey = "<?=$this->facebookApiKey?>";

    FB_RequireFeatures(["XFBML"], function()
    {
      FB.Facebook.init(Appapikey, "<?=base_url()?>xd_receiver");

      //FB.Connect.requireSession();
    });
  </script>




</body>
</html>
