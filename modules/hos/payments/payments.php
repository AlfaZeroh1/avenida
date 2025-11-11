<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payments_class.php");
require_once("../../auth/rules/Rules_class.php");
// require_once("../../sys/paymentmodes/Paymentmodes_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpayments_proc.php");

$page_title="Payments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1304";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$payments=new Payments();
if(!empty($delid)){
	$payments->id=$delid;
	$payments->delete($payments);
	redirect("payments.php");
}
//Authorization.
$auth->roleid="1303";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addpayments_proc.php'>New Payments</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Receipt No </th>
			<th>Patient </th>
			<th>Bill Term </th>
			<th>Payee </th>
			<th>Amount </th>
			<th>Remarks </th>
			<th>Payment Date </th>
			<th>Consult </th>
<?php
//Authorization.
$auth->roleid="1305";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1306";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_payments.id, hos_payments.documentno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, sys_transactions.name as transactionid, hos_payments.payee, hos_payments.amount, hos_payments.remarks, hos_payments.paidon, hos_payments.consult, hos_payments.createdby, hos_payments.createdon, hos_payments.lasteditedby, hos_payments.lasteditedon";
		$join=" left join hos_patients on hos_payments.patientid=hos_patients.id  left join sys_transactions on hos_payments.transactionid=sys_transactions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->patientid; ?></td>
			<td><?php echo $row->transactionid; ?></td>
			<td><?php echo $row->payee; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->consult; ?></td>
<?php
//Authorization.
$auth->roleid="1305";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpayments_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1306";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
