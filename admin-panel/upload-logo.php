<?php
	require_once('admin-header.php');
	$image_name = $_FILES['upload']['name'];
	$tmp_name = $_FILES['upload']['tmp_name'];
	$final_name = session_id() . '_' . $image_name;
	move_uploaded_file($tmp_name, "../images/$final_name");
	$image_title = $_POST['image_title'];
	$image_width = $_POST['image_width'];
	$image_height = $_POST['image_height'];
	
	// Making sure that the logo dimensions are acceptable
	if ($image_width > 100)
	{
		$image_width = 100;
	}
	
	if ($image_height > 100)
	{
		$image_height = 100;
	}
	
	// I decided to store all pictures (logo and pub images) in the same table. The logo will have an id of 1.
	$image_id = 1;
	$stored = false;
	// Verifying if a logo is already stored in the database...
	try
	{
		$sql = "SELECT * FROM pictures WHERE image_id = :image_id";
		$cmd = $conn -> prepare($sql);
		$cmd -> bindParam(':image_id', $image_id, PDO::PARAM_INT);
		$cmd -> execute();
		$result = $cmd -> fetchAll();
		$count = $cmd -> rowCount();
		// Here, $conn is not closed, because we still have a query to run
		if ($count > 0)
		{
			$stored = true;
		}
	} catch (Exception $ex) {
		mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
		echo $ex;
	}
	
	// if we have the logo in our database
	if($stored)
	{
		try
		{
			$sql = "UPDATE pictures SET image_name = :final_name, image_title = :image_title, "
					. "image_width = :image_width, image_height = :image_height "
					. "WHERE image_id = :image_id";
			$cmd = $conn -> prepare($sql);
			$cmd -> bindParam(':final_name', $final_name, PDO::PARAM_STR, 255);
			$cmd -> bindParam(':image_title', $image_title, PDO::PARAM_STR, 100);
			$cmd -> bindParam(':image_width', $image_width, PDO::PARAM_INT);
			$cmd -> bindParam(':image_height', $image_height, PDO::PARAM_INT);
			$cmd -> bindParam(':image_id', $image_id, PDO::PARAM_INT);
			$cmd -> execute();
			$conn = null;
			header('location:edit-logo.php');
		} catch (Exception $ex) {
			mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
			echo $ex;
		}
	}
	// if this is a first attempt to insert a logo
	else
	{
		try
		{
			$sql = "INSERT INTO pictures(image_name, image_title, image_width, image_height) "
					. "VALUES(:final_name, :image_title, :image_width, :image_height)";
			$cmd = $conn -> prepare($sql);
			$cmd -> bindParam(':final_name', $final_name, PDO::PARAM_STR, 255);
			$cmd -> bindParam(':image_title', $image_title, PDO::PARAM_STR, 100);
			$cmd -> bindParam(':image_width', $image_width, PDO::PARAM_INT);
			$cmd -> bindParam(':image_height', $image_height, PDO::PARAM_INT);
			$cmd -> execute();
			$conn = null;
			header('location:edit-logo.php');
		} catch (Exception $ex) {
			mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
			header('location:../error.php');
		}
	}
	require_once('admin-footer.php');
?>

