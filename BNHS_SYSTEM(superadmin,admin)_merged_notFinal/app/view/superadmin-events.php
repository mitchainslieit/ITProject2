	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertEvent($title, $date_start, $date_end, $view_lim);
		}
		if(isset($_POST['submit-button2'])){
			extract($_POST);
			$obj->insertAnnouncement($post, $date_start, $date_end, $view_lim, $_FILES['attachment']);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateEvent($ann_id, $title, $date_start, $date_end, $view_lim);
		}
		if(isset($_POST['update-button2'])){
			extract($_POST);
			$obj->updateAnnouncement($ann_id, $post, $date_start, $date_end, $view_lim, $_FILES['attachment']);
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deleteEvent($ann_id);
		}
		
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Event</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2"> 
						<table id="superadmin-table-all" class="display">
							<thead>
								<tr>
									<th class="tleft">Title</th>
									<th class="tleft">Date Start</th>
									<th class="tleft">Date End</th>
									<th class="tleft">Users who can view</th>
								</tr>
							</thead>
							<tbody>
<?php
 $viewLimValue = array(0,1,2,3,4);
/* $viewLimValue = array('0' => 0, '1,2' => 1,2);*/
 $viewLimName = array('All', 'Faculty', 'Parent', 'Student', 'Treasurer');
 foreach($obj->showEventsSection() as $value){
 extract($value);
 echo '
 <tr>
	<td class="tleft">'.$title.'</td>
	<td class="tleft">'.$date_start_1.'</td>
	<td class="tleft">'.$date_end_1.'</td>
	<td class="tleft">';
	$obj->viewLim($ann_id);
	echo'
	</td>
</tr>
';
}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Announcement</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table id="superadmin-table-announcement" class="display" width="100%">
							<thead>
								<tr>
									<th class="tleft">Announcement</th>
									<th class="tleft">Date Start</th>
									<th class="tleft">Date End</th>
									<th class="tleft">Attachment</th>
									<th class="tleft">Users who can view</th>
								</tr>
							</thead>
							<tbody>
<?php
 $viewLimValue = array(0,1,2,3,4);
/* $viewLimValue = array('0' => 0, '1,2' => 1,2);*/
 $viewLimName = array('All', 'Faculty', 'Parent', 'Student', 'Treasurer');
 foreach($obj->showAnnouncementSection() as $value){
 extract($value);
 echo '
 <tr>
	<td class="tleft longText">'.$post.'</td>
	<td class="tleft">'.$date_start_1.'</td>
	<td class="tleft">'.$date_end_1.'</td>
	<td class="tleft">'.$attachment.'</td>
	<td class="tleft">';
	$obj->viewLim($ann_id);
	echo'
	</td>
</tr>
';
}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
