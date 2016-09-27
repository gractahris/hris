<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "model/DAO.php" ?>
<?php include_once "model/payrollDAO.php" ?>

<!-- Put your custom html here -->
<?php


function cleanData(&$str)
{	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);

	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

}

// filename for download
$filename = "gracta_builders_payroll_" . date('Y-m-d His') . ".xls";

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;

$payrollDAO = new payrollDAO();

echo "<table border = 1 >";
echo "<tr>";
echo "<td colspan = 1 align='center'  colspan = 13>";


$getAllCutOffByID = $payrollDAO->getAllCutOffByID($_SESSION['getCutOff']);

$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");
// print_r($getAllCutOffByID);

foreach($getAllCutOffByID as $keyCf => $valCf)
{

	// $getPayroll = $payrollDAO->getPayroll($_GET['month'],$_GET['year'],$valCf['cut_off_start'],$valCf['cut_off_end']);
	$getPayroll = $payrollDAO->getPayrollByID($_GET['month'],$_GET['year'],$valCf['cut_off_start'],$valCf['cut_off_end'],$_GET['empid']);
	
	if($getPayroll == NULL)
	{
		echo "No Value in database kindly generate payroll first!";
	}

	if($getPayroll == "")
	{
		echo "No Value in database kindly generate payroll first!";
	}


		echo "<tr>";
		echo "<td align = 'center' colspan=13>";
		echo "<h2>GRAC - TA BUILDERS </h2>";
		echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
		echo "<td align = 'center' colspan=13>";
		echo "<h3>PAYROLL</h3>";
		echo "<h4>PAY PERIOD:  ";
		foreach($monthArr as $key => $val)
		{
			$counter = $key + 1;

			if($_GET['month'] == $counter)
			{
				echo $val." ";
				echo $valCf['cut_off_start']."  TO  ";
				echo $valCf['cut_off_end'].",  ";
				echo $_GET['year'];
			}
		}
		echo "</h4></td>";	
		echo "</tr>";
		
		echo "<tr>";
		
		echo "<td align = 'center'>";
		echo "NAME";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "CONTRACT PRICE: ";
		echo "</td>";
		
		// echo "<td align = 'center'>";
		// echo "SSS Contribution ";
		// echo "<br/>";
		// echo"(Employer)";
		// echo "</td>";
		
		echo "<td align = 'center'>";
		echo "SSS Contribution ";
		echo "<br/>";
		echo"(Employee)";
		echo "</td>";
		
		// echo "<td align = 'center'>";
		// echo "PhilHealth <br/> Contribution ";
		// echo "<br/>";
		// echo"(Employer)";
		// echo "</td>";
		
		echo "<td align = 'center'>";
		echo "PhilHealth <br/> Contribution  ";
		echo "<br/>";
		echo"(Employee)";
		echo "</td>";
		
		// echo "<td align = 'center'>";
		// echo "PAGIBIG <br/> Contribution ";
		// echo "<br/>";
		// echo"(Employer)";
		// echo "</td>";
		
		echo "<td align = 'center'>";
		echo "PAGIBIG <br/> Contribution  ";
		echo "<br/>";
		echo"(Employee)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "W/Holding Tax";
		echo "</td>";
		
		

		echo "<td align = 'center'>";
		echo "Total <br/> Other Deductions";
		echo "</td>";

		echo "<td align = 'center'>";
		echo "Total <br/> Absent/Late";
		echo "</td>";
		
		
		

		// echo "<td align = 'center'>";
		// echo "Total <br/> Day Off";
		// echo "</td>";

		echo "<td align = 'center'>";
		echo "Total <br/> Paid Overtime";
		echo "</td>";

		echo "<td align = 'center'>";
		echo "Total <br/> Night Differential";
		echo "</td>";

		echo "<td align = 'center'>";
		echo "Total <br/> Gross Pay";
		echo "</td>";

		echo "<td align = 'center'>";
		echo "Total <br/> Deductions";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "Net Pay";
		echo "</td>";
		
		echo "</tr>";
	
	foreach($getPayroll as $keyPr => $valPr)
	{
			
		echo "<tr>";
		echo "<td align = 'center'>";
		$getAllEmpByID = $payrollDAO->getAllEmpByID($_GET['empid']);
		//print_r($getAllEmpByID);
		foreach($getAllEmpByID as $keyEmp => $valEmp)
		{
			echo $valEmp["empLastName"];
			echo ", ";
			echo $valEmp["empFirstName"];
			echo " ";
			echo $valEmp["empMiddleName"];

		}
		echo "</td>";
		
		echo "<td align = 'center'>";
		$contractSalary = $valPr["salary_as_per_contract"];
		if($_GET['cutOffID'] <> "3")
		{

			$contractSalary = $contractSalary / 2;
		}else
		{
			$contractSalary = $contractSalary;

		}
		echo "P ".round($contractSalary,2);
		echo "</td>";
		
		//echo "<td align = 'center'>";
		//echo "&thinsp;&thinsp;&thinsp;".$valPr["sss_cont_ep"];
		//echo "</td>";
		
		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["sss_cont_ee"],2);
		echo "</td>";
		
		//echo "<td align = 'center'>";
		//echo "&thinsp;&thinsp;&thinsp;".$valPr["ph_cont_ep"];
		//echo "</td>";

		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["ph_cont_ee"],2);
		echo "</td>";

		//echo "<td align = 'center'>";
		//echo "&thinsp;&thinsp;&thinsp;".$valPr["pagibig_cont_ep"];
		//echo "</td>";
		
		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["pagibig_cont_ee"],2);
		echo "</td>";


		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["tax_cont"],2);
		echo "</td>";

		//$totalAbsentLate = $valPr["salary_as_per_contract"] - $valPr["salary_as_per_logs"];
		$totalAbsentLate = $valPr["emp_lates"];
		$totalExcess = $valPr["emp_ot"];

		//$totalAbsentLate = $contractSalary - $valPr["salary_as_per_logs"];
		
		echo "<td align = 'center'>";
		
		$payroll_month = $valPr['payroll_month'];
		$payroll_year = $valPr['payroll_year'];
		$cut_off_start = $valPr['cut_off_start'];
		$cut_off_end = $valPr['cut_off_end'];
		$emp_id_val = $valPr['emp_id'];
		
		$cutOffID = "";
		// echo $cutOffID;
		$cutOffID_val = $_GET['cutOffID'];

		if($valPr['payroll_month'] <= "9")
		{
			$payroll_month = "0".$payroll_month;
		}else
		{
			$payroll_month = $payroll_month;

		}

		if($cutOffID_val <> "3")
		{
			$getSumAmount = $payrollDAO->getSumAmount($emp_id_val,$payroll_month,$payroll_year,$cutOffID_val);

		}else
		{
			$getSumAmount = $payrollDAO->getSumAmountNoCutOff($emp_id_val,$payroll_month,$payroll_year);
		}
		
		echo "&thinsp;&thinsp;&thinsp;";
		foreach($getSumAmount as $keySA => $valSA)
				{
					$totalOD = $valSA['totalOD'];
					if($totalOD <> "" || $totalOD <> NULL)
					{
						echo "P ".$totalOD;
					}else
					{
						echo "P 0.00";
					}
				}


		echo "</td>";


		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($totalAbsentLate,2);
		echo "</td>";

		

		// echo "<td align = 'center'>";
		// echo "&thinsp;&thinsp;&thinsp;".$valPr['weekends'];
		// echo "</td>";

		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($totalExcess,2);
		echo "</td>";

		echo "<td align = 'center'>";
		if($valPr['night_diff'] == "")
		{
			$valPr['night_diff'] = "0";
		}else
		{
			$valPr['night_diff'] = $valPr['night_diff'];
		}
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr['night_diff'],2);
		echo "</td>";

		$grossPay = $valPr['salary_as_per_logs'] + $totalAbsentLate	;
		echo "<td align = 'center'>";
		echo "P ".round($grossPay,2);
		echo "</td>";

		$totalDeduction = $valPr["sss_cont_ee"]+$valPr["ph_cont_ee"]+$valPr["pagibig_cont_ee"]+$valPr["tax_cont"]+$totalAbsentLate + $totalOD;

		echo "<td align = 'center'>";
		echo "P ".round($totalDeduction,2);
		echo "</td>";

		echo "<td align = 'center'>";
		echo "P ".round($valPr["total_salary"],2);
		echo "</td>";
		
		echo "</tr>";


		if(!$flag) { // display field/column names as first row
			echo implode("\t", array_keys($rowVal)) . "\r\n";
			$flag = true;
		}
		array_walk($row, 'cleanData');
		echo implode("\t", array_values($rowVal)) . "\r\n";

	}


	
	exit;



}

echo "</td>";
echo "</tr>";
echo "</table>";

?>