<script type="text/javascript">
tinyMCE.init(
{
	mode : "textareas",
	theme : "simple"
}
); 


var post_options = { 
	target:        '#post_block',

	beforeSubmit:  beforesubmit ,  // pre-submit callback 
	success:       success  // post-submit callback 
 
};


$('#post_video').ajaxForm(post_options);


function beforesubmit() {
	$('#load_indicator').css('display', 'block');
}

function success() {
	$('#load_indicator').css('display', 'none');
	$('#content').load("http://<?=$_SERVER['HTTP_HOST']?>/member/ajax_getposts/");
	toggleActivityTab();
	$('input[class=check_box]').attr('checked', false);
	setTimeout("tb_remove()", 1000);
}


</script>


<div style="display: none;" id='load_indicator'><img src="<?=base_url()?>images/load_indicator.gif" border="0" align="absmiddle" /> Saving...</div>


<div id='post_block'>

<br/>

<?php if(!empty($msg)):?>
<?=$msg?><br/><br/>
<?php endif;?>


<form id='post_video' method="POST" enctype="multipart/form-data" action="http://<?=$_SERVER['HTTP_HOST']?>/member/uploadvideo">
<img src="<?=base_url()?>images/youtube.gif" border="0" align="absmiddle" /> &nbsp;&nbsp;
<input type="file" name="image" /><br/>
<input id='input' style="margin-left: 105px; margin-top: 10px;" type="submit" value="Send" />
</form>


</div>