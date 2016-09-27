<?php
if (!isset($_SESSION)) session_start(); 
// Initialize Session data
ob_start(); // Turn on output buffering
error_reporting(1);
define("EW_DEFAULT_LOCALE", "en_US", TRUE);
@setlocale(LC_ALL, EW_DEFAULT_LOCALE);
ini_set("memory_limit"," 640M");
ini_set('max_execution_time', '1200');
set_time_limit (1000000);
date_default_timezone_set("Asia/Manila");
?>
<?php 
include ('ewcfg10.php');
include_once ('model/DAO.php');
// include_once ('model_b/LocatorPdfDAO.php');
include_once ('model/payrollDAO.php');

?>
<?php
require_once('a_pds/config/lang/eng.php');
require_once('a_pds/tcpdf.php');



// echo $user_regname;
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
		
        // Logo
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		

		// Logo
		// $image_file = K_PATH_IMAGES.'dswd.jpg';
		// $this->Image($image_file, 20, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		// $this->SetFont('helvetica', 'B', 20);
		// Title
		// $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	
        // Set font
		// $this->SetY(10);
		// $this->SetX(40);
        // $this->SetFont('helvetica', '', 12);
        
		// Title
		// $this->Cell(0, 14, 'DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		
		// $this->SetY(15);
		// $this->SetX(35);
        // $this->SetFont('helvetica', '', 12);
        // Title
        // $this->Cell(0, 14, 'LOCATOR SLIP', 0, false, 'C', 0, '', 0, false, 'M', 'M');

		// $this->SetY(20);
		// $this->SetX(5);
        // $this->SetFont('helvetica', '', 12);
        // Title
        // $this->Cell(0, 14, $dates, 0, false, 'C', 0, '', 0, false, 'M', 'M');

		// $this->SetY(25);
		// $this->SetX(35);
        // $this->SetFont('helvetica', '', 12);
        // Title
        // $this->Cell(0, 14, 'EMPLOYEE PAYSLIP', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    // public function Footer() {
        // Position at 15 mm from bottom
        // $this->SetY(-15);
        // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // }

	public function NbPages(){
		return $this->num_columns;
	}
}
// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document
$pdf = new MYPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $sheets = $pdf->NbPages();

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Hehehe');
$pdf->SetTitle('DSWD');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData('', '', '', PDF_HEADER_STRING_PI, array(12,64,0), array(12,64,0));


// $pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT_PI, PDF_MARGIN_TOP_PI, PDF_MARGIN_RIGHT_PI);
// $pdf->SetMargins(20,20,20); // jfsbaldo 08232014
// $pdf->SetHeaderMargin(0);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// $sheets = $pdf->NbPages();
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('P','',true,true);

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
//carla
$payrollDAO = new payrollDAO();
$getAllCutOffByID = $payrollDAO->getAllCutOffByID($_SESSION['getCutOff']);
$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");

// echo "<table border = 1 >";
// echo "<tr>";
// echo "<td colspan = 1 align='center'  colspan = 7>";


// $LocDetails = new LocatorPdfDAO($_REQUEST['locID']);

// $EmpLocDetails = $LocDetails->getEmpLocDetails();
// $LocatorID = $EmpLocDetails['LocatorID'];
// $destination = $EmpLocDetails['destination'];
// $datefrom = $EmpLocDetails['datefrom'];
// $dateto = $EmpLocDetails['dateto'];
// $purpose = $EmpLocDetails['purpose'];
// $cdo = $EmpLocDetails['cdo'];

// $EmpDetails = $LocDetails->getEmpDetails();
// $FirstName = utf8_encode($EmpDetails['FirstName']);
// $MiddleName = utf8_encode($EmpDetails['MiddleName']);
// $LastName = utf8_encode($EmpDetails['LastName']);
// $ExtName = utf8_encode($EmpDetails['ExtName']);

// $PositionTitle = $LocDetails->getPosTitle();

// $GroupHead = $LocDetails->getGroupHead();

// if ($cdo == 0) {
	// $cdoCheck = "[ X ] Official [   ] Personal";
// } else {
	//$cdoCheck = "[   ] Official [   ] Personal";
// }

// $date1 = date("F j, Y",strtotime($datefrom));
// $time1 = date("h:i A",strtotime($datefrom));

// $date2 = date("F j, Y",strtotime($dateto));
// $time2 = date("h:i A",strtotime($dateto));

// if ($date1 == $date2 && $time1 == $time2) {
	// $timeShower = $date1 . " " . $time1;
// } elseif ($date1 == $date2 && $time1 != $time2) {
	// $timeShower = $date1 . ", From " . $time1 . " to " . $time2;
// } elseif ($date1 != $date2 && $time1 != $time2) {
	// $timeShower = "From " . $date1 . " " . $time1 . " to " . $date2 . " " .$time2;
// } else {
	// $timeShower = "<<Dates are Inconsistent, check application>>";
// }
// for($a = 0; $a < 2; $a++){
// <img src = "phpimages/dswd.jpg" height = "65" width = "75" style ="float:left;"/>

