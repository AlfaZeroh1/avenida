<?php
session_start();
require_once '../../../lib.php';

if(empty($_SESSION['userid'])){;
redirect("../../auth/users/login.php");
}

$page_title="Properties";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../em/payables/payables.php">Tenant Invoices</a></li>
	<li><a class="button icon chat" href="../../em/payables/addpayables_proc.php?retrieve=1">Retrieve Tenant Invoices</a></li>
	<li><a class="button icon chat" href="../../em/tenantpayments/tenantpayments.php">Tenant Payments</a></li>
	<li><a class="button icon chat" href="../../em/tenantpayments/addtenantpayments_proc.php?retrieve=1">Retrieve Tenant Payments</a></li>
	<li><a class="button icon chat" href="../../em/tenantrefunds/tenantrefunds.php">Tenant Refunds</a></li>	
	<li><a class="button icon chat" href="../../em/tenantrefunds/tenantrefunds.php?retrieve=1">Retrieve Tenant Refunds</a></li>
	<li><a class="button icon chat" href="../../em/landlordpayments/landlordpayments.php">Landlord Payments</a></li>
	<li><a class="button icon chat" href="../../em/landlordpayments/landlordpayments.php?retrieve=1">Retrieve Landlord Payments</a></li>
	<li><a class="button icon chat" href="../../em/landlordreceipts/landlordreceipts.php">Landlord Receipts</a></li>	
	<li><a class="button icon chat" href="../../em/landlordreceipts/addlandlordreceipts_proc.php?retrieve=1">Retrieve Landlord Receipts</a></li>
	<li><a class="button icon chat" href="../../em/landlordpayables/landlordpayables.php">Landlord Invoices</a></li>	
	<li><a class="button icon chat" href="../../em/landlordpayables/addlandlordpayables_proc.php?retrieve=1">Retrieve Landlord Invoices</a></li>
	<li><a class="button icon chat" href="../../em/landlordtransfers/landlordtransfers.php">Landlord Transfers</a></li>	
	<li><a class="button icon chat" href="../../em/landlordtransfers/addlandlordtransfers_proc.php?retrieve=1">Retrieve Landlord Transfers</a></li>
	<li><a class="button icon chat" href="../../fn/exptransactions/exptransactions.php">Property Expenses</a></li>
	<li><a class="button icon chat" href="../../fn/exptransactions/exptransactions.php?retrieve=1">Retrieve Property Expenses</a></li>
	<li><a class="button icon chat" href="../../em/vacanthousereports/addvacanthousereports_proc.php">Vacant Units Reports</a></li>
	<li><a class="button icon chat" href="../../em/housenotices/housenotices.php">Units Notices</a></li>
	<li><a class="button icon chat" href="../../em/vacanthousereports/vacanthousereports.php">View Vacant Units Reports</a></li>
	<li><a class="button icon chat" href="../../em/payables/invoicing.php">Batch Invoicing</a></li>
	<li><a class="button icon chat" href="../em/payables/penaltys.php">Batch Penaltys</a></li>
	<li><a class="button icon chat" href="../../em/landlordpayments/batchlandlordpayments_proc.php">Batch Landlord Payments</a></li>
	<li><a class="button icon chat" href="../../em/landlordpayments/batchlandlordpayments_proc.php?retrieve=1">Retrieve Batch Landlord Payments</a></li>
	<li><a class="button icon chat" href="tools/">SYSTEM SETUP</a></li>
	
</ul>
<?php
include"../../../foot.php";
?>
