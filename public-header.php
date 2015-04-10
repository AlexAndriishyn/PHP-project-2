<?php ob_start(); 
require_once('db.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Public website</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div class="container">
		<header role="banner">
				<?php 
					// fetching our logo from the database
					try
					{
						$sql = "SELECT * FROM pictures WHERE image_id = 1";
						$cmd = $conn -> prepare($sql);
						$cmd -> execute();
						$result = $cmd -> fetchAll();
						echo '<nav role="navigation">';
						foreach ($result as $row)
						{	
							echo '<img class="logo" src="images/' . $row['image_name']
									. '" title="' . $row['image_title']
									. '" width="' . $row['image_width']
									. '" height="'. $row['image_height'] 
									. '"/>';
						}
					} 
					catch (Exception $ex) 
					{
						mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
						header('error.php');
					}
				?>
			<?php
				// filling the navigation panel
				try
				{
					$sql = "SELECT page_id, nav_name FROM public_pages ORDER BY 2;";
					$cmd = $conn -> prepare($sql);
					$cmd -> execute();
					$result = $cmd -> fetchAll();
					
					echo '<ul>';
					foreach ($result as $row)
					{	
						echo '<li><a href="public.php?page_id=' . $row['page_id'] . '">' . $row['nav_name'] . '</a></li>';
					}
					
					echo '<li><a href="/comp1006/custom-site-local/public.php?page_id=90">Control panel</a></li></ul></nav>';
				} 
				catch (Exception $ex) 
				{
					mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
					header('error.php');
				}
			?>
		</header>
		<?php
		echo '<div class="main-container">';
		echo '<div class="main-panel">';
		?>