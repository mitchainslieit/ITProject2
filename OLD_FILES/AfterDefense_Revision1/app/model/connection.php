<?php
class Connection {

	public function connect() {
		return new PDO ("mysql:host=localhost; dbname=db_afterdef_v1","root","");
	}

}
?>