<?php
if(isset($_POST["id"])) {
	$connect = new PDO('mysql:host=localhost;dbname=bnhs', 'root', '');
	$query = "DELETE from announcements WHERE ann_id=:ann_id";
	$statement = $connect->prepare($query);
	$statement->execute(array(':ann_id' => $_POST['id']));
}
?>