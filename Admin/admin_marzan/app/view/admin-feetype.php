	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Fee Type</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<button>Add a fee type <i class="fas fa-plus fnt"></i></button>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>Fee Type</th>
									<th>Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php
 foreach($obj->showSingleTable("budget_info") as $value){
 extract($value);
 echo <<<show
 <tr>
	<td>$budget_name</td>
	<td>$acc_amount</td>
	<td></td>
</tr>
show;
}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
