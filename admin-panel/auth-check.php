<?php
// Checking for an existing admin_id
session_start();
if(empty($_SESSION['admin_id'])) 
{
	header('location:../error.php');
	exit();
}
?>

