<?php
class Connection {

	public function connect() {
		return new PDO ("mysql:host=192.168.254.112; dbname=bnhs_test","bnhs_server","");
	}

}
?>