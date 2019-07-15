<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>

<?php
  if(isset($_POST['end_school_year'])){
  	$run->endFunctionFirst();
  }
?>
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-th"></i>
					<span> Summary of Payment Transactions </span>
				</p>
				<p>School Year: <?php $run->getSchoolYear(); ?> </p>
			</div>	
			<div class="widgetcontent">
				<form action="treasurer-end-trial" id="treasurer-end-trial" method="POST">
					<br>
					<br>
					<input type="hidden" name="end_school_year" value="end_year"/>
					<button name="end_year" type="submit" class="customButton"> END SCHOOL YEAR </button>
				</form>
			</div>
		</div>	
	</div>	
</div>