// $image = $pdf->Image( K_PATH_IMAGES.'dswd.jpg', 10, 10, 10, 10, 'JPG', '', , true, 150, '', false, false, 3, false, false, false);
$html .= <<<EOD
<table border = "1" >
<tr>
<td colspan = 1 align="center"  colspan = 7>
EOD;
foreach($getAllCutOffByID as $keyCf => $valCf)
{
	
	// $getPayroll = $payrollDAO->getPayrollByID($_GET['month'],$_GET['year'],$valCf['cut_off_start'],$valCf['cut_off_end'],$_GET['empid']);
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
		$emp_id = $valPr['emp_id'];
		$contractSalary = $valPr["salary_as_per_contract"];
		$sssEE = $valPr["sss_cont_ee"];
		$phEE = $valPr["ph_cont_ee"];
		$pagibig_cont_ee = $valPr["pagibig_cont_ee"];
		$tax_cont = $valPr["tax_cont"];
		$totalAbsentLate = $valPr["salary_as_per_contract"] - $valPr["salary_as_per_logs"];
		$totalDeduction = $valPr["sss_cont_ee"]+$valPr["ph_cont_ee"]+$valPr["pagibig_cont_ee"]+$valPr["tax_cont"]+$totalAbsentLate;
		$total_salary = $valPr["total_salary"];
		
		$html .= <<<EOD
		<table border ="1" width="100%">
		<tr>
		<td colspan="12">
			<h2>GRAC - TA BUILDERS </h2>
		</td>
		</tr>
		
		<tr>
		<td align = 'center' colspan="12">
			<h2>PAYSLIP </h2>
		</td>
		</tr>
		
		<tr>
		<td align = "left" colspan="8">
		&nbsp;NAME:
		</td>
		
		<td align = "center" colspan="4">
		&nbsp;&nbsp;
		
	
EOD;

	$getAllEmpByID = $payrollDAO->getAllEmpByID($emp_id);
	foreach($getAllEmpByID as $keyEmp => $valEmp)
	{
		$empLastName = $valEmp["empLastName"];
		$empFirstName = $valEmp["empFirstName"];
		$empMiddleName = $valEmp["empMiddleName"];
		
		$fullName = $empLastName.", ".$empFirstName." ".$empMiddleName;
$html .= <<<EOD
$fullName
</td>
		</tr>

EOD;
}//end of getAllEmpID
$html .= <<<EOD
		<tr>
		<td align = "left" colspan="8">
		&nbsp;PAY PERIOD:
		</td>
		
		<td align = "center" colspan="4">
		&nbsp;&nbsp;
		
EOD;

foreach($monthArr as $key => $val)
		{
			$counter = $key + 1;

			if($_GET['month'] == $counter)
			{
				
				$payPeriod =$val." ".$valCf['cut_off_start']."  TO  ".$valCf['cut_off_end'].",  ".$_GET['year'];
			}
		}
$html .= <<<EOD
$payPeriod
</td>
		</tr>
		
		<tr>
		
		<td align = "left" colspan="8">
		&nbsp;CONTRACT PRICE:
		</td>
		
		<td align = "center" colspan="4">
		$contractSalary
		</td>
		</tr>
		
		
		<tr>
		
		<td align = "left" colspan="12">
		&nbsp;Deductions
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="7">
		&nbsp;SSS Contribution:&nbsp;&nbsp;
		</td>
		
		<td align = "left" colspan = "5">
		&nbsp;
		$sssEE
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="7">
		&nbsp;PhilHealth Contribution:&nbsp;&nbsp;
		</td>
		
		<td align = "left" colspan = "5">
		&nbsp;
		$phEE
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="7">
		&nbsp;PAGIBIG Contribution:&nbsp;&nbsp;
		</td>
		
		<td align = "left" colspan = "5">
		&nbsp;
		$pagibig_cont_ee
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="7">
		&nbsp;W/holding Tax:&nbsp;&nbsp;
		</td>
		
		<td align = "left" colspan = "5">
		&nbsp;
		$tax_cont
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="7">
		&nbsp;Absent/Late:&nbsp;&nbsp;
		</td>
		
		<td align = "left" colspan = "5">
		&nbsp;
		$totalAbsentLate
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="7">
		&nbsp;Total Deductions:&nbsp;&nbsp;
		</td>
		
		<td align = "left" colspan = "5">
		&nbsp;
		$totalDeduction
		</td>
		</tr>
		
		<tr>
		
		<td align = "right" colspan="8">
		
		&nbsp;<br/>NET PAY:&nbsp;&nbsp;
		<br/>
		</td>
		
		<td align = "center" colspan = "4">
		&nbsp;<br/>&nbsp;
		$total_salary
		<br/>
		</td>
		
		
EOD;

	}//payroll


$html .= <<<EOD
</tr>
</table>
EOD;

	
}//cutoff

$html .= <<<EOD
</td>
</tr>
</table>
EOD;

// }
// $html .= '<tcpdf method="AddPage" />';


?>
<?php	

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Payslip'.'.pdf', 'I');

// $pdf->Output('leave/leave'.'.pdf', 'F'); // jfsbaldo 08222014
// $pdf->Output('sample/DTR'.'_'.$_GET['x_UName'].''.'.pdf', 'F'); // jfsbaldo 08222014
// $pdf->Output('GeneratedPayroll/socpenPayroll'.date('Ymd').'_'.$_GET["xyear"].'_'.$_GET["xquarter"].'.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+
?>
<?php //} ?>