<?php
session_start();

$page_title="Generaljournals";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../fn/incomes/incomes.php">Income List</a></li>
	<li><a class="button icon chat" href="../../fn/liabilitys/liabilitys.php">Liability List</a></li>
	<li><a class="button icon chat" href="../../fn/expensetypes/expensetypes.php">Expense Types</a></li>
	<li><a class="button icon chat" href="../../fn/expenses/expenses.php">Expense List</a></li>
	<li><a class="button icon chat" href="../../fn/banks/banks.php">Banks</a></li>
	<li><a class="button icon chat" href="../../hos/insurances/insurances.php">Insurances</a></li>
	<li><a class="button icon chat" href="../../fn/generaljournalaccounts/generaljournalaccounts.php">Journal Accounts</a></li>
	<li><a class="button icon chat" href="../../fn/imprestaccounts/imprestaccounts.php">Imprest Accounts</a></li>
	<li><a class="button icon chat" href="../../fn/inctransactions/inctransactions.php">Income</a></li>
	<li><a class="button icon chat" href="../../fn/exptransactions/exptransactions.php">Expenses</a></li>
	<li><a class="button icon chat" href="../../fn/generaljournals/generaljournals.php">Journal Vouchers</a></li>
	<li><a class="button icon chat" href="../../fn/generaljournals/generaljournals.php?retrieve=1">Retrieve Jounal Vouchers</a></li>
	<li><a class="button icon chat" href="../../fn/bankreconciliations/withdrawals.php">Withdrawals</a></li>
	<li><a class="button icon chat" href="../../fn/bankreconciliations/deposits.php">Deposit</a></li>
	<li><a class="button icon chat" href="../../fn/bankreconciliations/banktransfers.php">Bank Transfers</a></li>
	<li><a class="button icon chat" href="../../fn/bankreconciliations/reconciliation.php">Bank Reconciliation</a></li>
	<li><a class="button icon chat" href="../../fn/bankreconciliations/bankreconciliations.php">Reconciliations Done</a></li>
	<li><a class="button icon chat" href="../../proc/suppliers/suppliers.php">Suppliers</a></li>
	<li><a class="button icon chat" href="../../proc/suppliercategorys/suppliercategorys.php">Supplier Categorys</a></li>
	<li><a class="button icon chat" href="../../fn/supplierpayments/supplierpayments.php">Supplier Payments</a></li>
	<li><a class="button icon chat" href="../../fn/customerpayments/addcustomerpayments_proc.php">Customer Remmittance</a></li>
	<li><a class="button icon chat" href="../../fn/imprests/imprests.php">Imprests</a></li>
	<li><a class="button icon chat" href="../../fn/impresttransactions/impresttransactions.php">Imprest Transactions</a></li>
	<li><a class="button icon chat" href="../../fn/cashrequisitions/cashrequisitions.php">Cash Requisitions</a></li>
	<li><a class="button icon chat" href="../../fn/paymentrequisitions/paymentrequisitions.php">Payment Requisitions</a></li>
	<li><a class="button icon chat" href="../../fn/paymentvouchers/paymentvouchers.php">Payment Vouchers</a></li>
</ul>
<?php
include"../../../foot.php";
?>
