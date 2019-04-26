<?php
if(isset($_POST["id"]))
{
	/*$conn = new PDO("mysql:host=192.168.254.106; dbname=bnhs","bnhs","bnhs");*/
	$conn = new PDO("mysql:host=localhost; dbname=bnhs","root","");
	$query = "DELETE from announcements WHERE ann_id=:ann_id";
	$statement = $conn->prepare($query);
	$statement->execute(
		array(
			':ann_id' => $_POST['id']
		)
	);
}

?>
