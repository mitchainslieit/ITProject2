  <?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
  <div class="contentpage">
  	<div class="row">  
  		<div class="attendance widget">
  			<div class="innercont1">
  				<div class="header">
  					<p> 
  						<i class="fas fa-book fnt"></i>
  						<span>Attendance Report</span>
  					</p>
  				</div>
  				<div class="eventcontent">
  					<a href="<?php echo URL ?>"><img src="public/images/common/logo.png"></a>

  					<div class="table-scroll ">  
  						<div class="table-wrap">  
  							<table>
  								<tr>
  									<td>Name </td>
  									<td><?php $run->getChildName(); ?></td>
  								</tr>
  								<tr>
  									<td>Grade Level & Section</td>
  									<td><?php $run->getChildLevel(); ?> - <?php $run->getChildSection(); ?> </td>
  								</tr>
  								<tr>
  									<td>Number of Days Present</td>
  									<td><?php $run->getNoOfDaysPresent(); ?></td>
  								</tr>
  								<tr>
  									<td>Number of Days Absent</td>
  									<td><?php $run->getNoOfDaysAbsent(); ?></td>
  								</tr>
  							</table>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>

