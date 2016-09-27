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
echo "<td colspan = 1 align='center'  colspan = 7>";


$getAllCutOffByID = $payrollDAO->getAllCutOffByID($_SESSION['getCutOff']);

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


		echo "<tr>";
		echo "<td align = 'center' colspan=15>";
		echo "<h2>GRAC - TA BUILDERS </h2>";
		echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
		echo "<td align = 'center' colspan=15>";
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
		
		echo "<td align = 'center'>";
		echo "SSS Contribution ";
		echo "<br/>";
		echo"(Employer)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "SSS Contribution ";
		echo "<br/>";
		echo"(Employee)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "PhilHealth <br/> Contribution ";
		echo "<br/>";
		echo"(Employer)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "PhilHealth <br/> Contribution  ";
		echo "<br/>";
		echo"(Employee)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "PAGIBIG <br/> Contribution ";
		echo "<br/>";
		echo"(Employer)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "PAGIBIG <br/> Contribution  ";
		echo "<br/>";
		echo"(Employee)";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "W/Holding Tax";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "Total <br/> Absent/Late";
		echo "</td>";
		
		echo "<td align = 'center'>";
		echo "Total <br/> Deductions";
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