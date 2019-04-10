<?php
$connect = new PDO('mysql:host=localhost;dbname=bnhs_v5', 'root', '');
$data = array();
$query = "SELECT * FROM announcements ORDER BY ann_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
	$data[] = array(
		'id'   => $row["ann_id"],
		'title'   => $row["title"],
		'start'   => $row["date_start"],
		'end'   => $row["date_end"]
	);
}
echo json_encode($data);

?>