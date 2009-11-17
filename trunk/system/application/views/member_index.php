<div id="body_container">



<?php $i=0; foreach($posts as $post):?>


<?php if($i == 0):?>

<div class="top_section">
<div class="top_curve">

<h4><?=date("F d, Y \a\\t h:i A", strtotime($post['post_date']))?><br/>
<span><?=$post['username']?></span></h4>
<div style="clear: both;"></div>

<?if($post['post_type'] == 'message'):?>

	<?=$post['message']?>

<?elseif($post['post_type'] == 'video'):?>
	<?php foreach($post['videos'] as $video):?>
		<!--<a target="_blank" href="<?=$video['vid_url']?>"><?=$video['vid_url']?></a><br/>-->
		<div style="float: left; margin: 10px 0px 10px 30px; padding: 4px; border: solid 1px #666666; background: #ffffff;"><?php echo preg_replace('/.+?v=(.+)/','<object width="340" height="285"><param name="movie" value="http://www.youtube.com/v/${1}&hl=en&fs=1&rel=0&border=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${1}&hl=en&fs=1&rel=0&border=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="340" height="285"></embed></object>',$video['vid_url']);?></div>
	<?php endforeach;?>
<?elseif($post['post_type'] == 'picture'):?>
	<?php foreach($post['pictures'] as $picture):?>
		<!--<a target="_blank" href="<?=$picture['pic_url']?>"><?=$picture['pic_url']?></a><br/>-->
		<a target="_blank" href="<?php echo preg_replace('/s200/','s640',$picture['pic_url']);?>"><img src="<?=$picture['pic_url']?>" style="padding: 4px; margin: 10px 0px 10px 30px; background: #ffffff; border: solid 1px #666666; float: left;"/></a>
	<?php endforeach;?>
<?endif;?>

</div>

<img src="http://<?=$_SERVER['HTTP_HOST']?>/images/white_lower_bg.gif" alt="" class="left" /> </div>


<?php else:?>

    <div class="middle_section">
      <div class="top_bg">
        <h4><?=date("F d, Y \a\\t h:i A", strtotime($post['post_date']))?><br />
          <span><?=$post['username']?></span></h4>

<?if($post['post_type'] == 'message'):?>

	<?=$post['message']?>

<?elseif($post['post_type'] == 'video'):?>
	<?php foreach($post['videos'] as $video):?>
		<!--<a target="_blank" href="<?=$video['vid_url']?>"><?=$video['vid_url']?></a><br/>-->
		<div style="float: left; margin: 10px 0px 10px 30px; padding: 4px; border: solid 1px #666666; background: #ffffff;"><?php echo preg_replace('/.+?v=(.+)/','<object width="340" height="285"><param name="movie" value="http://www.youtube.com/v/${1}&hl=en&fs=1&rel=0&border=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${1}&hl=en&fs=1&rel=0&border=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="340" height="285"></embed></object>',$video['vid_url']);?></div>
	<?php endforeach;?>
<?elseif($post['post_type'] == 'picture'):?>
	<?php foreach($post['pictures'] as $picture):?>
		<!--<a target="_blank" href="<?=$picture['pic_url']?>"><?=$picture['pic_url']?></a><br/>-->
		<a target="_blank" href="<?php echo preg_replace('/s200/','s640',$picture['pic_url']);?>"><img src="<?=$picture['pic_url']?>" style="padding: 4px; margin: 10px 0px 10px 30px; background: #ffffff; border: solid 1px #666666; float: left;"/></a>

	<?php endforeach;?>
<?endif;?>


    </div>
      <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/video_lower-bg.gif" alt="" class="left" /> </div>


<?php endif;?>

<div style="height: 10px; clear: both;"> </div>
<?php $i++; endforeach;?>      
<?php if(empty($posts)) echo "No results <div style='height: 200px'></div>"; ?>







<?php if($total_pages > 0): ?>

    <div class="listing">
        <fieldset>
        <ul>
          <?php if($page > 1):?><li><a href="#" onclick="$('#page').val(1); $('#page1').val(1); formsubmit('<?=$form?>');">First</a></li><?php endif;?>
          <?php if($page > 1):?><li><a href="#" onclick="$('#page').val(<?=$page-1?>); $('#page1').val(<?=$page-1?>); formsubmit('<?=$form?>');">Prev</a></li><?php endif;?>
          <li><strong>Page <?=$page?> / <?=$total_pages?></strong></li>

          <?php if($page < $total_pages):?><li><a href="#" onclick="$('#page').val(<?=$page+1?>); $('#page1').val(<?=$page+1?>); formsubmit('<?=$form?>');">Next</a></li><?php endif;?>
          <?php if($page < $total_pages):?><li><a href="#" onclick="$('#page').val(<?=$total_pages?>); $('#page1').val(<?=$total_pages?>); formsubmit('<?=$form?>');">Last</a></li><?php endif;?>
          <li class="last">go to</li>
        </ul>
        <input type="text" name="" value="" class="input_text" id='targetpage' />
        <input type="button" onmouseout="this.className=('go_button')" onmouseover="this.className=('go_hover')" name="" value="" class="go_button"  onclick="$('#page').val($('#targetpage').val()); $('#page1').val($('#targetpage').val()); formsubmit('<?=$form?>');" />
        </fieldset>

    </div>
<?php endif;?>


</div>
</div>
</div>


