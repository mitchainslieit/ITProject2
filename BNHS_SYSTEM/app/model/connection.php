<?php
class Connection {

	public function connect() {
		return new PDO ("mysql:host=192.168.254.111; dbname=bnhs_final","bnhs","bnhs");
	}

}
?>