<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		
		<title>Login</title>
		<?php include MVC . ('view/template/headercalls.php'); ?>
	</head>
	<?php
		include_once MVC . ('model/signin.php');
		if (isset($_POST['login'])) {
	        $username = $_POST['username'];
	        $password = $_POST['password'];
	        $newObject = new Signin();
	        $newObject->userSignin($username, $password);
	    }
	?>
	<body id="login_page">
		<div id="content">
			<div class="login_card">
				<div class="card_hd">
					<img src="public/images/common/logo.png" alt="Logo">
					<h1>Sign In</h1>
				</div>
				<div class="form">
					<form action="login" method="post" autocomplete="off">
						<div class="inputs">
							<div class="username">
								<input type="text" name="username" placeholder="Username" required>
							</div>
							<div class="password">
								<input type="password" name="password" placeholder="Password" required>
							</div>
						</div>
						<div class="item-right">
							<button type="submit" name="login" value="Login">LOGIN</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>