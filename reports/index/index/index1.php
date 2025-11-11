<?php
session_start();
require_once"../../../lib.php";

if(empty($_SESSION['userid'])){;
redirect("../../../modules/auth/users/login.php");
}

$page_title="Reports";
include"../../../head.php";
?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">PATIENTS</a></li>
		<li><a href="#tabs-2">SALES</a></li>
		<li><a href="#tabs-3">INVENTORY</a></li>
		<li><a href="#tabs-4">FINANCE</a></li>
		<li><a href="#tabs-5">HRM</a></li>
		<li><a href="#tabs-6">PAYROLL</a></li>
		
	      
       	
	</ul>
	<div id="tabs-1" style="min-height:420px;">
			<ul>
			<li><a class="button icon" href="javascript:poptastic('../../hos/patients/patients.php',700,1020);">Patients </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/patientappointments/patientappointments.php',700,1020);">Appointments </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/patientlaboratorytests/patientlaboratorytests.php',700,1020);">Laboratory Tests </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/patientotherservices/patientotherservices.php',700,1020);">Other Services </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/patientprescriptions/patientprescriptions.php',700,1020);">Prescriptions </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/patienttreatments/patienttreatments.php',700,1020);">Treatments </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/payables/payables.php',700,1020);">Payables </a></li>
				<li><a class="button icon" href="javascript:poptastic('../../hos/payments/payments.php',700,1020);">Payments </a></li>
			</ul>
            		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    <div id="tabs-2" style="min-height:420px;">
    <ul>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/sales/sales.php',700,1020);">Sales Report</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/saleorders/saleorders.php',700,1020);">Sale Orders Report</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/customers/customers.php',700,1020);">Customers Report</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/quotations/quotations.php',700,1020);">Quotations Report</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/returninwards/returninwards.php',700,1020);">Returns Report</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?acctype=29&filter=true&balance=true',700,1020);">Customer Accounts</a></li>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    <div id="tabs-3" style="min-height:420px;">
    			<ul>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/items/items.php',700,1020);">Items Report </a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/items/items.php',700,1020);">Reorder Level Report </a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/items/items.php',700,1020);">Out of Stock Report </a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/issuance/issuance.php',700,1020);">Issuance</a></li>    		
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/purchaseorders/purchaseorders.php',700,1020);">Purchase Orders Report </a></li>	
				<li><a class="button icon chat" href="javascript:poptastic('../../inv/purchases/purchases.php',700,1020);">Purchases Report </a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../proc/suppliers/suppliers.php',700,1020);">Suppliers Report </a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../inv/returnoutwards/returnoutwards.php',700,1020);">Returns Report </a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../inv/returnnotes/returnnotes.php',700,1020);">Return Notes Report </a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?acctype=30&filter=true&balance=true',700,1020);">Supplier Accounts</a></li>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    
    <div id="tabs-4" style="min-height:420px;">
    			<ul>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/inctransactions/inctransactions.php',700,1020);">Incomes</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/exptransactions/exptransactions.php',700,1020);">Expenses</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/supplierpayments/supplierpayments.php',700,1020);">Supplier Payments</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/customerpayments/customerpayments.php',700,1020);">Customer Payments</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournalaccounts/generaljournalaccounts.php',700,1020);">Journal Accounts</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php',700,1020);">Chart of Accounts</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?tb=true',700,1020);">Trial Balance</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?acctype=8&balance=true',700,1020);">Banks</a></li>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    
     <div id="tabs-5" style="min-height:420px;">
    			<ul>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employees/employees.php',700,1020);">Employees</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeedocuments/employeedocuments.php',700,1020);">Employee Documents</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeequalifications/employeequalifications.php',700,1020);">Employee Qualifications</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeecontracts/employeecontracts.php',700,1020);">Employee Contracts</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeinsurances/employeeinsurances.php',700,1020);">Employee Insurances</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeedisplinarys/employeedisplinarys.php',700,1020);">Employee Discplinaries</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeclockings/employeeclockings.php',700,1020);">Clockings</a></li>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    
     <div id="tabs-6" style="min-height:420px;">
    			<ul>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeepayments/employeepayments.php',700,1020);">Employee Payments</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeallowances/employeeallowances.php',700,1020);">Employee Allowances</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeedeductions/employeedeductions.php',700,1020);">Employee Deductions</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeesurchages/employeesurchages.php',700,1020);">Employee Surchages</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeloans/employeeloans.php',700,1020);">Employee Loans</a></li>
			</ul>
    		<div style="clear:both;"></div>
    
 
    
 
    		
 
    
 </div> <!-- tabsEnd -->
 
     		<div style="clear:both;"></div>
<?php
include"../../../foot.php";
?>
