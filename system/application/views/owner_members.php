
<? if ($query) {?>
<form method="POST" action="http://<?=$_SERVER['HTTP_HOST'];?>/member/admin/members">
<input type="hidden" name="action" value="updatemembers">
<table id="postlist" border="1" cellpadding="1" cellspacing="1">
<tr>
	<th width=""><a href="<?
	if ($csort=='username')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/members/'.$count.'/username/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/members/'.$count.'/username';
	}
	?>">Name</a></td>
	<th width=""><a href="<?
	if ($csort=='email')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/members/'.$count.'/email/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/members/'.$count.'/email';
	}
	?>">Email</a></td>
	<th width="">Remove</td>
</tr>
<? foreach ($query as $item): ?>
<tr>
	<td><?=$item['username'];?></td>
	<td><?=$item['email'];?></td>
	<td><input type="checkbox" name="rem<?=$item['user_id'];?>" value="remove" /></td>
</tr>
<? endforeach; ?>
</table>
<?=$this->pagination->create_links();?>
<br/><input id='input' type="submit" value="Submit" />
<?} else { ?>
No members!
<? }
if (isset($changelist)) {?>
<br/><h3>Changes:</h3>
<? foreach ($changelist as $im): echo $im.'<br/>'; endforeach;}?>
</form>
