<?php include_once('header1.php'); ?>

<script>
$(document).ready(function(){
//if( $('#cbox').attr('checked') ) $('#confirm').removeAttr('disabled'); else $('#confirm').attr('disabled', 'true');
//if( $('#cbox').attr('checked') ) $("span.makeMeAButton").css('display', 'block'); else $("span.makeMeAButton").css('display', 'none');

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
                      location.href='<? echo $authSubUrl;?>';
                        }

                 },  
           
         'display' : 'inline-block', // main element's display css, default is inline-block
         'border' : 1
           
 });

	$("#s").css('display', 'none');

})
</script>


<div id="layout">
  <div id="header"> <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/isologo.gif" alt="" class="logo"/></div>
</div>

<div id="body_container" style="min-height: 400px;margin-left:100px;">


<?php if($subdomain):?>

<table align="center" border="0" cellpadding="0" cellspacing="30"><tr><td valign="top">
<b>Welcome to <?=$site_name?></b><br/><br/><br/>
<img src="http://<?=$_SERVER['HTTP_HOST']?>/images/google.gif" alt="" align="absmiddle" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="makeMeAButton">Sign in with Google Account</span>
</td></tr></table>


<?php else:?>

<table align="center" border="0" cellpadding="0" cellspacing="30"><tr><td valign="top">

<b>Welcome to <?=$this->config->item('site_title')?></b><br/><br/>
How does it work?
<div style="margin: 10px 0px 10px 0px; padding: 4px; border: solid 1px #666666; background: #ffffff;"><object width="340" height="285"><param name="movie" value="http://www.youtube.com/v/7trUHFV6x08&hl=en&fs=1&rel=0&border=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/7trUHFV6x08&hl=en&fs=1&rel=0&border=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="340" height="285"></embed></object></div>

</td><td valign="top">

<b>Create an <?=$this->config->item('site_title')?> site</b><br/><br/><br/><br/>
<textarea readonly="true" style="width: 500px;border:solid 1px #666666; 
height: 200px; margin: 
0px 0px 20px 0px;"><?php include_once('tos.txt');?></textarea>


<input id='cbox' type="checkbox" onChange="if( this.checked ) $('span.makeMeAButton').css('display','block'); else $('span.makeMeAButton').css('display', 'none');" /> I agree with Terms and Conditions<br/><br/>
<img src="http://<?=$_SERVER['HTTP_HOST']?>/images/google.gif" alt="" align="absmiddle" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span id='s' class="makeMeAButton">Sign in with Google Account</span>

</td></tr></table>


<?php endif;?>

</div>

</div>

<?php include_once('footer.php'); ?>
