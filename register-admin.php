<?php 
	require_once('public-header.php');
	echo '</div>';
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$c_password = $_POST['c_password'];
	$ok = true;
	
	// Password check
	if ($password !== $c_password)
	{
		echo '<h3>Passwords do not match</h3>';
		$ok = false;
	}
	
	// this page is intended to create a new admin user and update an already existing one
	// if this is an attempt to edit the previously stored admin user, then ...
	if (isSet($_POST['admin_id']))
	{
		if ($ok)
		{
			require_once('admin-panel/auth-check.php');
			$admin_id = $_POST['admin_id'];
			// Hashing the password
			$h_password = hash('sha512', $password);
			try{
				$sql = "UPDATE administrators SET firstName = :firstName, lastName = :lastName, email = :email, password = :h_password WHERE admin_id = :admin_id";
				$cmd = $conn -> prepare($sql);
				$cmd -> bindParam(':firstName', $firstName, PDO::PARAM_STR, 40);
				$cmd -> bindParam(':lastName', $lastName, PDO::PARAM_STR, 40);
				$cmd -> bindParam(':email', $email, PDO::PARAM_STR, 60);
				$cmd -> bindParam(':h_password', $h_password, PDO::PARAM_STR, 128);
				$cmd -> bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
				$cmd -> execute();
				$conn = null;
			} catch (Exception $ex) {
				mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
				header('location:error.php');
			}
			header('location:admin-panel/display-admin-list.php');
		}
	}
	// if this a new admin user, then ...
	else
	{
		// Check if we have an administrator with the same email registered 
		try
		{
			$sql = "SELECT email FROM administrators WHERE email = :email";
			$cmd = $conn -> prepare($sql);
			$cmd -> bindParam(':email', $email, PDO::PARAM_STR, 60);
			$cmd -> execute();
			$result = $cmd -> fetchAll();
			$count = $cmd -> rowCount();
		} catch (Exception $ex) {
			mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
			header('location:error.php');
		}
		// if we attempt to register an admin user with the existing email, 
		// it will redirect us to the error page and send an email to the owner of the website
		if($count > 0)
		{
			$ok = false;
			mail('alex.andriishyn@icloud.com', 'An error occured', 'Someone is trying to register with an existing email');
			$conn = null;
			echo '<h3>The specified email address already exists.</h3>';
		}
		
		if ($ok)
		{
			// Hashing the password
			$h_password = hash('sha512', $password);
			try
			{
				$sql = "INSERT INTO administrators(firstName, lastName, email, password) VALUES(:firstName, :lastName, :email, :h_password)";
				$cmd = $conn -> prepare($sql);
				$cmd -> bindParam(':firstName', $firstName, PDO::PARAM_STR, 40);
				$cmd -> bindParam(':lastName', $lastName, PDO::PARAM_STR, 40);
				$cmd -> bindParam(':email', $email, PDO::PARAM_STR, 60);
				$cmd -> bindParam(':h_password', $h_password, PDO::PARAM_STR, 128);
				$cmd -> execute();
				$conn = null;
			} catch (Exception $ex) {
				mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
				header('location:error.php');
			}
		header('location:public.php');
		}
		else
		{
			echo '<h3 class="error">Click <a href="public.php">here</a> to go back to the home page</h3>';
		}
	}
require_once('public-footer.php'); ?>


