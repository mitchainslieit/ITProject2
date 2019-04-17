<?php
/*$conn = new PDO("mysql:host=192.168.254.106; dbname=bnhs","bnhs","bnhs");*/
$conn = new PDO("mysql:host=192.168.254.106; dbname=bnhs","bnhs","bnhs");
$data = array();
$query = "SELECT * FROM announcements ORDER BY ann_id";
$statement = $conn->prepare($query);
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