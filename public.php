<?php 
require_once('public-header.php');

// *Public content selection*

// here, I load the default public page content
// the 1st page (by the alphabet) is taken from the database
if (!isSet($_GET['page_id']))
{
	try
	{
		$sql = "SELECT nav_name, header, content FROM public_pages ORDER BY 1 LIMIT 1;";
		$cmd = $conn -> prepare($sql);
		$cmd -> execute();
		$result = $cmd -> fetchAll();
	} 
	catch (Exception $ex) 
	{
		mail('alex.andriishyn@icloud.com', 'Website error alert', $ex);
		header('location:error.php');
	}
	foreach($result as $row)
	{
		$nav_name = $row['nav_name'];
		$header = $row['header'];
		$content = $row['content'];
	}
	echo '<h1>' . $nav_name . '</h1></div>';
	echo '<h3>' . $header . '</h3><p>' . $content . '</p>';
}
// if user clicks on the control panel link
else if ($_GET['page_id'] == '90')
{	
	echo '<h1>Warning! Entering control panel</h1></div>';
	require_once('admin-login.php');
}
// if user clicks registration in the admin-login page
else if ($_GET['page_id'] == '91')
{
	echo '<h1>Admin registration</h1></div>';
	require_once('registration.php');
}
// if user clicks any other link
else 
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
		mail('alex.andriishyn@icloud.com', 'Website error alert', $ex);
		header('location:error.php');
	}
	foreach($result as $row)
	{
		$nav_name = $row['nav_name'];
		$header = $row['header'];
		$content = $row['content'];
	}
	echo '<h1>' . $nav_name . '</h1></div>';
	echo '<h3>' . $header . '</h3><p>' . $content . '</p>';
}	
require_once('public-footer.php');
?>
