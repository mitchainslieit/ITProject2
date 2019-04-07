	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php 
	if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertEvent($title, $post, $date_start, $date_end, $view_lim);
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
						<div name="dialog" title="Create new faculty account">
							<form action="admin-events" method="POST">
								<span>Title:</span>
								<input type="text" name="title" value="" placeholder="Title" required>
								<span>Description:</span>
								<input type="text" name="post" value="" placeholder="Description" required>
								<span>Start Date:</span>
								<input type="date" name="date_start" id="datepicker" value="" placeholder="Date Start" required>
								<span>End Date:</span>
								<input type="date" name="date_end" id="datepicker" value="" placeholder="End Date" required>
								<span>Users who can view:</span>
								<select name="view_lim" required>
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
								</select>
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
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php
 foreach($obj->showSingleTable("announcements") as $value){
 extract($value);
 echo <<<show
 <tr>
	<td>$title</td>
	<td>$post</td>
	<td>$date_start</td>
	<td>$date_end</td>
	<td></td>
</tr>
show;
}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
