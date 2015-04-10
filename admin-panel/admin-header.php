<?php ob_start();
// Every admin page requires authentication check and database connectivity
require_once('auth-check.php'); 
require_once('../db.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Control panel</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
	</head>
	<body>
		<div class="container">
		<header role="banner">
			<?php 
				// Fetching our logo from the database
				try
				{
					$sql = "SELECT * FROM pictures WHERE image_id = 1";
					$cmd = $conn -> prepare($sql);
					$cmd -> execute();
					$result = $cmd -> fetchAll();
					echo '<nav role="navigation">';
					foreach ($result as $row)
					{	
						echo '<img class="logo" src="../images/' . $row['image_name']
								. '" title="' . $row['image_title']
								. '" width="' . $row['image_width']
								. '" height="'. $row['image_height'] 
								. '"/>';
					}
				} 
				catch (Exception $ex) 
				{
					mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
						header('../error.php');
				}
				// Filling the navigation bar
				echo '<h3>Click to edit</h3>';
				try
				{
					$sql = "SELECT page_id, nav_name FROM public_pages ORDER BY 2;";
					$cmd = $conn -> prepare($sql);
					$cmd -> execute();
					$result = $cmd -> fetchAll();
					echo '<ul>';
					foreach ($result as $row)
					{	
						echo '<li><a href="edit-public-page.php?page_id=' . $row['page_id'] . '">' . $row['nav_name'] 
								. '</a><a href="delete-record.php?page_id=' . $row['page_id'] 
								. '"onclick="return confirm(\'Are you sure you want to delete this page?\');">'
								. '<img class="deleteImage" src="../images/delete.png" width="16" height="16" title="Delete this page" />'
								. '</a></li>';
					}
				} 
				catch (Exception $ex) 
				{
					mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
					header('../error.php');
				}
				echo '</header>';
				// Filling admin panel
				echo '<div class="main-container"><main role="main">';
				echo '<div class="main-panel"><h1>' . $title . '</h1><span><a href="edit-public-page.php">Add new page</a>'
						. '<a href="edit-logo.php">Edit logotype</a>'
						. '<a href="display-admin-list.php">Edit administrator</a>'
						. '<a href="logout.php">Logout</a>'
					. '</span></div>';
			?>