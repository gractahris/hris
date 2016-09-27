<?php

class savingsDAO extends DAO {

	public function getLoanData($ent_loan_ins_id){ 
		
		$sql = "SELECT 
					loan_amount,
					date_first_payment,
					no_of_payments
				from tbl_ent_loan_instance	
				where approved = '1' and ent_loan_ins_id = '$ent_loan_ins_id'";
	    //echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
	
		$loan_data = array(
						"loan_amount"=>$result[0]["loan_amount"],
						"date_first_payment"=>$result[0]["date_first_payment"],
						"no_of_payment"=>$result[0]["no_of_payments"]
					);	
			
		$this->closeDB();
	
		return $loan_data;
			
	}
	
	public function getTotalSavingsPaidToDate($ent_loan_ins_id,$collected_date){ 
		
		$sql = "SELECT 
					sum(amt_capital_build_up_paid) as amt_capital_build_up_paid, 
					sum(amt_emergency_fund_paid) as amt_emergency_fund_paid
				from tbl_savings	
				where 
					collection_status = '2' and 
					ent_loan_ins_id = '$ent_loan_ins_id' and 
					month(date_paid) = month('$collected_date') and
					year(date_paid) = year('$collected_date') 
			";
	    //echo "<br><br>" . $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
	
		$loan_data = array(
						"amt_capital_build_up_paid"=>$result[0]["amt_capital_build_up_paid"],
						"amt_paid_to_date"=>$result[0]["amt_paid_to_date"]
					);	
			
		$this->closeDB();
	
		
		return $loan_data;
			
	}
	
	public function getTotalSavingsToDate($ent_loan_ins_id,$savings_date){ 
		
		$sql = "SELECT 
					sum(amt_principal_paid) as amt_paid_to_date
				from tbl_payment	
				where 
					payment_status = '2' and 
					ent_loan_ins_id = '$ent_loan_ins_id' and 
					month(date_paid) = month('$billing_date') and
					year(date_paid) = year('$billing_date') 
			";
	    //echo "<br><br>" . $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
	
		$loan_data = array(
						"amt_paid_to_date"=>$result[0]["amt_paid_to_date"]
					);	
			
		$this->closeDB();
	
		
		return $loan_data;
			
	}
	

} 
?>
