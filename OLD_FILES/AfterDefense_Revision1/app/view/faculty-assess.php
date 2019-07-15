	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
	<?php
		if(isset($_SESSION['latest_enrolled'])) {
			$stud = $getFactFunct->getLatestEnrolled($_SESSION['latest_enrolled']);
			$getAccounts = $getFactFunct->accLatestEnrolled($_SESSION['latest_enrolled']);
		}
	?>
	<div class="contentpage">
		<div class="row">	
				<?php if(isset($_SESSION['latest_enrolled'])) { ?>
				<div class="print-container widget">
					<div class="header">
						<p>
		                    <i class="fas fa-money-bill-alt"></i>
		                    <span>Assessment Fees</span>
		                </p>
		            </div>
		            <div class="assessmentContent widgetcontent">
		            	<div class="cont">
		            		<h2>Bakakeng National High School</h2>
		            	</div>
		            	<div class="cont1">
		            		<div class="box1">
			            		<span>NAME: <?php echo $stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name']; ?></span>
			                    <span>DATE: <?php $getFactFunct->getDate(); ?></span> 
			                </div>
		            		<div class="box2">
		            			<span>LEARNER REFERENCE No. (LRN): <?php echo $stud['stud_lrno'] ?></span>
		                    	<span>GRADE LEVEL: <?php echo $stud['year_level']; ?></span>
		                    </div>
		                    <div class="box3">
		                    	<span>USERNAMES: <?php echo $getAccounts; ?></span>
		                    </div>
		            	</div>
		            	<div class="clearfix"></div>
		                <div class="table-scroll">
		                    <div class="table-wrap">
		                        <table class="centerTable">
		                            <tr>
		                                <th>Breakdown</th>
		                                <th>Amount</th>
		                            </tr>
		                            <?php $getFactFunct->getBreakdownOfFees(); ?>
		                            <tr>
		                                <td><b>TOTAL AMOUNT:</b></td>
		                                <td><b><font color="green"><?php $getFactFunct->getTotalBDOF(); ?></font></b></td>
		                            </tr>
		                        </table>
		                    </div>
		                </div>
		                <div class="sign">
		                	<span>Faculty Signature: ________________________</span>
		                </div>
		            </div>    
				</div>
				<div class="sticky-buttons">
						<button id="print-this">PRINT</button>
				</div>
				<?php } else { ?>
				<?php } ?>
		</div>
    </div>