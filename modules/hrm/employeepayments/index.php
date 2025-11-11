<?php
session_start();
require_once("../../../lib.php");
$page_title="Payroll";
include"../../../head.php";

?>
<ul id="cmd-buttons">
	
	<li><a class="button icon chat" href="../../hrm/employees/employees.php?sys=true">Employee List</a></li>
	<li><a class="button icon chat" href="../../hrm/deductiontypes/deductiontypes.php">Deduction Types</a></li>
	<li><a class="button icon chat" href="../../hrm/allowancetypes/allowancetypes.php">Allowance Types</a></li>
	<li><a class="button icon chat" href="../../hrm/arrears/arrears.php">Arrears Types</a></li>
	<li><a class="button icon chat" href="../../hrm/deductions/deductions.php">Deductions</a></li>
	<li><a class="button icon chat" href="../../hrm/allowances/allowances.php">Allowances</a></li>
	<li><a class="button icon chat" href="../../hrm/overtimes/overtimes.php">Overtimes</a></li><!--
	<li><a class="button icon chat" href="../../hrm/employeearrears/employeearrears.php">Employee Arrears</a></li>
	<li><a class="button icon chat" href="../../hrm/employeedeductions/employeedeductions.php">Employee Deductions</a></li>-->
	<li><a class="button icon chat" href="../../hrm/employeeloans/employeeloans.php">Employee Loans</a></li>
	<li><a class="button icon chat" href="../../hrm/surchages/surchages.php">Surchages</a></li>
	<li><a class="button icon chat" href="../../hrm/surchagetypes/surchagetypes.php">Surchage Types</a></li>
	<li><a class="button icon chat" href="../../hrm/employeesurchages/employeesurchages.php">Employee Surchages</a></li>
	<li><a class="button icon chat" href="../../hrm/loans/loans.php">Loans</a></li>
	<li><a class="button icon chat" href="../../hrm/reliefs/reliefs.php">Reliefs</a></li>
	<li><a class="button icon chat" href="../../hrm/payes/payes.php">PAYE</a></li>
	<li><a class="button icon chat" href="../../hrm/nhifs/nhifs.php">NHIF</a></li>
	<li><a class="button icon chat" href="../../hrm/nssfs/nssfs.php">NSSF</a></li>
	<li><a class="button icon chat" href="../../hrm/employeepayments/employeepayments_proc.php">Make Payments</a></li>
	<li><a class="button icon chat" href="../../hrm/employeepayments/employeepaidpayments.php">View Payments</a></li>
	<li><a class="button icon chat" href="../../hrm/employeedeductionexempt/employeedeductionexempt.php">Deduction Exempt</a></li>
	
</ul>