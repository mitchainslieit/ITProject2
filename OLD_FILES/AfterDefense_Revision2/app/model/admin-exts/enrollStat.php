<?php
//update.php

if(isset($_POST['hidden_enroll_privilege']))
{
	$connect = new PDO("mysql:host=localhost; dbname=bnhs_test4","root","");
	$query = "UPDATE faculty SET enroll_privilege=:enroll_privilege WHERE fac_id=:fac_id";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':enroll_privilege'  => $_POST['hidden_enroll_privilege'],
			':fac_id' => $fac_id
		)
	);

	$result = $statement->fetchAll();
	if(isset($result))
	{
		echo 'done';
	}
}

?>