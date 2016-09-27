<?php
include "../ewcfg10.php";
include "DAO.php";
// include "billingDAO.php";
include "userDAO.php";
include "leaveCreditDAO.php";
include "leaveApplicationDAO.php";


//$mytester = new billingDAO();
//$test = $mytester->getLoanData(2);
//$test = $mytester->getSavingsPaidToDate(12,"2012-03-28");
//$test = $mytester->getSKAEF(12);

$leaveCreditDAO = new leaveCreditDAO();
$getLeaveCreditByEmp = $leaveCreditDAO->getLeaveCreditByEmp("1","1");


?>
<pre>
<?php print_r($getLeaveCreditByEmp); ?>
</pre>

