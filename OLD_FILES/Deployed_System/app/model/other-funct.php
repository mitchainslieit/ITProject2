<?php 
class OtherMethods {
	/*
	* Title ~ Title of the prompt
	*
	*/
	public function Message($title, $message, $type, $page) {
		if ($type == 'error') {
			$newUrl = URL.$page;
			echo "<script>
				swal({
					title: \"".$title."\",
					text: \"".$message."\",
					icon: \"".$type."\"
				});
			</script>";
		} else {
			$newUrl = URL.$page;
			echo "<script>
				swal({
					title: \"".$title."\",
					text: \"".$message."\",
					icon: \"".$type."\"
				}).then(function() {
					 window.location = '".$newUrl."';
				});
			</script>";
		}
	}



}
?>