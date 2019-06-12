<?php
require '../connection.php';
class LoadCalendar {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getEvents() {
		$data = array();
		$query = "SELECT * FROM announcements WHERE post_adminid IS NOT NULL ORDER BY ann_id AND title IS NOT NULL";
		$statement = $this->conn->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		foreach($result as $row) {
			$data[] = array(
				'id'   => $row["ann_id"],
				'title'   => $row["title"],
				'start'   => $row["date_start"],
				'end'   => $row["date_end"]
			);
		}

		echo json_encode($data);
	}
}
$loadCalendar = new LoadCalendar;
$loadCalendar->getEvents();
?>