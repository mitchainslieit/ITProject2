	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
	<div class="contentpage">
		<div class="row">	
			<div class="print-container widget">
				<div class="header">
					<p>
	                    <i class="fas fa-money-bill-alt"></i>
	                    <span>Breakdown of Fees</span>
	                </p>
	            </div>
	            <div class="assessmentContent widgetcontent">
	            	<div class="cont">
	            		<h2>Bakakeng National High School</h2>
	            	</div>
	            	<div class="cont1">
	            		<div class="box1">
		            		<span>NAME: <?php $getFactFunct->getName(); ?></span>
		                    <span>DATE: <?php $getFactFunct->getDate(); ?></span> 
		                </div>
	            		<div class="box2">
	            			<span>LEARNER REFERENCE No. (LRN): <?php $getFactFunct->getLRN(); ?></span>
	                    	<span>GRADE LEVEL: <?php $getFactFunct->getGradeLevel(); ?></span>
	                    </div>
	                    <div class="box3">
	                    	<span>USERNAME: <?php  ?></span>
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
		</div>
    </div>