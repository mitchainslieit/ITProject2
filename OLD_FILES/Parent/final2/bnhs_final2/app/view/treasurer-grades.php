	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-book-open fnt"></i>
						<span>Grades</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="eventcontent">
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>

					<script type="text/javascript">
						google.load('visualization', '1', {packages: ['corechart', 'bar']});
						google.setOnLoadCallback(drawMaterial);

						function drawMaterial() {
							var data = google.visualization.arrayToDataTable([
								['Country', 'New Visitors', 'Returned Visitors'],
								<?php 
								$query = "SELECT count(ip) AS count, country FROM visitors GROUP BY country";

								$exec = mysqli_query($con,$query);

								while($row = mysqli_fetch_array($exec)){

									echo "['".$row['country']."',";
									$query2 = "SELECT count(distinct ip) AS count FROM visitors WHERE country='".$row['country']."' ";
									$exec2 = mysqli_query($con,$query2);
									$row2 = mysqli_fetch_assoc($exec2);

									echo $row2['count'];



									$rvisits = $row['count']-$row2['count'];

									echo ",".$rvisits."],";
								}
								?>
								]);

							var options = {

								title: 'Country wise new and returned visitors',

								bars: 'horizontal'
							};
							var material = new google.charts.Bar(document.getElementById('barchart'));
							material.draw(data, options);
						}
					</script>
					
					<div id="barchart" style="width: 900px; height: 500px;"></div>
				</div>
			</div>
		</div>
	</div>
