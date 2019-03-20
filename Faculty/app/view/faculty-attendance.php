	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
	<?php
		if(isset($_POST['view'])) {

		} 
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="newwidget widget">	
				<div class="classattendance header">
					<p>	
						<i class="fas fa-th"></i>
						<span>Attendance</span>
					</p>
					<p>School Year: 2019-2020</p>	
				</div>		
				<div class="attendancecontent widgetcontent">
					<div class="clearfix"></div>
						<div class ="cont">
							<form action="faculty-attendance" method="POST">
								<div class="cont1">
									<p>Grade Level & Section:</p>
									<select name="section">
										<option value="Grade 7">Grade 7 - Hope</option>
										<option value="Grade 7">Grade 7 - Excellence</option>
										<option value="Grade 8">Grade 8 - Altruism</option>
										<option value="Grade 8">Grade 8 - Wisdom</option>
										<option value="Grade 9">Grade 9 - Dignity</option>
										<option value="Grade 9">Grade 9 - Righteousness</option>
										<option value="Grade 10">Grade 10 - Freedom</option>
										<option value="Grade 10">Grade 10 - Independence</option>
									</select>
								</div>
								<div class="cont2">
									<p>Subject:</p>
									<select name="subject">
										<option value="English">English</option>
										<option value="Filipino">Filipino</option>
										<option value="Science">Science</option>
										<option value="MAPEH">MAPEH</option>
										<option value="Araling Panlipunan">Araling Panlipunan</option>
										<option value="TLE">TLE</option>
										<option value="Math">Math</option>
										<option value="Values">Values</option>
									</select>
								</div>
								<p>Date: <input type="text" id="datepicker" name="date"></p>
								<button type="submit" name="view">View</button>
							</form>
						</div>
					<div class="cont3">
						<div class="table-scroll">	
							<div class="table-wrap">	
								<table>
									<tr>
										<th>Name<i class="fas fa-sort"></i></th>
										<th>Attendance</i></th>
									</tr>
										<tr>
											<td>Elvis Andrade</td>
											<td>
												<p><input type="checkbox" name="Late" value="Yes" />Late<input type="checkbox" name="Absent" value="Yes"/>Absent</p>
											</td>	
										</tr>
										<tr>
											<td>Elvis Andrade</td>
											<td>
												<p><input type="checkbox" name="Late" value="Yes" />Late<input type="checkbox" name="Absent" value="Yes"/>Absent</p>
											</td>
										</tr>
										<tr>
											<td>Elvis Andrade</td>
											<td>
												<p><input type="checkbox" name="Late" value="Yes" />Late<input type="checkbox" name="Absent" value="Yes"/>Absent</p>
											</td>
										</tr>
										<tr>
											<td>Elvis Andrade</td>
											<td>
												<p><input type="checkbox" name="Late" value="Yes" />Late<input type="checkbox" name="Absent" value="Yes"/>Absent</p>
											</td>
										</tr>
										<tr>
											<td>Elvis Andrade</td>
											<td>
												<p><input type="checkbox" name="Late" value="Yes" />Late<input type="checkbox" name="Absent" value="Yes"/>Absent</p>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="cont4">
								<button>SAVE</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>