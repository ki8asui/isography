<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
</head>
<body>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

<fb:login-button></fb:login-button>

<script type="text/javascript">
	var Appapikey = "<?=$this->facebookApiKey?>";
	FB.init(Appapikey, "xd_receiver.htm");
</script>

</body>
</html>
