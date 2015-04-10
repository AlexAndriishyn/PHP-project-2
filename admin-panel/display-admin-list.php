<?php
// Title to be inserted as a header for this page
$title = 'Administrator list';
require_once('admin-header.php');
try
{
	$sql = "SELECT * FROM administrators";
	$result = $conn -> query($sql);
	$conn = null;
} catch (Exception $ex)
{
	mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
	header('location:../error.php');
}

// Filling out a table with existing admin users
echo '<div class="tablewrapper"><table class="center"><tr><th>First name</th><th>Last name</th><th>Email(login)</th><th>Edit</th><th>Delete</th></tr>';
foreach($result as $row)
{
	echo '<tr><td>' . $row['firstName'] . '</td>'
			. '<td>' . $row['lastName'] . '</td>'
			. '<td>' . $row['email'] . '</td>'
			. '<td><a href="edit-admin.php?admin_id=' . $row['admin_id'] . '">Edit</a></td>'
			. '<td>' . '<a href="delete-record.php?admin_id=' . $row['admin_id'] 
			. '"onclick="return confirm(\'Are you sure you want to delete this admin?\');">Delete</a></td>'
		. '</tr>';
}
echo '</div></table>';

require_once('admin-footer.php');
?>
