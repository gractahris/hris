<?php

class slpSyncDAO extends DAO {

	public function HHExist($HHID){ 
		// get all Programs from database
		$sql = "SELECT count(hh_id) as hhcount from hh_list where hh_id='$HHID'";
	    //echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
	
		$hh_count = $result[0]["hhcount"];
			
		$this->closeDB();
	
		if($hh_count < 1){
			return false;	
		}else{	
			return true;
		}	
	}
	
	public function AddHH($HHID){ 
		// get all Programs from database
		$sql = "insert into hh_list (hh_id) values ('$HHID')";
	    //echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		
		$this->beginTrans();
		$result = $this->executeUpdate();
	
		if($result) {
			$this->commitTrans();
			$this->closeDB();
			return  true; 
		}else{
			$this->rollbackTrans();
			$this->closeDB();
			return false; 
		}
	
		
	}
	
	public function getProgramName($program_id){ 
		// get all Programs from database
		$sql = "SELECT swda_program FROM lib_swda_programs where swda_program_id = :program_id";
	
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryparam(":program_id",$program_id);
		$result = $this->executeQuery();
	
			foreach($result as $i=>$row) {
				$ProgramItem = new ProgramVO();
				$ProgramItem->setswda_program($row['swda_program']);
			}
						
		$this->closeDB();
	
		return $ProgramItem;
	}

} 


?>
