<?php
require '../connection.php';
class deleteCalendarEvent {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}
	public function insertLogs($log_event, $log_desc){
		try {
			$admin_id=$_SESSION['accid'];
			$sql3=$this->conn->prepare("INSERT INTO logs SET log_event=:log_event, log_desc=:log_desc, user_id=:user_id");
			$sql3->execute(array(
				':log_event' => $log_event, 
				':log_desc' => $log_desc, 
				':user_id' => $admin_id
			)); 	
		}catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}

	public function deleteEvent() {
		if(isset($_POST["id"]))
		{
			$sql2=$this->conn->prepare("SELECT * from announcements WHERE ann_id=:ann_id");
			$sql2->execute(array(
				':ann_id' => $ann_id
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$title2=$row2['title'];
			$post2=$row2['post'];
			
			$query = "DELETE from announcements WHERE ann_id=:ann_id";
			$statement = $this->conn->prepare($query);
			$statement->execute(
				array(
					':ann_id' => $_POST['id']
				)
			);
			$log_event="Delete";
			$log_desc="Deleted the event '".$title2. "'";
			$this->insertLogs($log_event, $log_desc);
		}
	}
}
$deleteCalendarEvent = new deleteCalendarEvent;
$deleteCalendarEvent->deleteEvent();
?>