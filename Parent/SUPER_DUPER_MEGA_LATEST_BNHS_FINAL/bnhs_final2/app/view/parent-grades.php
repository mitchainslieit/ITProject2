<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?> 

<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-book-open fnt"></i>
					<span>Child's Grades</span>
				</p>
				<p>School Year: <?php $run->getSchoolYear(); ?></p>
			</div>	
			<div class="eventcontent">
				<div class="cont2">
					<span><b>Note: If your child doesn't have a grade in a particular subject or grading, please consult your child's adviser/teacher.</b></span>
				</div>
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
									<th>Remarks</th>
									<th>Details</th>
								</tr>
								<?php $run->getChildGrade(); ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
			<p style="text-align:left; color:blue;font-weight: 600; font-size: 18px">LEGEND FOR GRADES</p>
				<div class="cont4">
							<table>
								<tr>
									<th>DESCRIPTION</th>
									<th>GRADING</th> 
									<th>REMARKS</th>  
								</tr>
								<tr>
									<td>Outstanding</td>
									<td>90-100</td>
									<td><font color="green"><b>Passed</b></font></td>
								</tr>
									<td>Very Satisfactory</td>
									<td>85-89</td>
									<td><font color="green"><b>Passed</b></font></td>
								</tr>
									<td>Satisfactory</td>
									<td>80-84</td>
									<td><font color="green"><b>Passed</b></font></td>
								</tr>
									<td>Fairly Satisfactory</td>
									<td>75-79</td>
									<td><font color="green"><b>Passed</b></font></td>
								</tr>
									<td>Did Not Meet Expectations</td>
									<td>75 and below</td>
									<td><font color="red"><b>Failed</b></font></td>
								</tr>
							</table>
					</div>
				</div>
			</div>
		</div>
		

