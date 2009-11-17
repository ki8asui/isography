<div id="content">
<table id="postlist" border="1" cellpadding="1" cellspacing="1">
<tr>
	<td width=""><a href="<?
	if ($csort=='post_date')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/'.$count.'/post_date/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/'.$count.'/post_date';
	}
	?>">Date</a></td>
	<td width=""><a href="<?
	if ($csort=='username')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/'.$count.'/username/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/'.$count.'/username';
	}
	?>">User</a></td>
	<td width=""><a href="<?
	if ($csort=='post_type')
	{
		$cord = ($cord=='ASC')?'DESC':'';
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/'.$count.'/post_type/'.$cord;
	}
	else
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/member/admin/moderatePosts/'.$count.'/post_type';
	}
	?>">Activity</a></td>
	<td width="">&nbsp</td>
	<td width="">&nbsp</td>

</tr>

<?foreach ($query as $item):?>
	<? 
		if ($item['post_type']=='message') {
	?><tr><td><?=$item['post_date'];?></td>
	<td><?=$item['username'];?></td>
	<td><?=substr($item['message'],0,26).'...';?></td>
	<td><?='<a href="http://'.$_SERVER['HTTP_HOST'].'/member/admin/editPost/'.$item['id'].'">edit</a>';?></td>
	<td><a href="http://<?=$_SERVER['HTTP_HOST'].'/member/admin/deletePost/'.$item['id'].'/message';?>">Delete</a></td>
	</tr><? }
		elseif ($item['post_type']=='picture') { foreach ($item['pictures'] as $picture):
	?><tr><td><?=$item['post_date'];?></td>
	<td><?=$item['username'];?></td>
	<td><a target="_blank" href="<?=$picture['pic_url'];?>">picture posted</a></td>
	<td>&nbsp;</td>
	<td><a href="http://<?=$_SERVER['HTTP_HOST'].'/member/admin/deletePost/'.$picture['id'].'/picture';?>">Delete</a></td>
	</tr><? endforeach; }
		elseif ($item['post_type']=='video') { foreach ($item['videos'] as $video):
	?><tr><td><?=$item['post_date'];?></td>
	<td><?=$item['username'];?></td>
	<td><a target="_blank" href="<?=$video['vid_url'];?>">video posted</a></td>
	<td>&nbsp;</td>
	<td><a href="http://<?=$_SERVER['HTTP_HOST'].'/member/admin/deletePost/'.$video['id'].'/picture';?>">Delete</a></td>
	</tr><? endforeach; } ?>	
</tr>
<? endforeach; ?>
</table></div>
<div id="pages"><?=$this->pagination->create_links();?></div>
