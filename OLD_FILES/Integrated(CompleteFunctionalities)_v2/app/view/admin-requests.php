<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct; ?>
<?php
	if(isset($_POST['mark-read'])) {
		$obj->readAll();
	}
?>
<div class="contentpage">
	<div class="row">
		<div class="widget">	
			<div class="header">	
				<div class="cont">	
					<i class="fas fa-money-check"></i>
					<span>Approved / Rejected Requests</span>
				</div>
				<p>School Year: <?php $obj->getSchoolYear(); ?></p>
			</div>
			<div class="widgetContent">
				<table id="admin-notif-table">
					<thead>
						<tr>
							<th class="text-left">Description</th>
							<th>Status</th>
							<th>seen</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php $obj->getNotificationTableData(); ?>
					</tbody>
				</table>
				<form action="admin-requests" method="post">
					<button name="mark-read" class="btn btn-primary">Mark All As Read</button>
				</form>
			</div>
		</div>
	</div>
</div>