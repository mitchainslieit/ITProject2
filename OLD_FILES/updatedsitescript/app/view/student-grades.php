<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<div class="contentpage">
	<div class="row">
		<div id="widget">
			<div class="header">
				<p><i class="fas fa-file fnt"></i><span> Grades</span></p>
			</div>
			<div class="widgetcontent">
				<p id ="note">Note: If you don't have a grade in a particular subject please wait for teacher to post or consult your adviser/teacher.</p>
				<table id="grade">
                    <thead>
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
                </thead>
                <tbody>
						<?php $run->getChildGrade($_SESSION['accid']); ?>
                </tbody>
                    <tr>
                        <td colspan="5"><b>General Average:</b></td>
                        <?php $run->getGeneralAverage($_SESSION['accid']); ?>
                   </tr>
                   <tr>
                        <td colspan="5"><b>Grade Level Status:</b></td>
                        <?php $run->getPromotion($_SESSION['accid']); ?>
                </tr>
				</table>
			</div>
		</div>
		<p style="text-align:left; color:blue;font-weight: 600; font-size: 18px; padding-left: 15px">LEGEND FOR GRADES</p><br>
            <div class="cont4" style="padding-left: 30px;">
                <table id="legend">
                    <tr>
                        <th>GRADING</th>
                        <th>REMARKS</th>
                    </tr>
                    <tr>
                        <td>90-100</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
	                    <td>85-89</td>
	                    <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>80-84</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>75-79</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>74 and below</td>
                        <td><font color="red"><b>Failed</b></font></td>
                    </tr>
                </table>
            </div>
	</div>