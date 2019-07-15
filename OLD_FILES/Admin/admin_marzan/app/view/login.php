<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		
		<?php $this->helpers->siteTitle($view); ?>
		<link rel="icon" href="public/images/favicon.png" type="image/x-icon">
		<link href="<?php echo URL; ?>public/styles/style.css" rel="stylesheet">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	</head>
	<?php
		include_once ('app/model/signin.php');
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
				</div>
				<div class="form">
					<form action="login" method="post">
						<div class="inputs">
							<div class="username">
								<label>Username: </label>
								<input type="text" name="username" required>
							</div>
							<div class="password">
								<label>Password: </label>
								<input type="password" name="password" required>
							</div>
						</div>
						<div class="item-right">
							<button type="submit" name="login" value="Login">LOGIN</button>
							<a href="">Forget Password?</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
</html>