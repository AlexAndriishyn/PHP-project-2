<?php
// Title to be inserted as a header for this page
$title = 'Edit administrator record';
require_once('admin-header.php');
$admin_id = $_GET['admin_id'];

// Filling out the edit form with admin credentials
try
{
	$sql = "SELECT * FROM administrators WHERE admin_id = $admin_id";
	$cmd = $conn -> prepare($sql);
	$cmd -> bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
	$cmd -> execute();
	$result = $cmd -> fetchAll();
	$conn = null;
}
catch (Exception $ex)
{
	mail('alex.andriishyn@icloud.com', 'An error occured', $ex);
	header('location:../error.php');
}
foreach ($result as $row)
{
	$firstName = $row['firstName'];
	$lastName = $row['lastName'];
	$email = $row['email'];
}
?>

<form method="post" action="../register-admin.php">
	<div>
		<fieldset>
			<div class="row">
				<label for="firstName">First name:</label>
				<input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required />
			</div>
			<div class="row">
				<label for="lastName">Last name:</label>
				<input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required />
			</div>
			<div class="row">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" value="<?php echo $email; ?>" required />
				<sup>*Your login</sup>
			</div>
			<div class="row">
				<label for="password">New password:</label>
				<input type="password" id="password" name="password" required />
			</div>
			<div class="row">
				<label for="c_password">Confirm password:</label>
				<input type="password" id="c_password" name="c_password" required />
			</div>
		</fieldset>
		<div class="submit-admin">
			<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>" />
			<input type="submit" value="Confirm"/>
		</div>
	</div>
</form>

<?php require_once('admin-footer.php'); ?>
