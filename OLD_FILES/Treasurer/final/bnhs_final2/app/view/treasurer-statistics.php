<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>

<script type="text/javascript">
   google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = google.visualization.arrayToDataTable([
        ['Budget Name', 'Total Collected Payment'],
        <?php $run->getStatistics() ?>
      ]);

      var options = {
        title: 'Payment Collected per Breakdown',
        chartArea: {width: '60%', height: '65%'},
        hAxis: {
          title: 'Total Payment Collected',
          minValue: 0
        },
        vAxis: {
          title: 'Budget Name'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

</script>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-signal fnt"></i>
						<span>Statistics</span>
					</p>
				</div>	
				<div class="eventcontent">
					<div class="cont2">
                     <div id="chart_div">
                        
                     </div>
               </div>
			</div>
			</div>
		
	<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-dollar-sign"></i>
					<span>Total Amount Collected</span>
				</p>
			</div>	
			<div class="eventcontent statementContent">
				<div class="widgetContent">
               <div class="cont1">
                  <p>Grade Level: </p> &nbsp;
                  <select name="year_level" class="year_level">
                     <option value="All">All</option>
                     <option value="Grade 7">Grade 7</option>
                     <option value="Grade 8">Grade 8</option>
                     <option value="Grade 9">Grade 9</option>
                     <option value="Grade 10">Grade 10</option>   
                  </select>
               </div>
					<div class="cont2">
						<table id="treasurer-table-1" class="display">
							<thead>	
								<tr>
									<?php
										foreach($run->getStats() as $row) {
											extract($row);
											echo 
											'
											 <th> '.$budget_name.' </th>
											';
										}
									?>
								</tr>
							</thead>
							<tbody>
                        <tr>
								<?php
                              foreach($run->getStats() as $row) {
                                 extract($row);
                                 echo 
                                 '
                                  <td> &#x20B1;'.number_format($sum,2).' </td>
                                 ';
                              }
                           ?>
                        </tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
   </div>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



