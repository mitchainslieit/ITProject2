	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertEvent($title, $post, $date_start, $date_end, $view_lim, $_FILES['attachment']);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateEvent($ann_id, $title, $post, $date_start, $date_end, $attachment);
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
								<input type="text" name="title" value="" placeholder="Title" required>
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
									<span>All</span><input type="checkbox" name="view_lim" value="0"></label>
									<span>Faculty</span><input type="checkbox" name="view_lim" value="1"></label>
									<span>Prent</span><input type="checkbox" name="view_lim" value="2"></label>
									<span>Student</span><input type="checkbox" name="view_lim" value="3"></label>
									<span>Treasurer</span><input type="checkbox" name="view_lim" value="4"></label>
								</div>
								<!-- <select name="view_lim" required>
									<option selected disabled hidden value="">Select users who can view</option>
									<option value="0">All</option>
									<option value="1" >Faculty only</option>
									<option value="2" >Student only</option>
									<option value="3" >Parent only</option>
									<option value="4" >Treasurer only</option>
									<option value="1, 2">Faculty and Student</option>
									<option value="1, 3">Faculty and Parent</option>
									<option value="1, 4">Faculty and Treasurer</option>
									<option value="2, 3">Student and Parent</option>
									<option value="3, 4">Parent and Treasurer</option>
									<option value="1, 2, 3">Faculty, Student and Parent</option>
									<option value="1, 3, 4">Faculty, Parent and Treasurer</option>
									<option value="2, 3, 4">Student, Parent and Treasurer</option>
								</select> -->
								<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>Title</th>
									<th>Description</th>
									<th>Date Start</th>
									<th>Date End</th>
									<th>Attachment</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php
 foreach($obj->showSingleTable("announcements") as $value){
 extract($value);
 echo '
 <tr>
	<td>'.$title.'</td>
	<td>'.$post.'</td>
	<td>'.$date_start.'</td>
	<td>'.$date_end.'</td>
	<td>'.$attachment.'</td>
	<td class=action>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update announcement">
				<form action="admin-events" method="POST" required>
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
					<input type="file" name="attachment" value="'.$attachment.'" placeholder="Attachment(optional)">
					<span>Users who can view:</span>
					<div class="inp-grp">
						<span>All</span><input type="checkbox" name="" value="0">'.$view_lim.'</label>
						<span>Faculty</span><input type="checkbox" name="" value="1">'.$view_lim.'</label>
						<span>Prent</span><input type="checkbox" name="" value="2">'.$view_lim.'</label>
						<span>Student</span><input type="checkbox" name="" value="3">'.$view_lim.'</label>
						<span>Treasurer</span><input type="checkbox" name="" value="4">'.$view_lim.'</label>
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
