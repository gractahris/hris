<!--carla enter codes here-->
<?php
	function unableToAddMonth()
	{
	?>
	
		<script>
		alert("Unable to add kindly choose month");
		</script>
	<?php
	}
	
	function unableToAddYear()
	{
	?>
		<script>
		alert("Unable to add kindly choose year");
		</script>
	<?php
	}
	
	function unableToAddEmp()
	{
	?>
		<script>
		alert("Unable to add kindly choose Employee Name");
		</script>
	<?php
	}
	
	function unableToAdd()
	{
	?>
		<script>
		alert("Unable to add kindly choose month/year/Employee Name");
		</script>
	<?php
	}
	
	
?>
<form action = "create_dtr.php" method="GET">

<table>
	<tr>
		
		<td>
<?php
//carla
$createDTRDAO = new createDTRDAO();
$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");

?>
</td>
</tr>

<tr>

<td>
<?php
$yearArr = array("2016","2017","2018");

?> 
</td>
</tr>

<?php
$getYearNow = $createDTRDAO->getYearNow();
//print_r($getYearNow);
//echo $getYearNow[0]['YearNow'];
$_SESSION['getYear'] = $getYearNow[0]['YearNow'];
$yearNow = $_SESSION['getYear'];
// echo $_GET['emp_id'];
//echo $yearNow;
	/*if ($yearNow == "" && $key == "" && $_GET["emp_id"] == "")
	{
		// unableToAdd();
		
	}else if ($key == "#" && $yearNow == "#" && $_GET["emp_id"] == "#")
	{
		unableToAdd();
		
	}
	else if ($yearNow == "#")
	{
		unableToAddYear();
		
	}else if ($key == "#")
	{
		unableToAddMonth();
		
	}else if ($_GET["emp_id"] == "#")
	{
		unableToAddEmp();
		
	} else
	{*/

		foreach($monthArr as $key => $val)
		{

			$key = $key+1;
			//echo $key;

			if($key <= 9)
			{

				$key = "0".$key;
				//echo $key;

				//begin code

				if($key <> "02")
				{
					if($key % 2 == true)
					{
						if($key <= 7)
						{
							for($counter = 1; $counter <= 31; $counter++)
							{	
								


								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
							


								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");

								}

								
									//echo $dates.", ".$dateCreateFormat."<br/>";
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);

							
								

								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
										alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for
						}else
						{

							for($counter = 1; $counter <= 30; $counter++)
							{	
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
										alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for

						}
						
					}else if($key % 2 == false)
					{
						if($key <= 7)
						{
							for($counter = 1; $counter <= 30; $counter++)
							{		
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
									alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for
						}else
						{

							for($counter = 1; $counter <= 31; $counter++)
							{		
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
									alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for
						}
						
					}else
					{
						
						
					}
					
				}else{
					
					for($counter = 1; $counter <= 28; $counter++)
						{		
					
							if($counter <= 9 )
							{
								$counter = "0".$counter;
								$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
							}else
							{
								$counter = $counter;
								$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
							}
							
							$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
							
							/*if($saveDTR == true)
							{
							?>
								<script>
									alert("Successfully Created DTR");
								</script>
							<?php } else { ?>
								<script>
								alert("Duplicate Entry");
								</script>
							<?php
								} // end of duplication*/
						
						}//end of for
				}

				//end code

			}else
			{

				$key = $key;
				//echo $key;

				//begin code

				if($key <> "02")
				{
					if($key % 2 == true)
					{
						if($key <= 7)
						{
							for($counter = 1; $counter <= 31; $counter++)
							{	
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
										alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for
						}else
						{

							for($counter = 1; $counter <= 30; $counter++)
							{	
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow, $dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
										alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for

						}
						
					}else if($key % 2 == false)
					{
						if($key <= 7)
						{
							for($counter = 1; $counter <= 30; $counter++)
							{		
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
									alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for
						}else
						{

							for($counter = 1; $counter <= 31; $counter++)
							{		
								if($counter <= 9 )
								{
									$counter = "0".$counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}else
								{
									$counter = $counter;
									$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
								}
								
								$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
								
								/*if($saveDTR == true)
								{
								?>
									<script>
										alert("Successfully Created DTR");
									</script>
								<?php } else { ?>
									<script>
									alert("Duplicate Entry");
									</script>
								<?php
									} // end of duplication*/
							
							}//end of for
						}
						
					}else
					{
						
						
					}
					
				}else{
					
					for($counter = 1; $counter <= 28; $counter++)
						{		
					
							if($counter <= 9 )
							{
								$counter = "0".$counter;
								$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
							}else
							{
								$counter = $counter;
								$dates = $yearNow."-".$key."-".$counter;
									$dateCreate = date_create($dates);
									$dateCreateFormat = date_format($dateCreate,"l");
							}
							
							$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$key, $counter, $yearNow,$dateCreateFormat);
							
							/*if($saveDTR == true)
							{
							?>
								<script>
									alert("Successfully Created DTR");
								</script>
							<?php } else { ?>
								<script>
								alert("Duplicate Entry");
								</script>
							<?php
								} // end of duplication*/
						
						}//end of for
				}

				//end code
			}//end else $key




			


		}


			
		
	
	//}
	

?>
<tr><td>
<input type = "submit" name ="Enter" id ="Enter" value="Enter" />
</td><tr>
</table>
</form>

<!--carla enter codes here-->