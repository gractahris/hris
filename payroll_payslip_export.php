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
$filename = "gracta_builders_payslip_" . date('Y-m-d His') . ".xls";

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;

$payrollDAO = new payrollDAO();

echo "<table border = 1 >";
echo "<tr>";
echo "<td colspan = 1 align='center'  colspan = 7>";


// $getAllCutOffByID = $payrollDAO->getAllCutOffByID($_SESSION['getCutOff']);
$getAllCutOffByID = $payrollDAO->getAllCutOffByID($_GET['cutOffID']);

$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");
// print_r($getAllCutOffByID);

foreach($getAllCutOffByID as $keyCf => $valCf)
{

	$getPayroll = $payrollDAO->getPayroll($_GET['month'],$_GET['year'],$valCf['cut_off_start'],$valCf['cut_off_end']);
	
	if($getPayroll == NULL)
	{
		echo "No Value in database kindly generate payroll first!";
	}

	if($getPayroll == "")
	{
		echo "No Value in database kindly generate payroll first!";
	}


	
	foreach($getPayroll as $keyPr => $valPr)
	{
		echo "<table border =1 width=100%>";
		
		echo "<tr>";
		echo "<td align = 'center' colspan=13>";
		echo "<h2>GRAC - TA BUILDERS </h2>";
		
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align = 'center' colspan=13>";
		echo "<h3>PAYSLIP</h3>";
		echo "</td>";
		echo "</tr>";

		// echo "<tr>";
		
		// echo "</tr>";

		echo "<tr>";
		echo "<td align = 'left' colspan=8>";
		echo "NAME: ";
		echo "</td>";
		echo "<td align = 'center' colspan=5>";
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
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align = 'left' colspan=8>";
		echo "PAY PERIOD: ";
		echo "</td>";
		
		echo "<td align = 'center' colspan=5>";
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
		echo "</td>";
		
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'left' colspan = 8>";
		echo "BASIC: ";
		echo "</td>";
		echo "<td align = 'center' colspan = 5>";
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
		echo "</tr>";
		
		
		// echo "<tr>";
		// echo "<td align = 'center' colspan = 5>";
		// echo "Gross Income: ";
		// echo "</td>";
		// echo "<td align = 'center'>";
		// echo $valPr["salary_as_per_logs"];
		// echo "</td>";
		echo "<tr>";
		echo "<td align = 'left	' colspan = 13>";
		echo "Deductions";
		echo "</td>";
		echo "</tr>";


		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "SSS Contribution: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 6>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["sss_cont_ee"],2);
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "Philhealth Contribution: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 6>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["ph_cont_ee"],2);
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "PAGIBIG Contribution: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 6>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["pagibig_cont_ee"],2);
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "W/holding Tax: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 6>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr["tax_cont"],2);
		echo "</td>";
		echo "</tr>";
		


		// $totalAbsentLate = $valPr["salary_as_per_contract"] - $valPr["salary_as_per_logs"];
		//$totalAbsentLate = $contractSalary - $valPr["salary_as_per_logs"];
		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "Absent/Late: ";
		echo "</td>";

		$totalAbsentLate = $valPr["emp_lates"];

		echo "<td align = 'left' colspan = 6>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($totalAbsentLate,2);
		echo "</td>";
		echo "</tr>";

		// echo "<tr>";
		// echo "<td align = 'left'  colspan = 8>";
		// echo "DAY OFF: ";
		// echo "</td>";

		// echo "<td align = 'center' colspan = 5>";
		// if($$valPr['weekends'] == 0)
		// {
		// 	echo "0";
		// }else
		// {
		// echo "( - ".$valPr['weekends']." )";
		// }
		// echo "</td>";
		// echo "</tr>";
		
		echo "<tr>";
		echo "<td align = 'left' colspan = 8>";
		echo "PAID OVERTIME: ";
		echo "</td>";

		$totalExcess = $valPr["emp_ot"];

		echo "<td align = 'center' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($totalExcess,2);
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'left' colspan = 8>";
		echo "NIGHT DIFFERENTIAL: ";
		echo "</td>";

		echo "<td align = 'center' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;"."P ".round($valPr['night_diff'],2);
		echo "</td>";
		echo "</tr>";


		$payroll_month = $valPr['payroll_month'];
		if($payroll_month <= "9")
		{
			$payroll_month = "0".$payroll_month;
		}else
		{
			$payroll_month = $payroll_month;
		}
		$payroll_year = $valPr['payroll_year'];
		$cut_off_start = $valPr['cut_off_start'];
		$cut_off_end = $valPr['cut_off_end'];
		$emp_id_val = $valPr['emp_id'];
		$cutOffID_val = $_GET['cutOffID'];

		if($cutOffID_val <> "3")
		{
			$getSumAmount = $payrollDAO->getSumDeAmount($emp_id_val,$payroll_month,$payroll_year,$cutOffID_val);

			$getSumAmount_value = $payrollDAO->getSumAmount($emp_id_val,$payroll_month,$payroll_year,$cutOffID_val);

		}
		else
		{
			$getSumAmount = $payrollDAO->getSumDeAmountNoCO($emp_id_val,$payroll_month,$payroll_year);

			$getSumAmount_value = $payrollDAO->getSumAmountNoCutOff($emp_id_val,$payroll_month,$payroll_year);

		}

		foreach($getSumAmount_value as $keySAV => $valSAV)
		{
			$totalOD = $valSAV['totalOD'];
			// $deduction_amount = $valSA['deduction_amount'];
		}

		echo "<tr>";
		echo "<td align = 'left	' colspan = 13>";
		echo "Other Deductions";
		echo "</td>";
		echo "</tr>";
		foreach($getSumAmount as $key => $val)
		{

			$deduction_amount = $val['deduction_amount'];
			$deduction_title = $val['deduction_title'];

			echo "<tr>";
			echo "<td align = 'right' colspan = 7>";
			echo $deduction_title .": ";
			echo "</td>";

			echo "<td align = 'left' colspan = 6>";
			echo "&thinsp;&thinsp;&thinsp;P ".$deduction_amount;
			echo "</td>";
			echo "</tr>";

		}

		$grossPay = $valPr['salary_as_per_logs'] + $totalAbsentLate;
		echo "<tr>";
		echo "<td align = 'left' colspan='8'>";
		echo "GROSS PAY: ";
		echo "</td>";

		echo "<td align = 'center' colspan='5'>";
		echo "P ".round($grossPay,2);
		echo "</td>";

		echo "<tr>";
		echo "<td align = 'left'  colspan = 8>";
		echo "TOTAL DEDUCTIONS: ";
		echo "</td>";

		$totalDeduction = $valPr["sss_cont_ee"]+$valPr["ph_cont_ee"]+$valPr["pagibig_cont_ee"]+$valPr["tax_cont"]+$totalAbsentLate+$totalOD;

		echo "<td align = 'center' colspan = 5>";
		echo "P ".round($totalDeduction,2);
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'left' colspan='8'>";
		echo "NET PAY: ";
		echo "</td>";

		echo "<td align = 'center' colspan='5'>";
		echo "P ".round($valPr["total_salary"],2);
		echo "</td>";
		
		echo "</tr>";
		
		echo "<tr>";
		echo "<td color = 'red' align = 'left' colspan='13'>";
		echo "  ";
		echo "</td>";

		if(!$flag) { // display field/column names as first row
			echo implode("\t", array_keys($rowVal)) . "\r\n";
			$flag = true;
		}
		array_walk($row, 'cleanData');
		echo implode("\t", array_values($rowVal)) . "\r\n";

	}


	echo "</tr>";
	exit;
	echo "</table>";


}

echo "</td>";
echo "</tr>";
echo "</table>";

?>