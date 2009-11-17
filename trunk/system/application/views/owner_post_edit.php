<h3> Edit post #<?=$id;?></h3>
<form method="post" action="http://<?=$_SERVER['HTTP_HOST'];?>/member/admin/moderatePosts">
<? if($query['post_type']=='message')
{?>
<input type="hidden" name="id" value="<?=$id;?>" />
<input type="hidden" name="action" value="update" />
<textarea name="message" cols="40" rows="4"><?=$query['message'];?></textarea>
<br/><input type="submit" value="submit" />
<?}
elseif ($query['post_type']=='picture')
{?>

<?}
elseif ($query['post_type']=='video')
{?>

<?}?>
</form>
