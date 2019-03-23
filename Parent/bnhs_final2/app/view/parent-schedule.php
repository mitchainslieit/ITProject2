	<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-clipboard-list fnt"></i>
						<span>Class Schedule</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="eventcontent">
					<div class="cont3"
					<div class="table-scroll">	
						<div class="table-wrap">	
							<table>
								<tr>
									<th>Time (AM-PM)</th>
									<th>Subject</th>
									<th>Day</th> 
								</tr>
								<tr>
									<?php $run->getChildSchedule(); ?>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
