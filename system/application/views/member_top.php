<?php include_once('header.php');?>


<script>

function facebook_onlogin() {

	//alert('You have been linked with Facebook!');
	window.location="http://<?=$_SERVER['HTTP_HOST']?>/member/settings";

}


</script>




<?/*
       <!-- jQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        
        <!-- required plugins -->
		<script type="text/javascript" src="<?=base_url()?>scripts/date.js"></script>
		<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.min.js"></script><![endif]-->
        
        <!-- jquery.datePicker.js -->
		<script type="text/javascript" src="<?=base_url()?>scripts/jquery.datePicker.js"></script>
        
        <!-- datePicker required styles -->

		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>styles/datePicker.css">
*/?>

		
        <!-- page specific scripts -->
		<script type="text/javascript" charset="utf-8">
            $(function()
            {
				Date.firstDayOfWeek = 0;
				Date.format = 'mm/dd/yyyy';
				//$('.date-pick').datePicker().val(new Date().asString()).trigger('change');
				//$('.date-pick').datePicker();
				$('#date1').datepicker().val(<?php if($date1):?>'<?=$date1?>'<?php endif;?>);
				$('#date2').datepicker().val(<?php if($date2):?>'<?=$date2?>'<?php endif;?>);

            });
		</script>



<div id="layout">
  <div id="header"> <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/logo.gif" alt="" class="logo"/>
    <form id='sform' action="http://<?=$_SERVER['HTTP_HOST']?>/member/ajax_getposts/" method="POST">
    <input type='hidden' id='page1' name="page" />

      <fieldset>
      <label>Welcome, <span><?=$this->username?></span> &nbsp;<a href="http://<?=$_SERVER['HTTP_HOST']?>/member/logout">Logout</a></label>
      <div class="row">
        <input type="button" onclick="formsubmit_('sform')" onmouseout="this.className=('search_button')" onmouseover="this.className=('search_hover')"  value="" class="search_button" />
        <input type="text" value="" name="searchtext" class="input_text" />
      </div>
      </fieldset>

    </form>
    <div class="lower_header">
      <div class="tabs">
        <ul>

	<?php if(!isset($section)):?>
          <li id='activity_tab' class="current"><span>Activity</span></li>
	<?else:?>
          <li id='activity_tab'><a href='http://<?=$_SERVER['HTTP_HOST']?>/member/'><span>Activity</span></a></li>
	<?php endif;?>

	<?php if( isset($section) && $section == 'settings'):?>
          <li id='settings_tab' class="current"><span>Settings</span></li>
	<?else:?>
          <li id='settings_tab'><a href="http://<?=$_SERVER['HTTP_HOST']?>/member/settings"><span>Settings</span></a></li>
	<?php endif;?>

	<?php if(!empty($this->isSiteOwner)):?>
	<?php if( isset($section) && $section == 'admin'):?>
          <li id='admin_tab' class="current"><span>Admin</span></li>
	<?else:?>
          <li id='admin_tab'><a href="http://<?=$_SERVER['HTTP_HOST']?>/member/admin"><span>Admin</span></a></li>
	<?php endif;?>
	<?php endif;?>

        </ul>
      </div>

      <h4><?=$this->site_name?></h4>
      <p>You are at:</p>
      <div class="boxes">
        <div class="grey_box">
        <form action="http://<?=$_SERVER['HTTP_HOST']?>/member/ajax_getposts/" method="POST" id='fform'>
            <fieldset>
            <h5>Show post between:</h5>

            <div class="cols">
              <div class="row">
		<input type="text" name="date1" id="date1" class="date-pick input_box" />
                <!--<a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/images/pink_box.gif" alt="" class="pinkbox" /></a>--> </div>
              <small>and</small>
              <div class="row no_margin">
		<input type="text" name="date2" id="date2" class="date-pick input_box" />
                <!--<a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/images/pink_box.gif" alt="" class="pinkbox" /></a>--> </div>

            </div>
            <input style="position: relative; left: -23px;" type="button" onclick="formsubmit_('fform');" onmouseout="this.className=('find')" onmouseover="this.className=('find_hover')" name="" class="find" value="" />
            </fieldset>
        </div>
        <div class="white_box">
          <div class="white_top_curve" style="padding-left: 19px;">
		<input type='hidden' id='page' name="page" />
		
              <fieldset>

              <label>Hide:</label>
              <div class="contents">
                <div class="top_bg">
                  <input onchange="formsubmit_('fform');" type="checkbox" name="hide_messages" value="1" class="check_box" <?php if($hide_messages):?>checked<?php endif;?> />
                  <p>Message</p>
                  <input onchange="formsubmit_('fform');" type="checkbox" name="hide_pictures" value="1" class="check_box" <?php if($hide_pictures):?>checked<?php endif;?> />
                  <p class="video">Pictures</p>

                  <input onchange="formsubmit_('fform');" type="checkbox" name="hide_videos" value="1" class="check_box" <?php if($hide_videos):?>checked<?php endif;?> />
                  <p class="none">Videos</p>
                </div>
                <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/check_lower_curve.gif" alt="" class="left" /> </div>
              <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/border.gif" alt="" class="border" />
              <label class="post">Post a:</label>

              <a title="Post a message" href="http://<?=$_SERVER['HTTP_HOST']?>/member/postmessage/?height=200&width=300" class="thickbox"><input name="button" type="button" class="message" onmouseover="this.className=('message_hover')" onmouseout="this.className=('message')" value=""/></a>
              <a title="Post a picture" href="http://<?=$_SERVER['HTTP_HOST']?>/member/postpicture/?height=160&width=400" class="thickbox"><input type="button" onmouseout="this.className=('picture')" onmouseover="this.className=('picture_hover')"  value="" class="picture" /></a>
              <a title="Post a video" href="http://<?=$_SERVER['HTTP_HOST']?>/member/postvideo/?height=120&width=400" class="thickbox"><input type="button" onmouseout="this.className=('videos')" onmouseover="this.className=('videos_hover')" name="" value="" class="videos" /></a>

              </fieldset>
          </form>
          </div>


          <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/white_lower_curve.gif" class="left" alt="" /> </div>
        <span style="clear:both"></span> </div>
      <span class="clear"></span> </div>

    <span class="clear"></span> </div>
  <span class="clear"></span>



<?php if(!empty($this->flashMsg)):?>
<!--<div style="color: red;  width: 550px;">
	<?=$this->flashMsg?>
</div>-->
<?php endif;?>


<div id='content'>
