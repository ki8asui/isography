<script>
$(document).ready(function(){

       
     $("span.makeMeAButton").styledButton({  
       
         'orientation' : 'alone', // one of {alone, left, center, right} default is alone  
           
         // action can be specified as a single function to be fired on any click event  
         'action' : {   
                     'on' :function () {  

                        },  

                     'off' : function () {  
                         
                     },

                     'apply' :function () {  
                      $('#setform').submit();
                        }

                 },  
           
         'display' : 'inline-block', // main element's display css, default is inline-block
         'border' : 1
           
           
           
 });

});

</script>


<div id="body_container" style="min-height: 400px;margin-left:100px;">


<?php if(!empty($message)):?>
<?=$message?><br/><br/>
<?php endif;?>


<form id='setform' method="POST" action="http://<?=$_SERVER['HTTP_HOST']?>/member/settings">
 	<input type="hidden" name="submit" value="1" />
	<input type="checkbox" name="email" value="1" <?php if(!empty($subscribe_y_n)):?>checked<?php endif;?>/> Email Messages to my gmail

<br/><br/>

<div id='ifNotLinked' style="display: none;">
<div style="float: left; width: 320px;">
Your account has not been linked with Facebook. To link
the account with Facebook, click <a href="http://<?=$_SERVER['HTTP_HOST']?>/member/facebooklink">here</a>
</div>
<div style="float: left; margin-left: 5px;">
<img src="<?=base_url()?>images/facebook.gif" />
<!--<fb:login-button onlogin="facebook_onlogin();"></fb:login-button>-->
</div>
<div style="clear: left; height: 20px;"></div>
</div>


<div id='ifLinked' style="display: none;">
<input type="checkbox" name="send_pictures_to_facebook" value="1" <?php if(!empty($facebook_pics_y_n)):?>checked<?php endif;?>/> Send pictures to my Facebook Account when I upload them.<br/>
<input type="checkbox" name="send_videos_to_facebook" value="1" <?php if(!empty($facebook_vids_y_n)):?>checked<?php endif;?>/> Send videos to my Facebook Account when I upload them.
<fb:prompt-permission perms="video_upload">Give permission to app to upload video to Facebook</fb:prompt-permission>
<!-- <a href="#" onClick="FB.Connect.showPermissionDialog('video_upload');">Give permission to app to upload video to Facebook</a> -->
<br/>

<a href="http://<?=$_SERVER['HTTP_HOST']?>/member/settings">Unlink your Facebook Account</a>

<br/><br/>
</div>

<span class="makeMeAButton">Save settings</span>

</form>


<script>

function onConnected() {
	$('#ifLinked').css('display', 'block');
	$('#ifNotLinked').css('display', 'none');

}

function onNotConnected() {
	$('#ifLinked').css('display', 'none');
	$('#ifNotLinked').css('display', 'block');
}

</script>


</div></div></div>

<div style="height: 130px; clear: both;"> </div>
