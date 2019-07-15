<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		
		<title>Change Password</title>
		<?php include MVC . ('view/template/headercalls.php'); ?>
	</head>
	<?php
		include_once MVC . ('model/changepassword.php');
		if (isset($_POST['change'])) {
	        $password = $_POST['password'];
	        $repassword = $_POST['repassword'];
	        $newObject = new ChangePassword();
	        $newObject->newPassword($password, $repassword);
	    }
	?>
	<body id="firstlogin_page">
		<div id="content">
			<div class="login_card">
				<div class="card_hd">
					<h1>Change Password</h1>
					<p>You are required to change your password on your first login to secure your account.</p>
					<p>Password must be at least 8 characters</p>
				</div>
				<div class="form">
					<form action="firstlogin" method="post" autocomplete="off">
						<div class="inputs">
							<div class="password">
								<input type="password" name="password" placeholder="Password" required>
							</div>
							<div class="password">
								<input type="password" name="repassword" placeholder="Confirm Password" required>
							</div>
						</div>
						<div class="item-right">
							<button type="submit" name="change" value="Change">Change</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>