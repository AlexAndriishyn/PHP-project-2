<?php
$title = 'Edit logotype';
require_once('admin-header.php');
// Area to upload site logo
?>
<form method="post" action="upload-logo.php" enctype="multipart/form-data">
	<fieldset>
		<div class="row">
			<label for="upload">Select file:</label>
			<input type="file" name="upload" required/>
		</div>
		<div class="row">
			<label for="title">Enter title:</label>
			<input type="text" name="image_title" required/>
		</div>
		<div class="row">
			<label for="title">Enter width:</label>
			<input type="text" name="image_width" required/>
			<sub>*100 max</sub>
		</div>
		<div class="row">
			<label for="title">Enter height:</label>
			<input type="text" name="image_height" required/>
			<sub>*100 max</sub>
		</div>
	</fieldset>
	<div class="submit-admin">
		<input type="submit" value="Upload" />
	</div>
</form>
<?php
require_once('admin-footer.php');
?>