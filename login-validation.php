<?php 
require_once('public-header.php');
$login = $_POST['login'];
$h_password = hash('sha512', $_POST['password']);
	try
	{
		$sql = "SELECT admin_id FROM administrators WHERE email = :login AND password = :h_password";
		$cmd = $conn -> prepare($sql);
		$cmd -> bindParam(':login', $login, PDO::PARAM_STR, 60);
		$cmd -> bindParam(':h_password', $h_password, PDO::PARAM_STR, 128);
		$cmd -> execute();
		$result = $cmd -> fetchAll();
		$count = $cmd -> rowCount();
		
		if ($count > 0)
		{
			session_start();
			foreach($result as $row)
			{
				$_SESSION['admin_id'] = $row['admin_id'];
			}
			header('location:admin-panel/display-admin-list.php');
		}
		else
		{
			echo '</div><h3 class="error">Wrong login and/or password. Click <a href="public.php">here</a> to go back to the home page</h3>';
		}
		$conn = null;
	} catch (Exception $ex) {
		mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
		header('location:error.php');
	}
	
require_once('public-footer.php');
?>
