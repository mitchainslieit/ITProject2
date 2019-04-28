<?php
if(isset($_POST["id"]))
{
	/*$conn = new PDO("mysql:host=192.168.254.111; dbname=bnhs_final","bnhs","bnhs");*/
	$conn = new PDO("mysql:host=localhost; dbname=bnhs_final","root","");
	$query = "DELETE from announcements WHERE ann_id=:ann_id";
	$statement = $conn->prepare($query);
	$statement->execute(
		array(
			':ann_id' => $_POST['id']
		)
	);
}

?>
<?php
require '../connection.php';
class LoadCalendar {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getEvents() {
		$query = "DELETE from announcements WHERE ann_id=:ann_id";
		$statement = $this->conn->prepare($query);
		$statement->execute(
			array(
				':ann_id' => $_POST['id']
			)
		);
	}
}
$deleteEvent = new deleteEvent;
$deleteEvent->getEvents();
?>