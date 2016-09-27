<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "model/DAO.php" ?>
<?php include_once "model/payrollDAO.php" ?>

<style>


	td{
		font-size: 12.5px;
	}
</style>
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
echo "<td colspan = 1 align='center'  colspan = 5>";


$getAllCutOffByID = $payrollDAO->getAllCutOffByID($_SESSION['getCutOff']);

$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");
// print_r($getAllCutOffByID);

foreach($getAllCutOffByID as $keyCf => $valCf)
{
	$totalOD = "0";
	$getPayroll = $payrollDAO->getPayroll($_GET['month'],$_GET['year'],$valCf['cut_off_start'],$valCf['cut_off_end']);
	
	if($getPayroll == NULL)
	{
		echo "No Value in database kindly generate payroll first!";
	}

	if($getPayroll == "")
	{
		echo "No Value in database kindly generate payroll first!";
	}


		echo "<tr>";
		echo "<td align = 'center' colspan=5>";
		echo "<h2>GRAC - TA BUILDERS </h2>";
		echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
		echo "<td align = 'center' colspan=5>";
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
		echo "BASIC PAY: ";
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
		echo "Other Deductions";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "Total <br/> Absent/Late";
		echo "</td>";
		
		

		// echo "<td align = 'center'>";
		// echo "Total <br/> DayOff";
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
		$getAllEmpByID = $payrollDAO->getAllEmpByID($valPr['emp_id']);
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
		//echo $valPr["salary_as_per_contract"];
		$contractSalary = $valPr["salary_as_per_contract"];
		if($_GET['cutOffID'] <> "3")
		{

			$contractSalary = $contractSalary / 2;
		}else
		{
			$contractSalary = $contractSalary;

		}
		echo "P ".$contractSalary;
		echo "</td>";
		
		// echo "<td align = 'center'>";
		// echo "&thinsp;&thinsp;&thinsp;".$valPr["sss_cont_ep"];
		// echo "</td>";
		
		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".$valPr["sss_cont_ee"];
		echo "</td>";
		
		// echo "<td align = 'center'>";
		// echo "&thinsp;&thinsp;&thinsp;".$valPr["ph_cont_ep"];
		// echo "</td>";

		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".$valPr["ph_cont_ee"];
		echo "</td>";

		// echo "<td align = 'center'>";
		// echo "&thinsp;&thinsp;&thinsp;".$valPr["pagibig_cont_ep"];
		// echo "</td>";
		
		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".$valPr["pagibig_cont_ee"];
		echo "</td>";


		echo "<td align = 'center'>";
		$totalTax_val = round($valPr["tax_cont"],2);
		echo "&thinsp;&thinsp;&thinsp;"."P ".$totalTax_val;
		echo "</td>";

		// $totalAbsentLate = $valPr["salary_as_per_contract"] - $valPr["salary_as_per_logs"];
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

		// if($cut_off_start == "1" && $cut_off_end = "15")
		// {
		// 	$cutOffID = "1";
		// 	$getSumAmount = $payrollDAO->getSumAmount($emp_id_val,$payroll_month,$payroll_year,$cutOffID);


		// }else if($cut_off_start == "16" && $cut_off_end = "30")
		// {
		// 	$cutOffID = "2";
		// }else if($cut_off_start == "16" && $cut_off_end = "31")
		// {
		// 	$cutOffID = "2";
		// }else if($cut_off_start == "1" && $cut_off_end = "31")
		// {
		// 	$cutOffID = "3";
		// 	$getSumAmount = $payrollDAO->getSumAmountNoCutOff($emp_id_val,$payroll_month,$payroll_year);

		// }else if($cut_off_start == "1" && $cut_off_end = "30")
		// {
		// 	$cutOffID = "3";
		// 	$getSumAmount = $payrollDAO->getSumAmountNoCutOff($emp_id_val,$payroll_month,$payroll_year);

		// }else
		// {
		// 	$cutOffID;
		// }

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


		
		// echo "<br/>";
		// echo "&thinsp;&thinsp;&thinsp;".$valPr['emp_id'];
		// echo "<br/>";
		// echo "&thinsp;&thinsp;&thinsp;".$payroll_month;
		// echo "<br/>";
		// echo "&thinsp;&thinsp;&thinsp;".$payroll_year;
		// echo "<br/>";
		// echo "&thinsp;&thinsp;&thinsp;".$cut_off_start;
		// echo "<br/>";
		// echo "&thinsp;&thinsp;&thinsp;".$cut_off_end;
		// echo "<br/>";
		echo "</td>";

		echo "<td align = 'center'>";
		$totalAbsentLate = round($totalAbsentLate,2);
		echo "&thinsp;&thinsp;&thinsp;"."P ".$totalAbsentLate;
		echo "</td>";


		// echo "<td align = 'center'>";
		// echo $valPr["weekends"];
		// echo "</td>";

		echo "<td align = 'center'>";
		$totalExcess = round($totalExcess,2);
		echo "&thinsp;&thinsp;&thinsp;"."P ".$totalExcess;
		echo "</td>";

		echo "<td align = 'center'>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".$valPr['night_diff'];
		echo "</td>";

		echo "<td align = 'center'>";
		$grossPay = $valPr['salary_as_per_logs'] + $totalAbsentLate;
		// echo "&thinsp;&thinsp;&thinsp; Gross Pay";
		$grossPay = round($grossPay,2);
		echo "&thinsp;&thinsp;&thinsp;"."P ".$grossPay;
		echo "</td>";


		$totalDeduction = $valPr["sss_cont_ee"]+$valPr["ph_cont_ee"]+$valPr["pagibig_cont_ee"]+$valPr["tax_cont"]+$totalAbsentLate + $totalOD;
		$totalDeduction = round($totalDeduction,2);
		echo "<td align = 'center'>";
		echo "P ".$totalDeduction;
		echo "</td>";

		echo "<td align = 'center'>";
		echo "P ".$valPr["total_salary"];
		echo "</td>";
		
		echo "</tr>";


		if(!$flag) { // display field/column names as first row
			echo implode("\t", array_keys($rowVal)) . "\r\n";
			$flag = true;
		}
		array_walk($row, 'cleanData');
		echo implode("\t", array_values($rowVal)) . "\r\n";

		$contractSalaryFinal = $contractSalaryFinal + $contractSalary;
		$sssEP = $sssEP + $valPr["sss_cont_ep"];
		$sssEE = $sssEE + $valPr["sss_cont_ee"];
		$phEP = $phEP + $valPr["ph_cont_ep"];
		$phEE = $phEE + $valPr["ph_cont_ee"];
		$pagibigEP = $pagibigEP + $valPr["pagibig_cont_ep"];
		$pagibigEE = $pagibigEE + $valPr["pagibig_cont_ee"];
		$totalTax = $totalTax + $valPr["tax_cont"];
		$totalOtherDeduction = $totalOtherDeduction + $totalOD;
		$totalAbsentLateFinal = $totalAbsentLateFinal + $totalAbsentLate;
		$totalDeductionFinal = $totalDeductionFinal + $totalDeduction;
		$totalExcessFinal = $totalExcessFinal + $totalExcess;
		$nightDiffFinal = $nightDiffFinal + $valPr['night_diff'];
		$totalSalaryFinal = $totalSalaryFinal + $valPr["total_salary"];
		$grossPayFinal = $grossPayFinal + $grossPay;


	}


		echo "<tr>";
		echo "<td>";echo "TOTAL: ";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($contractSalaryFinal,2)."</b>";echo "</td>";
		// echo "<td align=\"center\">";echo "<b>P ".$sssEP."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".$sssEE."</b>";echo "</td>";
		// echo "<td align=\"center\">";echo "<b>P ".$phEP."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".$phEE."</b>";echo "</td>";
		// echo "<td align=\"center\">";echo "<b>P ".$pagibigEP."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($pagibigEE,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($totalTax,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($totalOtherDeduction,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($totalAbsentLateFinal,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($totalExcessFinal,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($nightDiffFinal,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($grossPayFinal,2)."</b>";echo "</td>";
		// $totalDeductionFinal = $totalDeductionFinal + $totalOtherDeduction;

		echo "<td align=\"center\">";echo "<b>P ".round($totalDeductionFinal,2)."</b>";echo "</td>";
		echo "<td align=\"center\">";echo "<b>P ".round($totalSalaryFinal,2)."</b>";echo "</td>";

	echo "</tr>";
	exit;



}

echo "</td>";
echo "</tr>";
echo "</table>";

?>