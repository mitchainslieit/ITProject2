<?php
if(isset($_POST["id"]))
{
	$conn = new PDO("mysql:host=192.168.254.111; dbname=bnhs_final","bnhs","bnhs");
	$query = "DELETE from announcements WHERE ann_id=:ann_id";
	$statement = $conn->prepare($query);
	$statement->execute(
		array(
			':ann_id' => $_POST['id']
		)
	);
}

?>