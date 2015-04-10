<?php
// enter existing session
session_start();
// clear the session
session_unset();
// terminate the session
session_destroy();
header('location:../public.php');
?>

