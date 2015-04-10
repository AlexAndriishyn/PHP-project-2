		<form method="post" action="register-admin.php">
			<div>
				<fieldset class="registrationForm">
					<div class="row">
						<label for="firstName">First name:</label>
						<input type="text" name="firstName" required />
					</div>
					<div class="row">
						<label for="lastName">Last name:</label>
						<input type="text" name="lastName" required />
					</div>
					<div class="row">
						<label for="lastName">Email:</label>
						<input type="email" name="email" required placeholder="example@mail.com"/>
						<sup>*Your login</sup>
					</div>
					<div class="row">
						<label for="password">Password:</label>
						<input type="password" name="password" required />
					</div>
					<div class="row">
						<label for="c_password">Confirm password:</label>
						<input type="password" name="c_password" required />
					</div>
				</fieldset>
				<div class="submit">
					<input type="submit" value="Register"/>
				</div>
			</div>
		</form>
    