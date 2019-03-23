<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>  
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-book-open fnt"></i>
					<span>Child's Grades</span>
				</p>
				<p>School Year: 2019-2020</p>
			</div>	
			<div class="eventcontent">
				<div class="cont3">
					<div class="table-scroll">  
						<div class="table-wrap">  
							<table>
								<tr>
									<th>Subject</th>
									<th>1st Grading</th> 
									<th>2nd Grading</th>  
									<th>3rd Grading</th>
									<th>4rd Grading</th>
									<th>Final Grade</th>
								</tr>
								<tr>
									<?php $run->getChildGrade(); ?>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!-- <div class="cont1">
					<button id="opener" class="customButton">Update <i class="fas fa-plus fnt"></i></button>
					<div id="dialog" title="PAYMENT TRANSACTION">
						<span>LRN Number: </span><br>
						<span>Student Name: </span><br>
						<span>Balance: </span><br>
						<center><span>-----------------------------------------------------------------------------------------------</span></center><br>
						<form action="admin-faculty" method="POST" required>
							<span>PTA</span>
							<input type="text" name="pta_fee" value="" placeholder="PTA" required>
							<p></p>
							<span>Utility</span>
							<input type="text" name="utility_fee" value="" placeholder="Utility" required>
							<p></p>
							<span>School Paper</span>
							<input type="text" name="school_Fee" value="" placeholder="School Paper" required>
							<p></p>
							<span>Org. Fee</span>
							<input type="text" name="org_fee" value="" placeholder="Org. Fee" required>
							<p></p>
							<span>Techno (TLE)</span>
							<input type="text" name="techno_fee" value="" placeholder="Techno (TLE)" required>
							<p></p>
							<span>Science Fee</span>
							<input type="text" name="science_fee" value="" placeholder="Science Fee" required>
							<p></p>
							<span>Supreme Student Government</span>
							<input type="text" name="ssg_fee" value="" placeholder="Supreme Student Gov't" required>
							<p></p>
							<span>Internet for Students</span>
							<input type="text" name="internet_fee" value="" placeholder="Internet for Students" required>
							<center><span>-----------------------------------------------------------------------------------------------</span></center><br>
							<center><button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							<button name="cancel-button" class="customButton">Cancel<i class="fas fa-ban fnt"></i></button></center>
						</form>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</div>

