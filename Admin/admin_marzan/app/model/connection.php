<?php
class Connection {

	public function connect() {
		return new PDO ("mysql:host=localhost; dbname=bnhs_v5","root","");
	}
}
?>