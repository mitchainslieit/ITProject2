<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>		
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-book fnt"></i>
						<span>History of the Miscellaneous Fees</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="eventcontent">
					<div class="cont1">
						<p>Miscellaneous Fee: <span>&#x20B1; <?php $run->getMiscellaneousFee(); ?></span></p>
					</div>
					<div class="modal" id="modal">
					<table id="treasurer-table-1" class="display">
						<thead>	
							<tr>
								<th>LRN</th>
								<th>Student Name</th>
								<th> Initial Balance </th>
								<th> Current Balance </th>
								<th> Amount Paid </th>
								<th> Payment Date </th>
							</tr>
						</thead>
						<tbody>
							<?php $run->getPaymentHistory() ?>
						</tbody>
					</table>
				</div>
					</div>
			</div>
		</div>
	</div>

