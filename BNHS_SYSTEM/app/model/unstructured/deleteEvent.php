<?php
require '../connection.php';
class deleteCalendarEvent {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function deleteEvent() {
		if(isset($_POST["id"]))
		{
			$query = "DELETE from announcements WHERE ann_id=:ann_id";
			$statement = $this->conn->prepare($query);
			$statement->execute(
				array(
					':ann_id' => $_POST['id']
				)
			);
		}
	}
}
$deleteCalendarEvent = new deleteCalendarEvent;
$deleteCalendarEvent->deleteEvent();
?>