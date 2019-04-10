<?php
$conn = new PDO('mysql:host=localhost;dbname=bnhs_v5', 'root', '');
if(isset($_POST["title"]))
{
	$query = "INSERT INTO announcements (title, date_start, date_end) VALUES (:title, :date_start, :date_end)";
	$statement = $conn->prepare($query);
	$statement->execute(
		array(
			':title'  => $_POST['title'],
			':date_start' => $_POST['start'],
			':date_end' => $_POST['end']
		)
	);
}
?>