<?php

//update.php

$connect = new PDO('mysql:host=localhost;dbname=bnhs_v4', 'root', '');

if(isset($_POST["id"]))
{
	$query = "UPDATE announcements SET title=:title, date_start=:date_start, date_end=:date_end WHERE ann_id=:ann_id";
	$statement = $connect->prepare($query);
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