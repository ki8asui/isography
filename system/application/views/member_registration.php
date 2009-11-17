<?php include_once('header1.php'); ?>

<script>
$(document).ready(function(){

    // limit the selector to only what you know will be buttons :)  
     $("span").css({  
          'padding' : '3px 20px',  
          'font-size' : '12px',  
     });  
       
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


<div id="body_container"  style="min-height: 400px;margin-left:100px;">

<div style="padding: 50px;">

<?php if(!empty($message)):?>
<?=$message?><br/><br/>
<?php endif;?>


You are not a member of <?=$site_name?>.
If you would like to apply a membership, fill the form and click the button below. <br/><br/>

<form id='regform' method="POST" action="http://<?=$_SERVER["HTTP_HOST"]?>/member/create">

Email: <?=$email?><br/><br/>

<?php if(!empty($ask_name)):?>
Your Firstname: <input type="text" name="firstname" value="<?=$firstname?>"><br/><br/>
Your Lastname: <input type="text" name="lastname" value="<?=$lastname?>"><br/><br/>
<input type="hidden" name="ask_name" value="1">
<?php endif;?>

<span class="makeMeAButton">Apply</span>

</form>
</div>

</div>

<?php include_once('footer.php'); ?>