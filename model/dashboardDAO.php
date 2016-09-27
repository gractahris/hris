<?php
class dashboardDAO extends DAO {
	public function getprovsByRegion($region){
		$sql = "SELECT 
					a.prov_psgc as prov_psgc,
					a.prov_name as prov_name
				from lib_prov as a 
				inner join lib_region as b  
					on 	a.region_id= b.region_id and 
						b.region_psgc= :region
				order by a.prov_name
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":region",$region);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"prov_psgc"=>$row["prov_psgc"],
						"prov_name"=>$row["prov_name"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}
	public function getmunsByProv($prov){
		$sql = "SELECT 
					a.muni_city_psgc as muni_city_psgc,
					a.muni_city_name as muni_city_name
				from lib_muni_city as a 
				inner join lib_prov as b  
					on 	a.prov_id= b.prov_id and 
						b.prov_psgc= :prov
				order by a.muni_city_name
				";
	    echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":prov",$prov);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"muni_city_psgc"=>$row["muni_city_psgc"],
						"muni_city_name"=>$row["muni_city_name"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}	
	public function getbrgyByMun($mun){
		$sql = "SELECT 
					a.brgy_psgc as brgy_psgc,
					a.brgy_name as brgy_name
				from lib_brgy as a 
				inner join lib_muni_city as b  
					on 	a.muni_city_id= b.muni_city_id and 
						b.muni_city_psgc= :mun
				order by a.brgy_name
				";
	    echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":mun",$mun);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"brgy_psgc"=>$row["brgy_psgc"],
						"brgy_name"=>$row["brgy_name"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}	
	
	public function getOffice(){
		$sql = "SELECT 
					OfficeCode,
					OfficeName
				from offices	
				order by OfficeName
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"OfficeCode"=>$row["OfficeCode"],
						"OfficeName"=>$row["OfficeName"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}

	public function getOfficeByID($office){
		$sql = "SELECT 
					OfficeName
				from offices	
				where OfficeCode = :office
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":office",$office);
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["OfficeName"];
	}

	public function getPPA(){
		$sql = "SELECT 
					PAPID,
					PAPCode,
					PAPDescription
				from papcodes	
				order by PAPCode
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"PAPID"=>$row["PAPID"],
						"PAPCode"=>$row["PAPCode"].", ".$row["PAPDescription"]
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}

