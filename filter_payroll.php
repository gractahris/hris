<?php
//echo "aaaa";
$getAllCutOff = $payrollDAO->getAllCutOff();
$getAllEmp = $payrollDAO->getAllEmpNew();


?>
<form method = "GET">
<table class = "table table-hover">
    <tr>
        <td>Month</td>
        <td>
            <select id=month name=month>
                <option id = # name = # value = # >Please Select Month</option>
                <?php

                $monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");
                foreach($monthArr as $key => $val)
                {
                    $counter = $key + 1;

                    if($counter < 10)
                    {
                        $month = "0".$counter;
                        echo $month;

                        echo "<option id = '".$month."' name = '".$month."' value = '".$month."'>" .$val. "</option>";
                    }else
                    {
                        $counter;
                        echo "<option id = '".$counter."' name = '".$counter."' value = '".$counter."'>" .$val. "</option>";

                    }

                }

                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>Year</td>
        <td>
            <select id=year name=year>
                <option id = # name = # value = # >Please Select Year</option>
                <?php
                $yearArr = array("2016","2017","2018","2019","2020");
                foreach($yearArr as $keyYear => $valYear)
                {

                    echo "<option id = '".$keyYear."' name = '".$keyYear."' value = '".$valYear."'>" .$valYear. "</option>";

                }

                ?>
            </select>
        </td>
    </tr>


    <tr>
        <td>Cut Off Dates</td>
        <td>
<select id="cutOffID" name="cutOffID">
    <option id = # name = # value = # >Please Select Cut Off Dates</option>
<?php
    foreach($getAllCutOff as $keyCutOff=>$valCutOff)
    {

    echo "<option id='".$valCutOff['cut_off_id']."' value = '".$valCutOff['cut_off_id']."'>";
    echo $valCutOff['cut_off_title'];
    echo "</option>";
    }
?>
</select>
        </td>
    </tr>
	
	    <tr>
        <td>Employees</td>
        <td>
<select id="empid" name="empid">
    <option id = # name = # value = # >Please Select Employee </option>
<?php
    foreach($getAllEmp as $keyEmp=>$valEmp)
    {

    echo "<option id='".$valEmp['emp_id']."' value = '".$valEmp['emp_id']."'>";
    echo $valEmp['empLastName']." ,".$valEmp['empFirstName'];
    echo "</option>";
    }
?>
</select>
        </td>
    </tr>

    <tr>
        <td align = 'center'><input type = "submit" id="btnFilter" name="btnFilter" value ="Filter" /></td>
        <td align = 'center'><a href="payroll_process.php">Refresh Search</a></td>
    </tr>

</table>
    </form>