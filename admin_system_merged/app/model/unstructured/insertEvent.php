
<?php
require '../connection.php';
class insertCalendarEvent {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function insertEvent() {
		$admin_id = $_SESSION['accid'];
		var_dump($admin_id);
		if(isset($_POST["title"]))
		{
			$query = "INSERT INTO announcements (title, date_start, date_end, post_adminid) VALUES (:title, :date_start, :date_end, :post_adminid)";
			$statement = $this->conn->prepare($query);
			$statement->execute(
				array(
					':title'  => $_POST['title'],
					':date_start' => $_POST['start'],
					':date_end' => $_POST['end'],
					':post_adminid' => $admin_id
				)
			);
		}
	}
}
$insertCalendarEvent = new insertCalendarEvent;
$insertCalendarEvent->insertEvent();
?>