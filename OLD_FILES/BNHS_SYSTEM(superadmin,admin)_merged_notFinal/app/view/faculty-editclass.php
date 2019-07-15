<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct() ?>
<?php
	if(isset($_POST['submit-classes'])) {
		$getFactFunct->setSchedule($_POST);
	} else if (isset($_POST['submit-edit-class'])) {
		$getFactFunct->insertUpdateGetSubj($_POST);
	} else if (isset($_POST['remove-this-schedule'])) {
		$getFactFunct->deleteSched($_POST);
	}
?>
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	<i class="fas fa-user-plus fnt"></i><span> Edit Class</span></p>
				<p>School Year: 2019-2020</p>
			</div>	
			<div class="editContent widgetcontent">
				<div class="cont3">
					<div class="table-scroll">
						<div class ="cont fl">
							<span>SECTION : </span>
							<select name="sec_id" id="getCurrentLevel">
								<?php $getFactFunct->showSections(); ?>
							</select>
						</div>
						<?php $getFactFunct->showTabledSections(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>