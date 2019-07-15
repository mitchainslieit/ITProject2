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
		if(isset($_POST['delete-button2'])){
			extract($_POST);
			$obj->deleteAnnouncement($ann_id);
		}
		if(isset($_POST['delete-all-button1'])){
			extract($_POST);
			$obj->multipleDeleteEvents();
		}
		if(isset($_POST['delete-all-button2'])){
			extract($_POST);
			$obj->multipleDeleteAnnouncements();
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
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent eventContent">
					<div class="cont1">
						<button name="opener" class="customButton">Add event <i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Create events" >
							<form action="superadmin-events" method="POST" enctype="multipart/form-data" autocomplete="off" >
								<span>Event Title:</span>
								<input type="text" name="title" value="" data-validation="length required required" data-validation-length="max45" data-validation-error-msg="Enter less than 45 characters" placeholder="Event Title" >
								<span>Start Date:</span>
								<input type="text" name="date_start" class="datepickerAdmin" readonly="readonly" data-validation="required" value="" placeholder="Date Start" required>
								<span>End Date:</span>
								<input type="text" name="date_end" class="datepickerAdmin" readonly="readonly" value="" data-validation="required" placeholder="End Date" required>
								<span>Users who can view:</span>
								<div class="inp-grp1">
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
						<form action="superadmin-events" method="POST" id="form1"></form>
						<table id="admin-table-events" class="display">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl1" class="selectAllCheck" form="form1"> </th>
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
 echo '
 <tr>
 	<td><input type="checkbox" class="chkbox1" id="checkItem" name="check[]" value="'.$ann_id.'" form="form1"></td>
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
				<form action="superadmin-events" method="POST" enctype="multipart/form-data" required autocomplete="off" class="validateChangesInForm">
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<span>Title:</span>
					<input type="text" name="title" value="'.$title.'" data-validation="length required" data-validation-length="max45" data-validation-error-msg="Enter less than 45 characters" placeholder="Title">
					<span>Start Date:</span>
					<input type="text" name="date_start" class="datepickerAdmin" readonly="readonly" data-validation="required" value="'.date('Y-m-d',(strtotime($date_start))).'" placeholder="Date Start" required>
					<span>End Date:</span>
					<input type="text" name="date_end" class="datepickerAdmin" readonly="readonly" value="'.date('Y-m-d',(strtotime($date_end))).'" data-validation="required" placeholder="End Date" required> 
					<span>Users who can view:</span>
					<div class="inp-grp1">
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
				<form action="superadmin-events" method="POST">
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
						<p class="tleft"><button type="submit" form="form1" name="delete-all-button1" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
						
					</div>
				</div>
			</div>
			
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Announcement</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent eventContent">
					<div class="cont1">
						<button name="opener" class="customButton">Add announcement <i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Create announcement" >
							<form action="superadmin-events" method="POST" enctype="multipart/form-data" autocomplete="off">
								<span>Announcement:</span>
								<textarea name="post" id="" cols="30" rows="5" data-validation="length required" data-validation-length="max500" data-validation-error-msg="Enter less than 500 characters" placeholder="Announcement"></textarea>
								<span>Start Date:</span>
								<input type="text" name="date_start" readonly="readonly" class="datepickerAdmin" data-validation="required" value="" placeholder="Date Start" required>
								<span>End Date:</span>
								<input type="text" name="date_end" readonly="readonly" class="datepickerAdmin" value="" data-validation="required" placeholder="End Date" required>
								<span>Attachment:</span>
								<input type="file" name="attachment" id="" placeholder="Attachment(optional)">
								<span>Users who can view:</span>
								<div class="inp-grp1">
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
						<form action="superadmin-events" method="POST" id="form2"></form>
						<table class="admin-table-withScroll" class="display" width="100%">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form2"> </th>
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
 extract($value);
 echo '
 <tr>
 	<td><input type="checkbox" id="checkItem" name="check[]" value="'.$ann_id.'" form="form2"></td>
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
				<form action="superadmin-events" method="POST" enctype="multipart/form-data" required >
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<span>Announcement:</span>
					<textarea name="post" id="" cols="30" rows="5" placeholder="Announcement" data-validation="length required" data-validation-length="max500" data-validation-error-msg="Enter less than 500 characters" value="'.$post.'">'.$post.'</textarea>
					<span>Start Date:</span>
					<input type="text" name="date_start" readonly="readonly" class="datepickerAdmin" data-validation="required" value="'.date('Y-m-d',(strtotime($date_start))).'" placeholder="Date Start" required>
					<span>End Date:</span>
					<input type="text" name="date_end" readonly="readonly" class="datepickerAdmin" value="'.date('Y-m-d',(strtotime($date_end))).'" data-validation="required" placeholder="End Date" required> 
					<span>Attachment:</span>
					<span class="attachment">Current File: '.$attachment.'</span>
					<input type="file" name="attachment" id="" value="'.$attachment.'" placeholder="Attachment(optional)">
					<span>Users who can view:</span>
					<div class="inp-grp1">
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
				<form action="superadmin-events" method="POST">
					<p>Are you sure you want to delete this announcement?</p>
					<input type="hidden" value="'.$ann_id.'" name="ann_id">
					<button name="delete-button2" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
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
						<p class="tleft"><button type="submit" form="form2" name="delete-all-button2" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
						
					</div>
				</div>
			</div>
		</div>
	</div>
