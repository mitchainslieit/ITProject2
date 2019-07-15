<?php require 'app/model/connection.php';
	$conn = new Connection();
	$sqlCon = $conn->connect();
?>
	<div class="contentpage">
		<div class="row">
			<div class="summary">
				<div class="head">
					<img src="public/images/common/logo.png" class="fl">
					<p class="fl">Bakakeng National High School </p> 
					<p class="text-left"> </br>&nbsp;&nbsp;&nbsp; Student Portal </p>
				</div>
			</div>

				<div class="eventwidget">
				<div class="contleft">
					<div class="header">
						<p>	
							<i class="fas fa-scroll"></i>
							<span>Announcements</span>
						</p>
					</div>
					<div class="cont">		
						<div class="conthead">
							<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Announcement from teacher/adviser:</p>
						</div>
						<?php
							/*$sqlquery = "SELECT 
    							subject.subj_name 'Subject Name',
    							concat(fac_fname,' ',fac_lname),
    							an.post 'Notes',
    							an.attachment
							FROM
    							announcements an
        							JOIN
    							faculty f ON an.post_facid = f.fac_id
        							JOIN
    							schedsubj ss ON f.fac_id = ss.fac_idw
        							JOIN
    							subject ON subject.subj_id = ss.subja_id;";
    						$result = $sqlCon->query($sqlquery);
    						$getRowNum = $result->rowCount();
    						if ($getRowNum > 0) {
    							while($row = $result->fetch()) {
    								echo '<div class="continue">
    										<form> 
    											<label><span>Subject:</span>
    												<input type="text" name="" value="'.$row[0].'"disabled>
    											</label>
    											<label><span>Teacher:</span>
    												<input type="text" name="" value="'.$row[1].'"disabled>
    											</label>
    											<label><span>Notes:</span>
    												<input type="text" name="" value="'.$row[2].'"disabled>
    											</label>
    										</form>
    									  </div>';
	    							}
    						}*/
						?>
					</div>
				</div>
				<div class="contright">
					<div class="innercont1">
						<div class="header">
							<p>	
								<i class="fas fa-user fnt"></i>
								<span>Student Status</span>
							</p>
						</div>
						<div class="eventcontent">
							<div class="echead">
								<p>Status:</p>
							</div>
							<?php 
								$statquery = "select school_year from student";
							?>
							<div class="contin">
								<p>Currently enrolled in this school year: <span class="text-bold">2018-2019</span></p>
								<p><span>Grade 7 - Independence</span></p>
								<p>See <a href="">absences/tardiness!</a></p>
							</div>
							<div class="echead">
								<p>Academic Performance:</p>
							</div>
							<div class="contin">
								<table>
									<tr>
										<th>Grade Level</th>
										<th>Average</th>
										<th>Rank</th>
									</tr>
									<tr>
										<td><span>Grade 10</span></td>
										<td><span>89.10</span></td>
										<td><span>3</span></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="innercont2">
						<div class="header">
							<p>	
								<i class="far fa-calendar-alt fnt"></i>
								<span>Event Calendar</span>
							</p>
						</div>
						<div class="eventcontent">
							
						</div>
					</div>
				</div>
			</div>
			
			<!--<div class="eventwidget">
				<div class="contleft">
					<div class="header">
						<p>
							<i class="fas fa-scroll"></i>
							<span>Announcements</span>
						</p>
					</div>

					<div class="box">
						<p class="fl text-bold">Announcements from advisers/teachers:</p> </br>
					</div>
					<div class="eventcontent">			
						<div class="box box1">
							<div class="sub">
								<p> Subject: <span class="text-bold">Math 4</span> </p>
							</div>
							<div class="sub">
								<p> Teacher: <span class="text-bold">John Doe</span> </p>
							</div>
							<div class="sub">
								<p> Notes: <span class="text-bold">Download the attached file.</span> </p>
							</div>
							<div class="sub">
								<p> Attachment: <span class="text-bold"><a href="">Notes.pdf</span> </p>
							</div>
						</div>
					</div>
				</div>

				<div class="contright">
					<div class="innercont1">
						<div class="header">
							<p>
								<i class="fas fa-user fnt"></i>
								<span>Student Status</span>
							</p>
						</div>
					</div>
				</div>
	
				</div>
			</div> -->

		<!--</div> <!end of row div -->
	<!--</div><!end of contentpage -->

			<!--<div class="box Announcements">
				<div class="aHeader">	
					<p>	<i class="fa fa-bell"></i> <span>&nbsp;&nbsp;Announcements</span></p>
				</div>	

				<div class="aCont">
					<div>
						<span>&nbsp;&nbsp;Announcements from teacher/adviser: </span>
					</div>
					
				</div>
								
				<div class="aContent">
					<div class="box box1">
						<div class="sub">
							<span> Subject:</span> <b>Math 4 </b>
						</div>
						<div class="sub">
							<span> Teacher:</span><b>Jane Doe </b>
						</div>
						<div class="sub">
							<span> Notes:</span>    &nbsp;&nbsp;<b>Download the attached file </b>
						</div>
						<div class="sub1">
							<span> Attachment:</span><a href="" id="sfile"><b>temp1.pdf</b></a>
						</div>
					</div>

					<div class="box box1">
						<div class="sub">
							<span> Subject:</span> <b>Eng 4 </b>
						</div>
						<div class="sub">
							<span> Teacher:</span><b>Chris Doe </b>
						</div>
						<div class="sub">
							<span> Notes:</span>    &nbsp;&nbsp;<b>Download the attached file </b>
						</div>
						<div class="sub1">
							<span> Attachment:</span><a href="" id="sfile"><b>Ch2.pdf</b></a>
						</div>
					</div>

					<div class="box box1">
						<div class="sub">
							<span> Subject:</span> <b>Mapeh 4 </b>
						</div>
						<div class="sub">
							<span> Teacher:</span><b>John Doe </b>
						</div>
						<div class="sub">
							<span> Notes:</span>    &nbsp;&nbsp;<b>Download the attached file </b>
						</div>
						<div class="sub1">
							<span> Attachment:</span><a href="" id="sfile"><b>Ch3.pdf</b></a>
						</div>
					</div>
					
				</div>
			</div> -->

			<!--<div class="box studStatus">
				<div class="ssHeader">	
					<p>	<i class="fa fa-user"></i> <span>&nbsp;&nbsp;Student&nbsp;Status</span></p>
				</div>	

				<div class="statContent">
					<div class="scCont">
						<span><strong>Status:</strong></span>
					</div>

					<div class="statInfo">
						<p>Currently Enrolled in this school year: <span><b>&nbsp;&nbsp;2019-2020</b></span></p>
						<p><span>Grade 7- Independence</span></p>
						<p>See<a href="">&nbsp;&nbsp;absences/tardines</a>
					</div>

					<div class="siCont">
						<span><strong>Academic Performance:</strong></span>
					</div>

					<div class="studAcadPer">
						<div class="cHeader">
							<div class="box box1">
								<h4><b>Grade Level</b></h4>
								<div class="sGrade">
									<p><span>Grade 9</span></p>
									<p><span>Grade 10</span></p>
								</div>
							</div>
							<div class="box box2">
								<h4><b>Average</b></h4>
								<div class="sGrade">
									<p><span>99</span></p>
									<p><span>99</span></p>
								</div>
							</div>
							<div class="box box3">
								<h4><b>Rank</b></h4>
								<div class="sGrade">
									<p><span>1</span></p>
									<p><span>1</span></p>

								</div>
							</div>
						</div>
					</div>

				</div>
					
				</div> -->