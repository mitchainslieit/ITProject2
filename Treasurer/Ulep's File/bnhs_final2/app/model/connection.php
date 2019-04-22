<?php
class Connection {

	public function connect() {
		return new PDO ("mysql:host=192.168.254.106; dbname=bnhs","bnhs","bnhs");
	}

}
?>