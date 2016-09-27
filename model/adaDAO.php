<?php

class adaDAO extends DAO {

	
	public function getVoucherAmount($adaRefID){ //
	$sql = "SELECT DISTINCT adaRefID, sum(CkGross) as totalGrossAmount, sum(CkTax) as totalTaxAmount, sum(CkAmount) as totalNetAmount
		FROM checks
		where adaRefID = :adaRefID";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':adaRefID',  $adaRefID);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalGrossAmount"=>$row["totalGrossAmount"],
					"totalTaxAmount"=>$row["totalTaxAmount"],
					"totalNetAmount"=>$row["totalNetAmount"],
					"adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getAdaTotalAmount($adaRefID){ //
	$sql = "SELECT adaRefID, adaGrossAmt, adaNetAmt, adaTaxAmt
			FROM lib_ada
			where adaRefID = :adaRefID";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':adaRefID',  $adaRefID);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"adaGrossAmt"=>$row["adaGrossAmt"],
					"adaTaxAmt"=>$row["adaTaxAmt"],
					"adaNetAmt"=>$row["adaNetAmt"],
					"adaRefID"=>$row["adaRefID"],
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
