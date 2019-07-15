<?php
class Connection {

	public function connect() {
		// return new PDO ("mysql:host=localhost; dbname=final3","root","");
		return new PDO ("mysql:host=localhost; dbname=bnhs_test4","root","");
	}
}
?>