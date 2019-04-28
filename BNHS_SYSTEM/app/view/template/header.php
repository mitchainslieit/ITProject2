<!DOCTYPE html>
<html lang="en" <?php $this->helpers->htmlClasses(); ?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />

		<title>Loading...</title>
		<?php $this->helpers->siteSpecificCSS(); ?>
		<?php include('headercalls.php'); ?>
		<?php if($_SESSION['acc_details'] === 'New') { ?>
			<style>
				.ui-dialog .ui-widget-overlay.custom-overlay{background-color: black;background-image: none;opacity: 0.8;z-index: 1040;}
				#change-password form > * { display: block; margin-bottom: 15px; }
				#change-password form { text-align: left; }
				#change-password form span { display: inline-block; width: 210px; }
				#change-password form span.form-error { width: 400px; color: rgb(244, 0, 0); }
				#change-password form span.form-error:before { content: '*'; }
			</style>
		<?php } ?>
	</head>
	<body <?php $this->helpers->bodyClasses($view); ?>>
		<div id=<?php $this->helpers->overallPage($view); ?>>
			<div class="se-pre-con"></div>
			<div class="menu-top">
				<div class="menu-top-left">
					<div class="container">
						<a href="<?php echo URL; ?>"><img src="public/images/common/logo.png"></a>	
						<h2>BNHS</h2>
					</div>
				</div>
				<div class="menu-top-right">
					<div class="info">
						<div class="profile">
							<p><?php $this->helpers->getFirstName(); ?></p>
							<div class="prof-img"><?php $this->helpers->getUserImage(); ?></div>
						</div>
						<div class="btn-group">
							<div class="settings">
								<button class="dropdown-btn" data-dropdown="#sub-menu"><i class="fas fa-sort-down"></i></button>
								<div class="dropdown-menu dropdown-anchor-top-right dropdown-has-anchor" id="sub-menu">
									<ul>
										<li><a href=""><i class="fas fa-user"></i>My Profile</a></li>
										<li><a href=""><i class="fas fa-lock"></i>Change Password</a></li>
								    	<li class="divider"></li>
										<li><a href="<?php echo URL; ?>app/model/unstructured/signout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a></li>
									</ul>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="menu-sidebar">
				<div class="about">		
					<?php $this->helpers->getUserImage(); ?>
					<h3><?php $this->helpers->getFirstName(); ?><span><?php $this->helpers->userType($view); ?></span></h3>
				</div>
				<div class="menu">
					<nav>
						<ul>
							<?php require 'menu.php'; ?>
						</ul>
					</nav>
				</div>
			</div>
			<div class="content-container">
<?php
	if(isset($_POST['change-user-password'])) {
		$conn = new PDO ("mysql:host=192.168.254.111; dbname=bnhs_final","bnhs","bnhs");
		$getPassword = $conn->prepare("SELECT * FROM accounts WHERE acc_id = :accid");
		$getPassword->execute(array(
			':accid' => $_SESSION['accid']
 		));
 		$getResult = $getPassword->fetch();
		if (password_verify($_POST['old-pass'], $getResult['password'])) {
			if (strlen($_POST['password_confirmation']) >= 8) {
				if (password_verify($_POST['old-pass'], $_POST['password'])) {
					echo '<script>swal({
						title: \'Error!\',
						text: \'Do not use your old password again.\',
						icon: \'error\'
					}).then(function() {
						 window.location = "'.(str_replace('url=', '', $_SERVER['QUERY_STRING'])).'";
					});</script>';
				} else {
					if ($_POST['password_confirmation'] === $_POST['password']) {
						$newpassword = password_hash($_POST['password_confirmation'], PASSWORD_DEFAULT);
						$updateAcc = $conn->prepare("UPDATE accounts SET password = :password, acc_details = 'Old' WHERE acc_id = :acc_id");
						$updateAcc->execute(array(
							':password' => $newpassword,
							':acc_id' => $_SESSION['accid']
						));
						echo '<script>swal({
							title: \'Success!\',
							text: \'Your password has been changed.\',
							icon: \'success\'
						}).then(function() {
							 window.location = "'.(str_replace('url=', '', $_SERVER['QUERY_STRING'])).'";
						});</script>';
						$_SESSION['acc_details'] = 'Old';
					} else {
						echo '<script>swal({
							title: \'Error!\',
							text: \'Your passwords doesn\'t match.\',
							icon: \'error\'
						}).then(function() {
							 window.location = "'.(str_replace('url=', '', $_SERVER['QUERY_STRING'])).'";
						});</script>';
					}
				}
			} else {
				echo '<script>swal({
					title: \'Error!\',
					text: \'Please type in 8 character password.\',
					icon: \'error\'
				}).then(function() {
					 window.location = "'.(str_replace('url=', '', $_SERVER['QUERY_STRING'])).'";
				});</script>';
			}
		} else {
			echo '<script>swal({
				title: \'Error!\',
				text: \'You have entered the wrong password.\',
				icon: \'error\'
			}).then(function() {
				 window.location = "'.(str_replace('url=', '', $_SERVER['QUERY_STRING'])).'";
			});</script>';
		}
	}
?>

<?php
	function checkIfNewAccount() {
		if ($_SESSION['acc_details'] === 'New') {
			echo '<div id="change-password" title="Please change your password to secure your account">
				<form action="'.(str_replace('url=', '', $_SERVER['QUERY_STRING'])).'" method="post">
					<label><input type="hidden" value="sample" name="'.$_SESSION['accid'].'"></label>
					<label><span>Default Password: </span><input type="password" name="old-pass" placeholder="Current Password"></label>
					<label><span>New Password: </span><input type="password" name="password_confirmation" placeholder="New Password"  data-validation="length" data-validation-length="min8"></label>
					<label><span>Confirm New Password: </span><input type="password" name="password" data-validation="confirmation" placeholder="Confirm new password"></label>
					<input type="submit" value="Change Password" name="change-user-password">
				</form>
			</div>';
			echo '<script>
				$( "#change-password" ).dialog({
      				autoOpen: true,
      				modal: true,
      				width: 550
  				});
			</script>';
		}
	}

	checkIfNewAccount();
?>				