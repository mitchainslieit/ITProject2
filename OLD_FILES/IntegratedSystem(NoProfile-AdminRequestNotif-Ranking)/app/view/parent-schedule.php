	<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-clipboard-list fnt"></i>
						<span>Class Schedule</span>
					</p>
					
					<p>School Year: <?php $run->getSchoolYear(); ?></p>
				</div>	
				<div class="eventcontent schedule">
					<div class="sample">
                        <div class="tl"><b>Child Name:</b>
                            <select name="student" class="student" id="select-child-schedule">
                                <?php 
							foreach($run->getNameOfStud() as $row) {
								extract($row);
								echo '
								<option value="'.$stud_lrno.'" name="stud_name"> '.$name.' - '.$section.'  </option>
								';
							}
							?>
                            </select>
                        </div>
                    </div>
                    <br>
					<div class="cont3">
						<div class="table-scroll"> 
							<div class="table-wrap" id="table-children-schedule" class="display">
								<?php foreach($run->getNameOfStud() as $row) { ?>
									<?php $run->getChildSchedule($row['stud_lrno']); ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>