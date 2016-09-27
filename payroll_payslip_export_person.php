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

// header("Content-Type: text/plain");
// header("Content-Disposition: attachment; filename=\"$filename\"");
// header("Content-Type: application/vnd.ms-excel");

$flag = false;

$payrollDAO = new payrollDAO();

echo "<table border = 1 >";
echo "<tr>";
echo "<td colspan = 1 align='center'  colspan = 7>";


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


	
	foreach($getPayroll as $keyPr => $valPr)
	{
		echo "<table border =1 width=100%>";
		
		echo "<tr>";
		echo "<td align = 'center' colspan=12>";
		echo "<h2>GRAC - TA BUILDERS </h2>";
		
		echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
		echo "<td align = 'center' colspan=12>";
		echo "<h3>PAYSLIP</h3>";
		echo "</td>";
		echo "</tr>";

		// echo "<tr>";
		
		// echo "</tr>";

		echo "<tr>";
		echo "<td align = 'left' colspan=8>";
		echo "NAME: ";
		echo "</td>";
		echo "<td align = 'center' colspan=4>";
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
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align = 'left' colspan=8>";
		echo "PAY PERIOD: ";
		echo "</td>";
		
		echo "<td align = 'center' colspan=4>";
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
		echo "BASIC PAY: ";
		echo "</td>";
		echo "<td align = 'center' colspan = 4>";
		echo $valPr["salary_as_per_contract"];
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
		echo "<td align = 'left	' colspan = 12>";
		echo "Deductions";
		echo "</td>";
		echo "</tr>";


		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "SSS Contribution: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;".$valPr["sss_cont_ee"];
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "Philhealth Contribution: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;".$valPr["ph_cont_ee"];
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "PAGIBIG Contribution: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;".$valPr["pagibig_cont_ee"];
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "W/holding Tax: ";
		echo "</td>";

		echo "<td align = 'left' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;".$valPr["tax_cont"];
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align = 'right' colspan = 7>";
		echo "Absent/Late: ";
		echo "</td>";

		$totalAbsentLate = $valPr["salary_as_per_contract"] - $valPr["salary_as_per_logs"];
		echo "<td align = 'left' colspan = 5>";
		echo "&thinsp;&thinsp;&thinsp;".$totalAbsentLate;
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align = 'left'  colspan = 8>";
		echo "TOTAL DEDUCTIONS: ";
		echo "</td>";

		$totalDeduction = $valPr["sss_cont_ee"]+$valPr["ph_cont_ee"]+$valPr["pagibig_cont_ee"]+$valPr["tax_cont"]+$totalAbsentLate;

		echo "<td align = 'center' colspan = 4>";
		echo $totalDeduction;
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align = 'left' colspan='8'>";
		echo "NET PAY: ";
		echo "</td>";

		echo "<td align = 'center' colspan='4'>";
		echo $valPr["total_salary"];
		echo "</td>";
		
		echo "</tr>";
		
		echo "<tr>";
		echo "<td color = 'red' align = 'left' colspan='12'>";
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