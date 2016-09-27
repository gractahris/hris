<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2012-07-25
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

require_once('config/lang/eng.php');
require_once('tcpdf.php');

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Hehehe');
$pdf->SetTitle('DSWD');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Republic of the Philippines', PDF_HEADER_STRING, array(0,64,0), array(0,64,0));
$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$date_now = date('l F d, Y');
$html = <<<EOD
<p style="font-size:40px; font-family:arial;">
$date_now
</p>
<p style="font-size:40px; font-family:arial;">
MS. EMALYN M. ORQUINAZA<br />
Asst. Vise President<br />
Land Bank of the Philippines<br />
Batasan Branch, Quezon City<br /><br />

Madam :<br /><br />

Please transfer funds from the following MDS Accounts :
</p>
<p style="font-size:40px; font-family:arial;">
FROM : _______________________________________________ <br />
TO: __________________________________________________
</p>
<p style="font-size:35px; font-family:arial;">
TO COVER THE TRAININGS ON WOMEN, PEACE AND SECURITY FEBRUARY 11-15, 2013 WITH<br />
THE FOLLOWING DETAILS:
</p><br />
<table >
<tr>
	<td style="border:2px solid #666699; font-size:40px; font-family:arial;" align="center">Sub-Allotment Number</td>
	<td style="border:2px solid #666699; font-size:40px; font-family:arial;" align="center">Amount</td>
</tr>
<tr>
	<td style="border:2px solid #666699; font-size:40px; font-family:arial;" align="center">asdasd</td>
	<td style="border:2px solid #666699; font-size:40px; font-family:arial;" align="center">asdasd</td>
</tr>
<tr>
	<td align="center">asdasd</td>
	<td align="center">asdasd</td>
</tr>
</table>
<p style="font-size:35px; font-family:arial;">
It is requested that this office be furnished with copies of the corresponding Debit and Credit<br />
Advice for record purposes soonest the transactions are completed in the bank.
</p><br />
<p style="font-size:35px; font-family:arial;">
Very truly yours,<br /><br />
</p>
<p style="font-size:35px; font-family:arial;">
<span style="text-decoration:underline;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GRACE ANN S. NISPEROS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SAO, Fiscal Control Division
<br /><br />
</p><br /><br />
<p style="font-size:35px; font-family:arial;">
<span style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESEREE D. FAJARDO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br />
Director, Financial Management Service
</p>

EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_112.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
 