<?php

$connect = new PDO('mysql:host=localhost;dbname=bnhs', 'root', '');
if(isset($_POST["id"]))
{
 $query = "UPDATE announcements  SET title=:title, date_start=:date_start, date_end=:date_end  WHERE ann_id=:id";
 $statement = $connect->prepare($query);
 $statement->execute( array( ':title'  => $_POST['title'], ':date_start' => $_POST['start'], ':date_end' => $_POST['end'], ':id'   => $_POST['id'] ) );
}

?>
