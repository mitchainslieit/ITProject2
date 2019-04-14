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
<!-- 			<div class="se-pre-con"></div>
 -->			<div class="topbar">
				<div class="topbarleft">	
					<h2><?php $this->helpers->userType($view); ?></h2>
				</div>
				<div class="topbarright">
					<div class="icon">
						<a id="clickme"><i class="fas fa-bars"></i></a>
					</div>
					<div class="info">
						<a href="<?php echo URL ?>n/a"><i class="fas fa-bell fnt"></i></a>
						<div class="profile">
							<?php $this->helpers->getUserImage(); ?>
							<p><?php $this->helpers->getFirstName(); ?></p>
						</div>
						<div class="dropdown-menu">
							<button class="dropdown-btn"><i class="fas fa-sort-down"></i></button>
							<div class="dropdown-menu-content">
								<ul>
									<li><i class="fas fa-user"></i>My Profile</li>
									<li><i class="fas fa-lock"></i>Change Password</li>
									<li><a href="<?php echo URL ?>app/model/unstructured/signout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="leftmenu">
				<div class="container">
					<div class="welcome">	
						<div class="imgholder">	
							<?php $this->helpers->getUserImage(); ?>
						</div>
						<div class="welcomecont">	
							<h3>Welcome, <span><?php $this->helpers->getFirstName(); ?></span></h3>
						</div>
						
					</div>	
					<header>
						<nav>
							<ul class="sidebar-menu">
								<?php require 'menu.php'; ?>
							</ul>
						</nav>	
					</header>	
					<div class="logo">
						<a href="<?php echo URL ?>"><img src="public/images/common/logo.png"></a>
					</div>
				</div>
			</div>