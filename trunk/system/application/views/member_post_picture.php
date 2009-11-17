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
	success:       success   // post-submit callback 
 
};


$('#post_picture').ajaxForm(post_options);


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

<form id='post_picture' method="POST" enctype="multipart/form-data" action="http://<?=$_SERVER['HTTP_HOST']?>/member/uploadpicture">
<input type="file" name="image" /> &nbsp;&nbsp;
<select name="album_id" id='input'>
	<option value="">Choose Web Album</option>
	<?php foreach($albums as $v):?>
	<option value="<?=$v['id']?>"><?=$v['name']?></option>
	<?php endforeach;?>
</select>
<br/><br/>
Or enter the name of a new Web Album: <input  id='input' type="text" name="new_album_name" /><br/><br/>
<img src="<?=base_url()?>images/picasa20x20.png" border="0" align="absmiddle" /> &nbsp;&nbsp;
<input type="submit" id='input' value="Save" />
</form>


</div>
