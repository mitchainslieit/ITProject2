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
					<style>
					*{
						margin: 0;
						padding: 0;
						box-sizing: border-box;
					}
					body{
						font-family: sans-serif;
					}
					a:link,
					a:visited{
						text-decoration: none;
					}
					.modal{
						background-color: rgba(0,0,0, .8);
						width:100%;
						height: 100vh;
						position: absolute;
						top: 0;
						left: 0;
						z-index: 10;
						opacity: 0;
						visibility: hidden;
						transition: all .5s;
						position: fixed;
					}
					.modal__content{
						width: 75%;
						height: 65%;
						background-color: #fff;
						position: absolute;
						top: 50%;
						left: 50%;
						transform: translate(-50%, -50%);
						padding: 2em;
						opacity: 0;
						visibility: hidden;
						transition: all .5s;
						overflow: hidden;
						overflow-y: auto;
					}
					#modal:target{
						opacity: 1;
						visibility: visible;
						overflow: hidden;
						position: fixed;
						overflow-y: scroll;
					}
					#modal:target .modal__content{
						opacity: 1;
						visibility: visible;
					}
					.modal__close{
						color: #363636;
						font-size: 2em;
						position: absolute;
						top: .5em;
						right: 1em;
					}
					.modal__heading{
						color: dodgerblue;
						margin-bottom: 1em;
					}
					.modal__paragraph{
						line-height: 1.5em;
					}
					.modal-open{
						display: inline-block;
						color: dodgerblue;
						margin: 2em;
					}
					.button{
						background: #0089DA; 
						border: none; 
						color: #fff;
						padding: 7px 12px;
						letter-spacing: 1px;}	
					}
				</style>
				<a href="#modal" class="modal-open"><button>Open Modal</button></a>

				<div class="modal" id="modal">
					<div class="modal__content">
						<a href="#" class="modal__close">&times;</a>
						<h2 class="modal__heading">Desi Developer</h2>
						<p class="modal__paragraph">CONTENT HERE!!!!!!!!!!!!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-dollar-sign"></i>
					<span>Total Amount Collected</span>
				</p>
			</div>	
			<div class="eventcontent">
				<div class="cont3">
					<div class="table-scroll">	
						<div class="table-wrap">	
							<table>
								<tr>
									<th>Grade</th>
									<th>PTA</th>
									<th>Utility</th>
									<th>School Paper</th>
									<th>Org. Fee</th>
									<th>Techno Fee (TLE)</th>   
									<th>Service Fee</th>   
									<th>Supreme Student Gov't</th>   
									<th>Internet of Students</th>   
								</tr>
								<tr>
									<th>Grade 7</th>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>   
								</tr>
								<tr>
									<th>Grade 8</th>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>   
								</tr>
								<tr>
									<th>Grade 9</th>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>  
								</tr>
								<tr>
									<th>Grade 10</th>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
									<td>1000</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

