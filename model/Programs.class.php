<?php
// begin ProgramVO Class
class ProgramVO {
    
	private $swda_program_id;
	private $swda_program;
    
    public function __construct() {}

	// setters
    public function setswda_program_id($swda_program_id) {
    	$this->swda_program_id = $swda_program_id;
    }
	 public function setswda_program($swda_program) {
    	$this->swda_program = $swda_program;
    }
   
	// getters
	public function getswda_program_id() {
	return $this->swda_program_id;
    }
	public function getswda_program() {
	return $this->swda_program;
    }
 
} 
//end of ProgramVO class
?>

<?php
// begin ProgramDAO Class
class ProgramDAO extends DAO {

	public function getProgramList(){ 
		// get all Programs from database
		$sql = "SELECT swda_program_id,swda_program FROM lib_swda_programs order by swda_program asc";
	
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
	
		$ProgramList = array(new ProgramVO());
		
			$removetrash= array_pop($ProgramList);
			
			foreach($result as $i=>$row) {
				$ProgramItem = new ProgramVO();
				$ProgramItem->setswda_program_id($row['swda_program_id']);
				$ProgramItem->setswda_program($row['swda_program']);
				$ProgramList[$i] = $ProgramItem;
			}
						
		$this->closeDB();
	
		return $ProgramList;
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
//end of ProgramDAO class

?>
