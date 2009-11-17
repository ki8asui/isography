<div style="clear: both; height: 100px;"></div>

<a href="http://<?=$_SERVER['HTTP_HOST'];?>/member/admin/appQueue">Application Queue</a> | <a href="http://<?=$_SERVER['HTTP_HOST'];?>/member/admin/moderatePosts">Moderate</a> | <a href="http://<?=$_SERVER['HTTP_HOST'];?>/member/admin/members">Members</a> |

<select onchange="location.replace($(this).val());" style="border: solid 1px #666666;">
<?php foreach($sites as $s):?>
<option value="http://<?=$s['subdomain']?>.<?=$this->conf['site_name']?>" <?php if($this->subdomainId == $s['id'])echo "selected"?> ><?=$s['subdomain']?>.<?=$this->conf['site_name']?></option>
<?php endforeach;?>
</select>



<br/><br/>