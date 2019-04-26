<?php

//update.php

$conn = new PDO("mysql:host=localhost; dbname=bnhs","root","");
/*$conn = new PDO("mysql:host=192.168.254.106; dbname=bnhs","bnhs","bnhs");*/

if(isset($_POST["id"]))
{
	$query = "UPDATE announcements SET title=:title, date_start=:date_start, date_end=:date_end WHERE ann_id=:ann_id";
	$statement = $conn->prepare($query);
	$statement->execute(
		array(
			':title'  => $_POST['title'],
			':date_start' => $_POST['start'],
			':date_end' => $_POST['end'],
			':ann_id'   => $_POST['id']
		)
	);
}

?>