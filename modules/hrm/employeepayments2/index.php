<?php
session_start();
require_once("../../../lib.php");
$page_title="Payroll";
include"../../../head.php";

?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("hrm","employees")){?>
	<li><a class="button icon chat" href="../../hrm/employees/employees.php?sys=true">Employee List</a></li>
	<?php } if(checkSubModule("hrm","employees")){?>
	<li><a class="button icon chat" href="../../hrm/deductiontypes/deductiontypes.php">Deduction Types</a></li>
	<?php } if(checkSubModule("hrm","allowancetypes")){?>
	<li><a class="button icon chat" href="../../hrm/allowancetypes/allowancetypes.php">Allowance Types</a></li>
	<?php } if(checkSubModule("hrm","arrears")){?>
	<li><a class="button icon chat" href="../../hrm/arrears/arrears.php">Arrears Types</a></li>
	<?php } if(checkSubModule("hrm","deductions")){?>
	<li><a class="button icon chat" href="../../hrm/deductions/deductions.php">Deductions</a></li>
	<?php } if(checkSubModule("hrm","allowances")){?>
	<li><a class="button icon chat" href="../../hrm/allowances/allowances.php">Allowances</a></li>
	<?php } if(checkSubModule("hrm","overtimes")){?>
	<li><a class="button icon chat" href="../../hrm/overtimes/overtimes.php">Overtimes</a></li><!--
	<?php } if(checkSubModule("hrm","employeeallowances")){?>
	<li><a class="button icon chat" href="../../hrm/employeeallowances/employeeallowances.php">Employee Allowances</a></li>
	<?php } if(checkSubModule("hrm","employeearrears")){?>
	<li><a class="button icon chat" href="../../hrm/employeearrears/employeearrears.php">Employee Arrears</a></li>
	<?php } if(checkSubModule("hrm","employeedeductions")){?>
	<li><a class="button icon chat" href="../../hrm/employeedeductions/employeedeductions.php">Employee Deductions</a></li>-->
	<?php } if(checkSubModule("hrm","employeeloans")){?>
	<li><a class="button icon chat" href="../../hrm/employeeloans/employeeloans.php">Employee Loans</a></li>
	<?php } if(checkSubModule("hrm","surchages")){?>
	<li><a class="button icon chat" href="../../hrm/surchages/surchages.php">Surchages</a></li>
	<?php } if(checkSubModule("hrm","surchagetypes")){?>
	<li><a class="button icon chat" href="../../hrm/surchagetypes/surchagetypes.php">Surchage Types</a></li>
	<?php } if(checkSubModule("hrm","employeesurchages")){?>
	<li><a class="button icon chat" href="../../hrm/employeesurchages/employeesurchages.php">Employee Surchages</a></li>
	<?php } if(checkSubModule("hrm","loans")){?>
	<li><a class="button icon chat" href="../../hrm/loans/loans.php">Loans</a></li>
	<?php } if(checkSubModule("hrm","reliefs")){?>
	<li><a class="button icon chat" href="../../hrm/reliefs/reliefs.php">Reliefs</a></li>
	<?php } if(checkSubModule("hrm","payes")){?>
	<li><a class="button icon chat" href="../../hrm/payes/payes.php">PAYE</a></li>
	<?php } if(checkSubModule("hrm","nhifs")){?>
	<li><a class="button icon chat" href="../../hrm/nhifs/nhifs.php">NHIF</a></li>
	<?php } if(checkSubModule("hrm","nssfs")){?>
	<li><a class="button icon chat" href="../../hrm/nssfs/nssfs.php">NSSF</a></li>
	<?php } if(checkSubModule("hrm","employeepayments")){?>
	<li><a class="button icon chat" href="../../hrm/employeepayments/employeepayments_proc.php">Make Payments</a></li>
	<?php } if(checkSubModule("hrm","employeepayments")){?>
	<li><a class="button icon chat" href="../../hrm/employeepayments/employeepaidpayments.php">View Payments</a></li>
	<li><a class="button icon chat" href="../../hrm/employeepayments/payments.php">Final Dues</a></li>
	<li><a class="button icon chat" href="../../hrm/employeepayments/p9form.php">P9FORM</a></li>
	<?php }?>
</ul>