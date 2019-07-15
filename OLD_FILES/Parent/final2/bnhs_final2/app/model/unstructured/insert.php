<?php

$connect = new PDO('mysql:host=localhost;dbname=bnhs', 'root', '');
if(isset($_POST["title"])) {
 $query = " INSERT INTO announcements  (title, date_start, date_end)  VALUES (:title, :date_start, :date_end) ";
 $statement = $connect->prepare($query);
 $statement->execute( array( ':title'  => $_POST['title'], ':date_start' => $_POST['start'], ':date_end' => $_POST['end'] ) );
}

?>