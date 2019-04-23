	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>History of Logs</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<p>Log Event:</p>
						<select name="log_event" class="log_events">
							<option value="">All</option>
							<option value="Insert">Insert</option>
							<option value="Update">Update</option>
							<option value="Delete">Delete</option>
							<option value="Reset">Reset</option>
						</select>
					</div>
					<div class="cont2">
						<table id="admin-table-logs" class="display">
							<thead>
								<tr>
									<th>Log ID</th>
									<th>Log Timestamp</th>
									<th>Log Event</th>
									<th>Log Description</th>
									<th>Position</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showLogs() as $value){
 extract($value);
 echo '
 <tr>
 	<td>'.$log_id.'</td>
 	<td>'.$logdate.'</td>
 	<td>'.$log_event.'</td>
 	<td>'.$log_desc.'</td>
 	<td>'.$acc_type.'</td>
 </tr> ';
}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>