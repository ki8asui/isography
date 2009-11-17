<?php include_once('header1.php'); ?>


<script>
$(document).ready(function(){

    // limit the selector to only what you know will be buttons :)  
       
     $("span.makeMeAButton").styledButton({  
       
         'orientation' : 'alone', // one of {alone, left, center, right} default is alone  
           
         // action can be specified as a single function to be fired on any click event  
         'action' : {   
                     'on' :function () {  

                        },  

                     'off' : function () {  
                         
                     },

                     'apply' :function () {  
                      $('#regform').submit();
                        }

                 },  
           
         'display' : 'inline-block', // main element's display css, default is inline-block
         'border' : 1
           
           
           
 });

});

</script>



<div id="layout">
  <div id="header"> <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/isologo.gif" alt="" class="logo"/></div>
</div>


<div id="body_container" style="min-height: 400px; margin-left:100px;">



<form id='regform' method="POST" action="<?=$this->config->item('base_url')?>site/create" style="padding: 50px 0px 0px 150px;">

<div style="color: red;">
<?php if(!empty($message)):?>
<?=$message?><br/><br/>
<?php endif;?>
</div>

Enter the captcha<br/><br/>
<?=$captcha?>
<br/><br/>
Choose a name for your site: <input style="border: solid 1px #666666;" type="text" name="site_name" value="<?=$site_name?>"><br/><br/>
Choose a url for your site: <input style="border: solid 1px #666666;" type="text" name="site_url" size="9" value="<?=$site_url?>"> .<?=$this->conf['site_name'];?><br/><br/>
<?php if(!empty($ask_name)):?>
Your Firstname: <input style="border: solid 1px #666666;" type="text" name="firstname" value="<?=$firstname?>"><br/><br/>
Your Lastname: <input style="border: solid 1px #666666;" type="text" name="lastname" value="<?=$lastname?>"><br/><br/>
<input type="hidden" name="ask_name" value="1">
<?php endif;?>
<span class="makeMeAButton">Create <!--my Pep -->Site</span>
</form>


</div>

<?php include_once('footer.php'); ?>