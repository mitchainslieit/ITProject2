<?php
require '../connection.php';
class updateCalendarEvent {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function updateEvent() {
		if(isset($_POST["id"]))
		{
			$query = "UPDATE announcements SET title=:title, date_start=:date_start, date_end=:date_end WHERE ann_id=:ann_id";
			$statement = $this->conn->prepare($query);
			$statement->execute(
				array(
					':title'  => $_POST['title'],
					':date_start' => $_POST['start'],
					':date_end' => $_POST['end'],
					':ann_id'   => $_POST['id']
				)
			);
		}
	}
}
$updateCalendarEvent = new updateCalendarEvent;
$updateCalendarEvent->updateEvent();
?>