	public function getPPAByID($ppa){
		$sql = "SELECT 
					PAPCode,
					PAPDescription
				from papcodes	
				where PAPID = :ppa
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":ppa",$ppa);
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["PAPCode"].", ".$result[0]["PAPDescription"];
	}

	public function getrelationByID($rel_id){
		$sql = "SELECT 
					rel_hh_title
				from lib_rel_hh	
				where rel_hh_id = :rel_id
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":rel_id",$rel_id);
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["rel_hh_title"];
	}	
	public function getregionByPSGC($region_code){
		$sql = "SELECT 
					region_name
				from lib_region	
				where region_psgc = :region_code
				";
	    //echo "<br><br>". $sql . "<br><br>";
		//echo substr($region_code, -9);
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":region_code",substr($region_code, -9));
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["region_name"];
	}	
	public function getprovByPSGC($prov_code){
		$sql = "SELECT 
					prov_name
				from lib_prov	
				where prov_psgc = :prov_code
				";
	    //echo "<br><br>". $sql . "<br><br>";
		//echo substr($region_code, -9);
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":prov_code",substr($prov_code, -9));
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["prov_name"];
	}
	public function getmunByPSGC($mun_code){
		$sql = "SELECT 
					muni_city_name
				from lib_muni_city	
				where muni_city_psgc = :mun_code
				";
	    //echo "<br><br>". $sql . "<br><br>";
		//echo substr($region_code, -9);
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":mun_code",substr($mun_code, -9));
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["muni_city_name"];
	}
	public function getbrgyByPSGC($brgy_code){
		$sql = "SELECT 
					brgy_name
				from lib_brgy	
				where brgy_psgc = :brgy_code
				";
	    //echo "<br><br>". $sql . "<br><br>";
		//echo substr($region_code, -9);
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":brgy_code",substr($brgy_code, -9));
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["brgy_name"];
	}
	public function getExistingTargets($roster_id){
		$sql = "SELECT 
					pantawid_roster_id
				from tbl_prospects	
				where pantawid_roster_id = :roster_id
				";
	    //echo "<br><br>". $sql . "<br><br>";
		//echo substr($region_code, -9);
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":roster_id",$roster_id);
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["pantawid_roster_id"];
	}
	public function getrecordcount($filter){
		
		$sql= "explain select distinct(roster_id) from pantawid_list where birthday > '1860-01-01' $filter";
		echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
		
		$this->closeDB();
		
		return $result[0]["rows"];
	}	
	public function pushTargetToSPCB($roster_id,$UID){
		
		$sql= "
				INSERT INTO 
				
				tbl_prospects 
				(pros_lname,
				pros_fname,
				pros_mname,
				pros_xname,
				gender_id,
				birthday,
				region_id,
				prov_id,
				muni_city_id,
				brgy_id,
				pantawid_hh_id,
				pantawid_roster_id,
				solo_parent,
				disability_id,
				ip_icc_id,
				pantawid_hh_set,
				family_head,
				occupation_id,
				marital_status_id,
				education_id,
				HH_SEA,
				HH_microcredit,
				HH_philhealth,
				HH_livelihoodTrn,
				created_by,
				date_created)

				SELECT 
				
				pantawid_list.last_name as last_name,
				pantawid_list.first_name as first_name,
				pantawid_list.mid_name as mid_name,
				pantawid_list.ext_name as ext_name,
				pantawid_list.gender_id as gender_id,
				pantawid_list.birthday as birthday,
				(select region_id from lib_region where region_psgc = pantawid_list.region_code) as region_code,
				(select prov_id from lib_prov where prov_psgc = pantawid_list.prov_code) as prov_code,
				(select muni_city_id from lib_muni_city where muni_city_psgc = pantawid_list.city_code) as city_code,
				(select brgy_id from lib_brgy where brgy_psgc = pantawid_list.brgy_code) as brgy_code,
				pantawid_list.hh_id as hh_id,
				pantawid_list.roster_id as roster_id,		
				pantawid_list.solo_parent as solo_parent,
				pantawid_list.disability_code as disability_code,
				pantawid_list.indigenous_group_code as indigenous_group_code,
				pantawid_list.hh_set as hh_set,
				pantawid_list.head_relationship_id as head_relationship_id,
				pantawid_list.occupation_code,
				pantawid_list.educ_level_code,
				pantawid_list.marital_stat_code,
				pantawid_list.HH_SEA,
				pantawid_list.HH_microcredit,
				pantawid_list.HH_philhealth,
				pantawid_list.HH_livelihoodTrn,
				'$UID',
				NOW()

				FROM `pantawid_list` WHERE pantawid_list.roster_id = '$roster_id' limit 1
		";
		//echo $sql;
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

	public function getNewregions(){
		$sql = "SELECT 
					region_id,
					region_nick
				from lib_region	
				order by region_id
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"region_psgc"=>$row["region_id"],
						"region_nick"=>$row["region_nick"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}
	public function getNewprovsByRegion($region){
		$sql = "SELECT 
					prov_id,
					prov_name
				from lib_prov 
				where region_id= :region
				order by prov_name
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":region",$region);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"prov_psgc"=>$row["prov_id"],
						"prov_name"=>$row["prov_name"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}
	public function getNewmunsByProv($prov){
		$sql = "SELECT 
					muni_city_id,
					muni_city_name
				from lib_muni_city 
				where prov_id= :prov
				order by muni_city_name
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":prov",$prov);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"muni_city_psgc"=>$row["muni_city_id"],
						"muni_city_name"=>$row["muni_city_name"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}	
	public function getNewbrgyByMun($mun){
		$sql = "SELECT 
					a.brgy_id as brgy_psgc,
					a.brgy_name as brgy_name
				from lib_brgy as a 
				where a.muni_city_id= :mun
				order by a.brgy_name
				";
	    //echo "<br><br>". $sql . "<br><br>";
		$this->openDB();
		$this->prepareQuery($sql);
		$this->bindQueryParam(":mun",$mun);
		$result = $this->executeQuery();
		$recordlist = array();
		$trash = array_pop($recordlist);
		
		foreach($result as $i=>$row){
			
					$row_data = array(
						"brgy_psgc"=>$row["brgy_psgc"],
						"brgy_name"=>$row["brgy_name"]
						
					);
				$recordlist[$i] = $row_data;
		}
		$this->closeDB();
		return $recordlist;
	}	

} 
?>
