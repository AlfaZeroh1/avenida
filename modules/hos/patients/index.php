<?php
session_start();

$page_title="Patients";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon" href="patients.php">Patients</a></li>
	<li><a class="button icon" href="../patientappointments/patientappointments.php">Appointments</a></li>
	<li><a class="button icon" href="javascript:;" onclick="showPopWin('../patientlaboratorytests/addpatientlaboratorytestss_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Laboratory Tests</a></li>
	<li><a class="button icon" href="javascript:;" onclick="showPopWin('../patientotherservices/addpatientotherservicess_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Other Services</a></li>
	<li><a class="button icon" href="../payments/addpayments_proc.php">Payments</a></li>
	<li><a class="button icon" href="../payments/addpayments_proc.php?status=creditnote">Credit Note</a></li>
	<li><a class="button icon" href="../payments/addpayments_proc.php?retrieve=1">Retrieve Payments</a></li>
	<li><a class="button icon" href="../payables/payables.php">Payments List</a></li>
	<li><a class="button icon" href="../../sys/transactions/transactions.php?moduleid=8">Bills List</a></li>
	<li><a class="button icon" href="../otherservices/otherservices.php">Other Services List</a></li>
</ul>
<?php
include"../../../foot.php";
?>
