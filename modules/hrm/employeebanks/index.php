<?php
session_start();

require_once '../../../lib.php';

$sys = $_GET['sys'];

if($sys)
	redirect("../employeepayments/");
$page_title="HRM";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("hrm","bankbranches")){?>
	<li><a class="button icon chat" href="../../hrm/bankbranches/bankbranches.php">Bank Branches</a></li>
	<?php }if(checkSubModule("hrm","employeebanks")){?>
	<li><a class="button icon chat" href="../../hrm/employeebanks/employeebanks.php">Employee Banks</a></li>
	<?php }if(checkSubModule("hrm","insurances")){?>
	<li><a class="button icon chat" href="../../hrm/insurances/insurances.php">Insurance</a></li>
	
	<?php }?>
</ul>
<?php
include"../../../foot.php";
?>