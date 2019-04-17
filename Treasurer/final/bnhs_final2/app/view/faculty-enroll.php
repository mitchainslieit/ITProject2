	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct() ?>
	<?php 
		if (isset($_POST['submit-bttn'])) {
			if (empty($_POST['telno'])) {
				$_POST['telno'] = 'NULL';
			}
	        $getFactFunct->enrollNewStudent( $_POST['schoolyear'],  $_POST['lrn'],  $_POST['lastname'],  $_POST['firstname'],  $_POST['middlename'],  $_POST['birthday'],  $_POST['gender'],  $_POST['address'],  $_POST['barangay'],  $_POST['city'],  $_POST['zipcode'],  $_POST['fathername'],  $_POST['mothername'],  $_POST['guardname'],  $_POST['telno'],  $_POST['cellno']);
	    }
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fas fa-user-plus fnt"></i><span>Enroll Student</span></p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="enrollcontent widgetcontent">
					<div class="tabs">
						<ul>
							<li><a href="#section1">Old Student</a></li>
							<li><a href="#section2">New Student</a></li>
						</ul>
						<div id="section1">
							<div class="cont2">
								<div class="box2">	
									<span>Search:</span>
									<input type="" name="">
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="cont3">
								<div class="table-scroll">	
									<div class="table-wrap">
										<table>
											<tr>
												<th>LRN(Learner Reference No.)<i class="fas fa-sort"></i></th>
												<th>Name<i class="fas fa-sort"></i></th>
												<th>Student Status<i class="fas fa-sort"></i></th>
											</tr>	
											<tr>
												<td>852741963159</td>
												<td>Elvis Andrade</td>
												<td>
													<select name="" id="">
														<option value="">Enrolled</option>
														<option value="">Not enrolled</option>
														<option value="">Temporary enrolled</option>
													</select>
												</td>	
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div id="section2">
							<div class="clearfix"></div>
							<div class="container">
								<form action="faculty-enroll" class="enrollment-form" id="student-enrollment-form" method="POST">
									<div class="form-row">
										<div class="hd">
											<h3>STUDENT INFORMATION</h3>
										</div>
										<label>
											<span>SCHOOL YEAR (YYYY): </span>
											<input type="text" name="schoolyear" required>
										</label>
										<label>
											<span>LEARNER REFERENCE No. (LRN): </span>
											<input type="text" name="lrn" required>
										</label>
										<label>
											<span>LAST NAME: </span>
											<input type="text" name="lastname" required>
										</label>
										<label>
											<span>FIRST NAME: </span>
											<input type="text" name="firstname" required>
										</label>
										<label>
											<span>MIDDLE NAME: </span>
											<input type="text" name="middlename" required>
										</label>
										<div class="date-sex">
											<label>
												<span>DATE OF BIRTH: </span>
												<input type="text" id="datepicker" name="birthday" required>
											</label>
											<label>
												<span>SEX: </span>
												<span><input type="radio" name="gender" value="Male" required/>MALE<input type="radio" name="gender" value="Female"/>FEMALE</span>
											</label>
										</div>
									</div>
									<div class="form-row">
										<div class="hd">
											<h3>ADDRESS INFORMATION</h3>
										</div>
										<label>
											<span>HOUSE NUMBER AND STREET: </span>
											<input type="text" name="address" required>
										</label>
										<label>
											<span>BARANGAY </span>
											<input type="text" name="barangay" required>
										</label>
										<label>
											<span>CITY/MUNICIPALITY/PROVINCE/COUNTRY: </span>
											<input type="text" name="city" required>
										</label>
										<label>
											<span>ZIP CODE: </span>
											<input type="text" name="zipcode" required>
										</label>
									</div>
									<div class="form-row par-guar">
										<div class="hd">
											<h3>PARENT'S AND GUARDIAN'S INFORMATION</h3>
										</div>
										<label>
											<span>FATHER'S NAME: <small>(Last Name, First Name Middle Initial) </small></span>
											<input type="text" name="fathername" required></label>
										<label>
											<span>MOTHER'S NAME: <small>(Last Name, First Name Middle Initial) </small></span>
											<input type="text" name="mothername" required>
										</label>
										<label>
											<span>GUARDIAN'S NAME: <small>(Last Name, First Name Middle Initial) </small></span>
											<input type="text" name="guardname" required>
										</label>
										<label>
											<span>TELEPHONE NUMBER: </span>
											<input type="text" name="telno">
										</label>
										<label>
											<span>CELLPHONE NUMBER: </span>
											<input type="text" name="cellno" required>
										</label>
									</div>
									<div class="form-row requirements">
										<div class="hd">
											<h3>
												STUDENT REQUIREMENT'S
											</h3>
										</div>
									</div>
									<div class="save">
										<button name="submit-bttn" >Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
