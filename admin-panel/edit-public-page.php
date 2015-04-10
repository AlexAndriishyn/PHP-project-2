<?php
$title = 'Add/edit public page';
require_once('admin-header.php');
if(isSet($_GET['page_id']))
{
	try
	{
		$page_id = $_GET['page_id'];
		$sql = "SELECT * FROM public_pages WHERE page_id = :page_id";
		$cmd = $conn -> prepare($sql);
		$cmd -> bindParam(':page_id', $page_id, PDO::PARAM_INT);
		$cmd -> execute();
		$result = $cmd -> fetchAll();
	}
	catch (Exception $ex)
	{
		mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
		header('location:../error.php');
	}
	foreach ($result as $row)
	{
		$nav_name = $row['nav_name'];
		$header = $row['header'];
		$content = $row['content'];
	}
}

?>

<form method="post" action="save-public-page.php">
	<div>
		<fieldset  class="edit-page">
			<div class="row">
				<label for="header">Navigation link name:</label>
				<input type="text" id="nav_name" name="nav_name" value="<?php if(isSet($nav_name)){ echo $nav_name;} ?>" />
			</div>
			<div class="row">
				<label for="header">Header:</label>
				<input type="text" id="header" name="header" value="<?php if(isSet($header)){ echo $header;} ?>" />
			</div>
			<div class="row">
				<label for="content">Content:</label>
				<textarea id="content" rows="5" cols="40" name="content"><?php if(isSet($content)){ echo $content;} ?></textarea>
			</div>
		</fieldset>
		<div class="save-page">
			<input type="hidden" name="page_id" value="<?php if(!empty($page_id)){ echo $page_id;}  ?>" />
			<input type="submit" value="Confirm"/>
		</div>
	</div>
</form>

<?php
require_once('admin-footer.php');
?>