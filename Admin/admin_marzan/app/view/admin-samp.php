	<div class="contentpage">
		<div class="row">
			<h1> On Click Insert Radio Button Value into Database</h1>
			<input type="radio" name="gender" value="Male">Male<br/><br/>
			<input type="radio" name="gender" value="Female">Female<br/><br/>
			<input type="radio" name="gender" value="Others">Others<br/>
			<h3 id="result"></h3>
			<br/>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('input[type="radio"]').click(function(){
				var gender = $(this).val();
				$.ajax({
					url:"insert.php",
					method:"POST",
					data:{gender:gender},
					success: function(data){
						$('#result').html(data);
					}
				});
			});
		});
	</script>
