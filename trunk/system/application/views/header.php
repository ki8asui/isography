<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$this->config->item('site_title')?></title>
<style type="text/css">
<!--
@import url("/styles/layout.css");
@import url("/styles/styledButton.css");
-->
</style>

  <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/styles/thickbox.css" type="text/css" media="screen" />
  <link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.all.css" rel="stylesheet" />

  <script type="text/javascript" src="http://jqueryui.com/latest/jquery-1.3.2.js"></script>
  <script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.core.js"></script>
  <script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.datepicker.js"></script>
  <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/scripts/jquery-blockui.js"></script>
  <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/scripts/ajaxfileupload.js"></script>
  <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/scripts/jquery.form.js"></script>
  <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/scripts/thickbox.js"></script>
  <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/scripts/jquery.styledButton.js"></script>


<style>

/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(<?=base_url()?>images/calendar.png) no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}

</style>


<script>
$(document).ready(function(){

	var options = { 
		target:        '#content',   // target element(s) to be updated with server response 
		beforeSubmit:  form_bs ,  // pre-submit callback 
		success:       formsuccess ,  // post-submit callback 
 
		// other available options: 
		//url:       url         // override for form's 'action' attribute 
		//type:      type        // 'get' or 'post', override for form's 'method' attribute 
		//dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		//clearForm: true        // clear all form fields after successful submit 
		//resetForm: true        // reset the form after successful submit 
 
		// $.ajax options can be used here too, for example: 
		//timeout:   3000 
	};
	

	// bind form using 'ajaxForm' 
	$('#fform').ajaxForm(options);
	$('#sform').ajaxForm(options);

});


function form_bs() {
	$.blockUI({message:null});
}

function formsuccess() {
	$.unblockUI({message:null});
}

function toggleActivityTab(){
	$('#activity_tab').addClass('current');
	$('#activity_tab').html('<span>Activity</span>');
	$('#admin_tab').removeClass('current');
	$('#admin_tab').html("<a href=\"http://<?=$_SERVER['HTTP_HOST']?>/member/admin\"><span>Admin</span></a>");
	$('#settings_tab').removeClass('current');
	$('#settings_tab').html("<a href=\"http://<?=$_SERVER['HTTP_HOST']?>/member/settings\"><span>Settings</span></a>");
}

function formsubmit(formId){
	$('#' + formId).submit();
	toggleActivityTab();
}

function formsubmit_(formId){
	$('#page').val(1);
	$('#page1').val(1);
	$('#' + formId).submit();
	toggleActivityTab();
}

</script>


<script type="text/javascript" src="<?=base_url().'scripts/tiny_mce/tiny_mce.js';?>"></script>
<script type="text/javascript">
tinyMCE.init(
{
	mode : "textareas",
	theme : "simple"
}
); 
</script>

  
</head>
<body>
