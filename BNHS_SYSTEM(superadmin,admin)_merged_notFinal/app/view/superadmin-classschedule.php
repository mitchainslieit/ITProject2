	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fa fa-user fnt"></i><span>Adviser Class Schedule</span></p>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>	
				<div class="editContent widgetcontent">
					<div class="cont2">
						<div class="table-scroll">
							<div class ="cont fl">
								<span>SECTION: </span>
								<select name="sectionid" id="getCurrentLevel">
									<?php $obj->showSections(); ?>
								</select>
							</div>
							<?php $obj->showTabledSections(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>