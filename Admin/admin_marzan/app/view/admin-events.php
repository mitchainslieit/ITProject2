	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertEvent($title, $post, $date_start, $date_end, $view_lim, $_FILES['attachment']);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateEvent($ann_id, $title, $post, $date_start, $date_end, $view_lim, $_FILES['attachment']);
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
						<span>Announcement/Event</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<button name="opener" class="customButton">Add announcement/event <i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Create new faculty account" >
							<form action="admin-events" method="POST" enctype="multipart/form-data">
								<span>Title:</span>
								<input type="text" name="title" value="" placeholder="Title" >
								<span>Description:</span>
								<textarea name="post" id="" cols="30" rows="5"></textarea>
								<span>Start Date:</span>
								<input type="date" name="date_start" id="datepicker" value="" placeholder="Date Start" required>
								<span>End Date:</span>
								<input type="date" name="date_end" id="datepicker" value="" placeholder="End Date" required>
								<span>Attachment:</span>
								<input type="file" name="attachment" id="" placeholder="Attachment(optional)">
								<span>Users who can view:</span>
								<div class="inp-grp">
									<input type="checkbox" name="view_lim[]" value="0"></label><span>All</span>
									<input type="checkbox" name="view_lim[]" value="1"></label><span>Faculty</span>
									<input type="checkbox" name="view_lim[]" value="2"></label><span>Parent</span>
									<input type="checkbox" name="view_lim[]" value="3"></label><span>Student</span>
									<input type="checkbox" name="view_lim[]" value="4"></label><span>Treasurer</span>
								</div>
								</select>
								<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table-withScroll" class="display">
							<thead>
								<tr>
									<th>Title</th>
									<th>Description</th>
									<th>Date Start</th>
									<th>Date End</th>
									<th>Attachment</th>
									<th>Users who can view</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php
 $viewLimValue = array(0,1,2,3,4);
/* $viewLimValue = array('0' => 0, '1,2' => 1,2);*/
 $viewLimName = array('All', 'Faculty', 'Parent', 'Student', 'Treasurer');
 foreach($obj->showSingleTable("announcements") as $value){
 extract($value);
 echo '
 <tr>
	<td>'.$title.'</td>
	<td>'.$post.'</td>
	<td>'.$date_start.'</td>
	<td>'.$date_end.'</td>
	<td>'.$attachment.'</td>
	<td>';
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
					<input type="text" name="title" value="'.$title.'" placeholder="Title" required>
					<span>Description:</span>
					<textarea name="post" value="'.$post.'" cols="30" rows="5">'.$post.'</textarea>
					<span>Start Date:</span>
					<input type="" name="date_start" id="datepicker" value="'.$date_start.'" placeholder="Date Start" required>
					<span>End Date:</span>
					<input type="" name="date_end" id="datepicker" value="'.$date_end.'" placeholder="End Date" required> 
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
						echo '<input type="checkbox" name="view_lim[]" value="'.$val.'" '.$set_checked.' > '.$viewLimName[$val].'';
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
			<div name="dialog" title="Delete announcement">
				<form action="admin-events" method="POST">
					<p>Are you sure you want to delete this account?</p>
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
