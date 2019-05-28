<?php
class Connection {

	public function connect() {
		return new PDO ("mysql:host=192.168.254.105; dbname=bnhsfinal","bnhs_server","");
	}

}
?>