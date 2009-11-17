<?php include_once('header1.php'); ?>

<div id="layout">
  <div id="header"> <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/isologo.gif" alt="" class="logo"/></div>
</div>


<div id="body_container" style="min-height: 400px; ">

<div style="padding: 50px;">
Congratulation! <br/><br/> 
<a href="http://<?=$site_url?>.<?=$this->conf['site_name'];?>"><?=$site_url?>.<?=$this->conf['site_name'];?></a> have been created
</div>

</div>

<?php include_once('footer.php'); ?>