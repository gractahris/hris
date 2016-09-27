<?php

class userDAO extends DAO {

	public function getUserByUserName($username){ //
	$sql = "SELECT uid, username, emp_id
		FROM tbl_user
		where username = :username";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':username',  $username);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"uid"=>$row["uid"],
					"username"=>$row["username"],
					"emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function saveUser($username,$password,$email,$firstName,$middleName,$surname,$extensionname,$user_level,$activate,$emp_id){

		$sql= "INSERT INTO tbl_user(username,password,email,firstName,middleName,surname,extensionname,user_level,activate,emp_id)
		VALUES('".$username."','".
		$password."','".
		$email."','".
		$firstName."','".
		$middleName."','".
		$surname."','".
		$extensionname."','".
		$user_level."','".
		$activate."','".
		$emp_id."');";
		
		echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$this->beginTrans();
				$result = $this->executeUpdate();
			
				if($result) {
					$this->commitTrans();
					$this->closeDB();
					return true; 
				} else {
					$this->rollbackTrans();
					$this->closeDB();
					return false; 
				}
	}

	public function checkEmp($empLastName,$empFirstName,$empMiddleName){ //
	$sql = "SELECT empLastName,empFirstName,empMiddleName,emp_id
			FROM `tbl_employee`
		where empLastName = '".$empLastName."' 
		AND empFirstName = '".$empFirstName."' 
		AND empMiddleName = '".$empMiddleName."'";
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':empLastName',  $empLastName);
	$this->bindQueryParam(':empFirstName',  $empFirstName);
	$this->bindQueryParam(':empMiddleName',  $empMiddleName);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"empLastName"=>$row["empLastName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empFirstName"=>$row["empFirstName"],
					"emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	
}
	
?>
