

<?php if (!empty($query))
{ ?>
The following peolpe are waiting for approval:<br/><br/>

<form method="POST" action="http://<?=$_SERVER['HTTP_HOST'];?>/member/admin/appQueue">
<input type="hidden" name="action" value="updatemembers">
<table id="postlist" border="1" cellpadding="1" cellspacing="1">
<tr>
	<th width=""><a href="<?
	if ($csort=='username')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/'.$count.'/username/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/'.$count.'/username';
	}
	?>">Name</a></td>
	<th width=""><a href="<?
	if ($csort=='email')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/'.$count.'/email/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/'.$count.'/email';
	}
	?>">Email</a></td>
	<th width=""><a href="<?
	if ($csort=='created')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/'.$count.'/created/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/appQueue/'.$count.'/created';
	}
	?>">Application Date</a></td>
	<th width="">Approve</td>
	<th width="">Deny</td>
</tr>
<? foreach ($query as $item): ?>
<tr>
	<td><?=$item['username'];?></td>
	<td><?=$item['email'];?></td>
	<td><?=($item['created'])?$item['created']:'&nbsp;';?></td>
	<td><input type="radio" name="radio<?=$item['user_id'];?>" value="approve" /></td>
	<td><input type="radio" name="radio<?=$item['user_id'];?>" value="deny" /></td>
</tr>
<? endforeach; ?>
</table>
<?=$this->pagination->create_links();?>
<br/><input type="submit" value="Submit" />
<?} else { ?>
No new members!
<? }
if (isset($changelist)) {?>
<br/><h3>Changes:</h3>
<? foreach ($changelist as $im): echo $im.'<br/>'; endforeach;}?>
</form>
