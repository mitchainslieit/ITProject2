	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>

	<div class="contentpage" id="contentpage">
		<div class="row">
			<!-- ADMIN'S REQUEST -->
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-bell"></i>
						<span>Schedulling Requests</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<?php $obj->sashowTabledSections();?>
					</div>
				</div>
			</div>
		</div>
	</div>