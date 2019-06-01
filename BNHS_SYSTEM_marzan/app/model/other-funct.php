<?php 
class OtherMethods {
	/*
	* Title ~ Title of the prompt
	*
	*/
	public function Message($title, $message, $type, $page) {
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
?>