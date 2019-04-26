	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
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
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<button name="opener" class="customButton">Add event <i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Create events" >
							<form action="admin-events" method="POST" enctype="multipart/form-data">
								<span>Event Title:</span>
								<input type="text" name="title" value="" data-validation="length" data-validation-length="max45" data-validation-error-msg="Enter less than 45 characters" placeholder="Event Title" >
								<span>Start Date:</span>
								<input type="date" name="date_start" id="datepicker" data-validation="required" value="" placeholder="Date Start" required>
								<span>End Date:</span>
								<input type="date" name="date_end" id="datepicker" value="" data-validation="required" placeholder="End Date" required>
								<span>Users who can view:</span>
								<div class="inp-grp">
									<input type="checkbox" name="view_lim[]" value="0" data-validation="checkbox_group" data-validation-qty="1-3"><span>All</span>
									<input type="checkbox" name="view_lim[]" value="1"><span>Faculty</span>
									<input type="checkbox" name="view_lim[]" value="2"><span>Parent</span>
									<input type="checkbox" name="view_lim[]" value="3"><span>Student</span>
									<input type="checkbox" name="view_lim[]" value="4"><span>Treasurer</span>
								</div>
								<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<div class="cont2"> 
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th class="tleft">Title</th>
									<th class="tleft">Date Start</th>
									<th class="tleft">Date End</th>
									<th class="tleft">Users who can view</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php
 $viewLimValue = array(0,1,2,3,4);
/* $viewLimValue = array('0' => 0, '1,2' => 1,2);*/
 $viewLimName = array('All', 'Faculty', 'Parent', 'Student', 'Treasurer');
 foreach($obj->showEventsSection() as $value){
 extract($value);
 $d1 = date('Y-m-d',(strtotime($date_start)));
 $d2 = date('Y-m-d',(strtotime($date_end)));
 echo '
 <tr>
	<td class="tleft">'.$title.'</td>
	<td class="tleft">'.$date_start_1.'</td>
	<td class="tleft">'.$date_end_1.'</td>
	<td class="tleft">';
	$obj->viewLim($ann_id);
	echo'
	</td>
	<td class=action>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update announcement">
				<form action="admin-events" method="POST" enctype="multipart/form-data" required>
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<span>Title:</span>
					<input type="text" name="title" value="'.$title.'" data-validation="length" data-validation-length="max45" data-validation-error-msg="Enter less than 45 characters" placeholder="Title">
					<span>Start Date:</span>
					<input type="date" name="date_start" id="datepicker" data-validation="required" value="'.$d1.'" placeholder="Date Start" required>
					<span>End Date:</span>
					<input type="date" name="date_end" id="datepicker" value="'.$d2.'" data-validation="required" placeholder="End Date" required> 
					<span>Users who can view:</span>
					<div class="inp-grp">
					';
					$checked_arr=array();
					$checked_arr =	explode(",", $value['view_lim']);  
					foreach ($viewLimValue as $val) {
						$set_checked = "";
						if(in_array($val, $checked_arr)) {
					        	$set_checked = "checked";
					     }
						echo '<input type="checkbox" name="view_lim[]" value="'.$val.'" '.$set_checked.' data-validation="checkbox_group" data-validation-qty="1-3"> '.$viewLimName[$val].'';
					}
					echo'
					</div>
					<button name="update-button" class="customButton">Update <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-trash-alt"></i>
					<span class="tooltiptext">delete</span>
				</div>
			</button>
			<div name="dialog" title="Delete event">
				<form action="admin-events" method="POST">
					<p>Are you sure you want to delete this event?</p>
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
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
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<button name="opener" class="customButton">Add announcement <i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Create announcement" >
							<form action="admin-events" method="POST" enctype="multipart/form-data">
								<span>Announcement:</span>
								<textarea name="post" id="" cols="30" rows="5" data-validation="length required" data-validation-length="max500" data-validation-error-msg="Enter less than 500 characters" placeholder="Announcement"></textarea>
								<span>Start Date:</span>
								<input type="date" name="date_start" id="datepicker" data-validation="required" value="" placeholder="Date Start" required>
								<span>End Date:</span>
								<input type="date" name="date_end" id="datepicker" value="" data-validation="required" placeholder="End Date" required>
								<span>Attachment:</span>
								<input type="file" name="attachment" id="" placeholder="Attachment(optional)">
								<span>Users who can view:</span>
								<div class="inp-grp">
									<input type="checkbox" name="view_lim[]" value="0" data-validation="checkbox_group" data-validation-qty="1-3"><span>All</span>
									<input type="checkbox" name="view_lim[]" value="1"><span>Faculty</span>
									<input type="checkbox" name="view_lim[]" value="2"><span>Parent</span>
									<input type="checkbox" name="view_lim[]" value="3"><span>Student</span>
									<input type="checkbox" name="view_lim[]" value="4"><span>Treasurer</span>
								</div>
								<button name="submit-button2" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table-withScroll" class="display" width="100%">
							<thead>
								<tr>
									<th class="tleft">Announcement</th>
									<th class="tleft">Date Start</th>
									<th class="tleft">Date End</th>
									<th class="tleft">Attachment</th>
									<th class="tleft">Users who can view</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php
 $viewLimValue = array(0,1,2,3,4);
/* $viewLimValue = array('0' => 0, '1,2' => 1,2);*/
 $viewLimName = array('All', 'Faculty', 'Parent', 'Student', 'Treasurer');
 foreach($obj->showAnnouncementSection() as $value){
 $d1 = date('Y-m-d',(strtotime($date_start)));
 $d2 = date('Y-m-d',(strtotime($date_end)));
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
	<td class=action>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update announcement">
				<form action="admin-events" method="POST" enctype="multipart/form-data" required>
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<span>Announcement:</span>
					<textarea name="post" id="" cols="30" rows="5" placeholder="Announcement" data-validation="length required" data-validation-length="max500" data-validation-error-msg="Enter less than 500 characters" value="'.$post.'">'.$post.'</textarea>
					<span>Start Date:</span>
					<input type="date" name="date_start" id="datepicker" value="'.$d1.'" placeholder="Date Start" required>
					<span>End Date:</span>
					<input type="date" name="date_end" id="datepicker" value="'.$d2.'" placeholder="End Date" required> 
					<span>Users who can view:</span>
					<span>Attachment:</span>
					<span class="attachment">Current File: '.$attachment.'</span>
					<input type="file" name="attachment" id="" value="'.$attachment.'" placeholder="Attachment(optional)">
					<span>Users who can view:</span>
					<div class="inp-grp">
					';
					$checked_arr=array();
					$checked_arr =	explode(",", $value['view_lim']);  
					foreach ($viewLimValue as $val) {
						$set_checked = "";
						if(in_array($val, $checked_arr)) {
					        	$set_checked = "checked";
					     }
						echo '<input type="checkbox" name="view_lim[]" value="'.$val.'" '.$set_checked.' data-validation="checkbox_group" data-validation-qty="1-3"> '.$viewLimName[$val].'';
					}
					echo'
					</div>
					<button name="update-button2" class="customButton">Update <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-trash-alt"></i>
					<span class="tooltiptext">delete</span>
				</div>
			</button>
			<div name="dialog" title="Delete announcement">
				<form action="admin-events" method="POST">
					<p>Are you sure you want to delete this announcement?</p>
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
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
