	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct() ?>
	<?php 
		if (isset($_POST['submit-bttn'])) {
			if (empty($_POST['guar_telno'])) {
				$_POST['guar_telno'] = 'NULL';
			}

	        $getFactFunct->enrollNewStudent(array(
	        	'stud_lrno' => $_POST['stud_lrno'],
	        	'last_name' => $_POST['last_name'],
	        	'first_name' => $_POST['first_name'],
	        	'middle_name' => $_POST['middle_name'],
	        	'stud_bday' => $_POST['stud_bday'],
	        	'gender' => $_POST['gender'],
	        	'year_level' => $_POST['year_level'],
	        	'nationality' => $_POST['nationality'],
	        	'religion' => $_POST['religion'],
	        	'address' => $_POST['address'],
	        	'barangay' => $_POST['barangay'],
	        	'city' => $_POST['city'],
	        	'zipcode' => $_POST['zipcode'],
	        	'fathername_first' => $_POST['fathername_first'],
	        	'fathername_midint' => $_POST['fathername_midint'],
	        	'fathername_last' => $_POST['fathername_last'],
	        	'mothername_first' => $_POST['mothername_first'],
	        	'mothername_midint' => $_POST['mothername_midint'],
	        	'mothername_last' => $_POST['mothername_last'],
	        	'guar_name' => $_POST['guar_name'],
	        	'guar_telno' => $_POST['guar_telno'],
	        	'guar_mobno' => $_POST['guar_mobno'],
	        	'enroll-status' => $_POST['enroll-status'],
	        	'par_account' => $_POST['par_account']
	        ));
	    }
	?>
	<div class="contentpage">
		<div class="row">
			<div data-type="modal" id="status-update">
				<div class="container">
					<div class="modal-hd">
						<div class="exit">
							<a target="_blank" class="exit-modal"><i class="fas fa-times"></i></a>
						</div>
						<h2 class="success">Success!</h2>
					</div>
					<div class="modal-cont">
						<p>The status of the student has been changed!</p>
					</div>
				</div>
			</div>
			<!-- <button toggle="modal" target="sample-modal" type="button" >OPEN MODAL</button> -->	
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fas fa-user-plus fnt"></i><span>Enroll Student</span></p>
					<p>School Year: <?php $nextYear = date('Y') + 1; echo date('Y').' - '.$nextYear; ?></p>
				</div>	
				<div class="enrollcontent widgetcontent">
					<div class="tabs">
						<ul>
							<li><a href="#section1">Old Student</a></li>
							<li><a href="#section2">New Student</a></li>
						</ul>
						<div id="section1">
							<div class="clearfix"></div>
							<div class="cont3">
								<div class="table-scroll">	
									<div class="table-wrap">
										<table id="old-student">
											<thead>
											<tr>
												<th>LRN(Learner Reference No.)</th>
												<th>Name</th>
												<th>Student Status</th>
											</tr>
											</thead>	
											<tbody>
												<?php $getFactFunct->oldStud(); ?>
											</tbody>
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
										<p>All with <span class="required">*</span> are required, kindly fill it in.</p>
										<div class="hd">
											<h3>STUDENT INFORMATION</h3>
										</div>
										<label>
											<span>LEARNER REFERENCE No. (LRN):<span class="required">&nbsp;*</span></span>
											<input type="text" name="stud_lrno" required>
										</label>
										<label>
											<span>LAST NAME:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="last_name" required>
										</label>
										<label>
											<span>FIRST NAME:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="first_name" required>
										</label>
										<label>
											<span>MIDDLE NAME:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="middle_name" required>
										</label>
										<div class="date-sex">
											<label>
												<span>DATE OF BIRTH:<span class="required">&nbsp;*</span> </span>
												<input type="text" id="datepicker" name="stud_bday" required>
											</label>
											<label>
												<span>SEX:<span class="required">&nbsp;*</span> </span>
												<span><input type="radio" name="gender" value="Male" required/>MALE<input type="radio" name="gender" value="Female"/>FEMALE</span>
											</label>
										</div>
										<label>
											<span>GRADE LEVEL:<span class="required">&nbsp;*</span> </span>
											<select name="year_level" id="">
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</label>
										<label>
											<span>NATIONALITY:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="nationality" required>
										</label>
										<label>
											<span>RELIGION:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="religion" required>
										</label>
									</div>
									<div class="form-row">
										<div class="hd">
											<h3>ADDRESS INFORMATION</h3>
										</div>
										<label>
											<span>HOUSE NUMBER AND STREET:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="address" required>
										</label>
										<label>
											<span>BARANGAY<span class="required">&nbsp;*</span> </span>
											<input type="text" name="barangay" required>
										</label>
										<label>
											<span>CITY/MUNICIPALITY/PROVINCE/COUNTRY:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="city" required>
										</label>
										<label>
											<span>ZIP CODE:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="zipcode" required>
										</label>
									</div>
									<div class="form-row par-guar">
										<div class="hd">
											<h3>PARENT'S AND GUARDIAN'S INFORMATION</h3>
										</div>
										<div class="parents-info">
											<label>
												<span>FATHER'S NAME:<span class="required">&nbsp;*</span></span>
												<div class="par-inp">
													<input type="text" name="fathername_first" placeholder="First Name" required>	
													<input type="text" name="fathername_midint" placeholder="Middle Initial" required>	
													<input type="text" name="fathername_last" placeholder="Last Name" required>	
												</div>
											</label>
											<label>
												<span>MOTHER'S NAME:<span class="required">&nbsp;*</span></span>
												<div class="par-inp">
													<input type="text" name="mothername_first" placeholder="First Name" required>	
													<input type="text" name="mothername_midint" placeholder="Middle Initial" required>	
													<input type="text" name="mothername_last" placeholder="Last Name" required>	
												</div>
											</label>
										</div>
										<label>
											<span>GUARDIAN'S NAME:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="guar_name" required>
										</label>
										<label>
											<span>GUARDIAN'S TELEPHONE NUMBER: </span>
											<input type="text" name="guar_telno">
										</label>
										<label>
											<span>GUARDIAN'S CELLPHONE NUMBER:<span class="required">&nbsp;*</span> </span>
											<input type="text" name="guar_mobno" required>
										</label>
									</div>
									<div class="form-row requirements">
										<div class="hd">
											<h3>
												OTHER INFORMATION
											</h3>
										</div>
										<label>
											<span>STATUS:<span class="required">&nbsp;*</span> </span>
											<select name="enroll-status" id="">
												<option value="Officially Enrolled">Officially Enrolled</option>
												<option value="Temporarily Enrolled">Temporarily Enrolled</option>
											</select>
										</label>
										<label>
											<span>ACCOUNT CREATION FOR: <span class="required">&nbsp;*</span> </span>
											<div class="parent-account">
												<span><input type="radio" name="par_account" value="Mother" required/>Mother</span>
												<span><input type="radio" name="par_account" value="Father"/>Father</span>
											</div>
										</label>
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
