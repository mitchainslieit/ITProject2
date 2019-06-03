<?php
class Connection {

	public function connect() {
		// return new PDO ("mysql:host=localhost; dbname=final3","root","");
		return new PDO ("mysql:host=192.168.254.105; dbname=bnhs_test","bnhs_server","");
	}

}
?>