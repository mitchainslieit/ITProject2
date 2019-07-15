<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

<div class="contentpage">
	<div class="row">
		<div id="widget">
			<div class="header">
				<p><i class="fas fa-file fnt"></i><span> Grades</span></p>
			</div>
			<div class="widgetcontent">
				<p id ="note">Note: If you dont have a grade in a particular subject or grading. Please consult your adviser/teacher.</p>
				<table id="grade">
					<tr>
						<th>Subject</th>
						<th>1st Grading</th>
						<th>2nd Grading</th>
						<th>3rd Grading</th>
						<th>4th Grading</th>
						<th>Final Grade</th>
						<th>Remarks</th>
						<th>Details</th>
					</tr>
						<?php $run->getChildGrade($_SESSION['accid']); ?>
				</table>
			</div>
		</div>
		<p style="text-align:left; color:blue;font-weight: 600; font-size: 18px">LEGEND FOR GRADES</p><br>
            <div class="cont4">
                <table id="legend">
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
                    <tr>
                        <td>Satisfactory</td>
                        <td>80-84</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>Fairly Satisfactory</td>
                        <td>75-79</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>Did Not Meet Expectations</td>
                        <td>74 and below</td>
                        <td><font color="red"><b>Failed</b></font></td>
                    </tr>
                </table>
            </div>
	</div>