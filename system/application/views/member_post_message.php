<div style="display: none;" id='load_indicator'><img src="<?=base_url()?>images/load_indicator.gif" border="0" align="absmiddle" /> Saving...</div>

<div id='post_block'>

<br/>

<?php if(!empty($message)):?>
<?=$message?><br/>
<?php endif;?>


<form id='post_message' method="POST" action="http://<?=$_SERVER['HTTP_HOST']?>/member/addmessage">
<textarea name="message" cols="60" rows="5" style="width: 200px;"> </textarea><br/>
<input id='input' type="submit" value="Submit" />
</form>


</div>



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


$('#post_message').ajaxForm(post_options);


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
