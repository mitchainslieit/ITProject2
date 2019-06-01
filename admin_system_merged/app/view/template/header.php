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
	</head>
	<body <?php $this->helpers->bodyClasses($view); ?>>
		<div id=<?php $this->helpers->overallPage($view); ?>>
			<!-- <div class="se-pre-con"></div> -->
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
