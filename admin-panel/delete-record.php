<?php 
ob_start();
require_once('auth-check.php');
require_once('../db.php');

// If it is a "delete-admin" operation
if(isSet($_GET['admin_id']))
{
	$admin_id = $_GET['admin_id'];
	try
	{
		$sql = "DELETE FROM administrators WHERE admin_id = :admin_id";
		$cmd = $conn -> prepare($sql);
		$cmd -> bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
		$cmd -> execute();
		$conn = null;
		header('location:display-admin-list.php');
	}
	catch (Exception $ex)
	{
		mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
		header('location:../error.php');
	}
}

// If it is a "delete-page" operation
if (isSet($_GET['page_id']))
{
	$page_id = $_GET['page_id'];
	try
	{
		$sql = "DELETE FROM public_pages WHERE page_id = :page_id";
		$cmd = $conn -> prepare($sql);
		$cmd -> bindParam(':page_id', $page_id, PDO::PARAM_INT);
		$cmd -> execute();
		$conn = null;
		header('location:display-admin-list.php');
	}
	catch (Exception $ex)
	{
		mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
		header('location:../error.php');
	}
}

ob_flush(); 
?>
