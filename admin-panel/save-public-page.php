<?php
	require_once('admin-header.php');
	$nav_name = $_POST['nav_name'];
	$header = $_POST['header'];
	$content = $_POST['content'];
	// this page is intended to create and to update a page
	// if this is an attempt to edit the previously stored page then we update the database
	if (!empty($_POST['page_id']))
	{
		$page_id = $_POST['page_id'];
		try{
			$sql = "UPDATE public_pages SET nav_name = :nav_name, header = :header, content = :content WHERE page_id = :page_id";
			$cmd = $conn -> prepare($sql);
			$cmd -> bindParam(':nav_name', $nav_name, PDO::PARAM_STR, 40);
			$cmd -> bindParam(':header', $header, PDO::PARAM_STR, 100);
			$cmd -> bindParam(':content', $content, PDO::PARAM_STR, 1024);
			$cmd -> bindParam(':page_id', $page_id, PDO::PARAM_INT);
			$cmd -> execute();
			$conn = null;
		} catch (Exception $ex) {
			mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
			header('location:../error.php');
		}
		header('location:edit-public-page.php');
	}
	// if this a new page then we insert a new record in the database
	else
	{
		try
		{
			$sql = "INSERT INTO public_pages(nav_name, header, content) VALUES(:nav_name, :header, :content)";
			$cmd = $conn -> prepare($sql);
			$cmd -> bindParam(':nav_name', $nav_name, PDO::PARAM_STR, 40);
			$cmd -> bindParam(':header', $header, PDO::PARAM_STR, 40);
			$cmd -> bindParam(':content', $content, PDO::PARAM_STR, 1024);
			$cmd -> execute();
			$conn = null;
		} catch (Exception $ex) {
			mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
			header('location:../error.php');
		}
		header('location:edit-public-page.php');
	}
require_once('admin-footer.php');
?>
