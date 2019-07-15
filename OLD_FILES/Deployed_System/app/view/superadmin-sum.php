	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct; ?>
	<?php
		if (isset($_POST['submit-grades'])) {
			$obj->submitNewGradeSummer($_POST);
		}
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Student Status</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent studentStatus">
					<table id="sum-students">
						<thead>
							<tr>
								<td>Name</td>
								<td>Status</td>
								<td>Options</td>
							</tr>
						</thead>
						<tbody>
							<?php $obj->showStudentsPromoteSummer(); ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>