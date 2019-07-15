<?php 
require '../connection.php';
class AdminAjax {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getNotif(){
		$sql = $this->conn->prepare("SELECT *, DATE_FORMAT(log_date,'%b %d, %Y') AS 'new_date' FROM logs WHERE towhom = :us ORDER BY seen_unseen DESC, log_id DESC");
		$sql->execute(array(':us' => $_SESSION['accid']));
		$sql2 = $this->conn->prepare("SELECT *, DATE_FORMAT(log_date,'%b %d, %Y') AS 'new_date' FROM logs WHERE towhom = :us AND seen_unseen = 'Unseen' ORDER BY seen_unseen DESC, log_id DESC");
		$sql2->execute(array(
			':us' => $_SESSION['accid']
		));
		$result = $sql->fetchAll();
		$_SESSION['adminNotif'] = $sql2->rowCount();
		$data = array();
		$data['addthis'] = array();
		foreach($result as $row) {
			$html = '';
			if (strpos($row['log_desc'], 'Reject') !== false) {
				$temp = str_replace('Reject ', '', $row['log_desc']);
			}
			$requestType = function($type) {
				if ($type === 'Insert') {
					return 'Add';
				} else {
					return $type;
				}
			};
			$request_desc = 'Request to '.$requestType($row['log_event']).' '.(empty($temp) ? $row['log_desc'] : $temp).'.';
			if ($row['seen_unseen'] === 'Unseen') {
				$html .= '<tr style="background: rgba(0, 0, 0, 0.05);">';
			} else {
				$html .= '<tr>';
			}
			if (strpos($row['log_desc'], 'Reject') !== false) {
		    	$html .= '<td class="text-left" style="padding: 0 18px;">'.$request_desc.'</td>';
		    	$html .= '<td>Rejected</td>';
		    	$html .= '<td>'.$row['seen_unseen'].'</td>';
		    	$html .= '<td>'.$row['new_date'].'</td>';
			} else {
				$html .= '<td class="text-left" style="padding: 0 18px;">'.$request_desc.'</td>';
				$html .= '<td>Accepted</td>';
				$html .= '<td>'.$row['seen_unseen'].'</td>';
				$html .= '<td>'.$row['new_date'].'</td>';
			}
			$html .= '</tr>';
			$data['addthis'][] = $html;
		}
		$data['response'] = $_SESSION['adminNotif'];
		echo json_encode($data);
	}
}

/* OUTSIDE THE CLASS */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$run = new AdminAjax;
if(isset($_GET['data']) && $_GET['data'] === 'getNotif') $run->getNotif();
?>