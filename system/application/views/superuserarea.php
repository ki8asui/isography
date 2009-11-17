<div id="sitelist">
<table border="1" cellpadding="1" cellspasing="0">
<tr>
<th width=""><a href="<?
	if ($csort=='subdomain')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/subdomain/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/subdomain';
	}
	?>">Subdomain</a></th>
<th width=""><a href="<?
	if ($csort=='name')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/name/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/name';
	}
	?>">Name</a></th>
<th width=""><a href="<?
	if ($csort=='created')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/created/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/created';
	}
	?>">Created</a></th>
<th width=""><a href="<?
	if ($csort=='email')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/email/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/email';
	}
	?>">Owner Email</a></th>
<th width=""><a href="<?
	if ($csort=='username')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/username/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/username';
	}
	?>">Owner</a></th>
<th width=""><a href="<?
	if ($csort=='active_y_n')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/active_y_n/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/admin6/index/'.$count.'/active_y_n';
	}
	?>">Status</a></th>
<th width="">&nbsp;</th>
</tr>
<? foreach ($query as $item): ?>
<tr>
<td width=""><?=($item['subdomain'])?$item['subdomain']:'&nbsp;';?></td>
<td width=""><?=$item['name'];?></td>
<td width=""><?=$item['created'];?></td>
<td width=""><?=$item['email'];?></td>
<td width=""><?=$item['username'];?></td>
<td width=""><?=($item['active_y_n']==1) ? 'active' : 'unplugged';?></td>
<td width=""><a href="<?='http://'.$_SERVER['HTTP_HOST'].'/admin6/siteadmin/'.$item['subdomain'];?>">admin</a> / <a href="<?=site_url('admin6').'/'.(($item['active_y_n']==1)?'unplug':'activate').'/'.$item['subdomain'];?>"><?=($item['active_y_n']==1)?'unplug':'activate';?></a> / <a href="<?=site_url('admin6/destroy').'/'.$item['subdomain'];?>">destroy</a></td>
</tr>
<? endforeach ?>
</table>
<br/>
<?=$this->pagination->create_links();?>
</div>