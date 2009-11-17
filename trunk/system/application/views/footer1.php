</div></div>
<div style="height: 100px;"></div>


<div id="footer">
  <div class="inner_footer"> <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/isography.gif" alt="" />
    <p>&copy; 2009 isography.com, All Right Reserved.</p>
  </div>

</div>


<?php
//  <script type="text/javascript" src="http://static.ak.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
?>


  <script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

  <script type="text/javascript">
    var Appapikey = "<?=$this->facebookApiKey?>";

    FB_RequireFeatures(["XFBML"], function()
    {
      FB.Facebook.init(Appapikey, "<?=base_url()?>xd_receiver" , {"ifUserConnected":onConnected, "ifUserNotConnected":onNotConnected});
	//"reloadIfSessionStateChanged":true, 

      //FB.Connect.requireSession();
    });
  </script>



</body>
</html>
