<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Payments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1178";//View
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
$auth->roleid="1177";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addpayments_proc.php',600,540);"><span>ADD PAYMENTS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Mode Of Payment </th>
			<th>Assignment </th>
			<th>Bank </th>
			<th>Bank Acc. </th>
			<th>Year </th>
			<th>Month </th>
			<th>Gross </th>
			<th>PAYE </th>
			<th>Pay Date </th>
			<th>Days </th>
<?php
//Authorization.
$auth->roleid="1179";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1180";//View
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
		$fields="hrm_payments.id, hrm_payments.employeeid, hrm_payments.paymentmodeid, hrm_payments.assignmentid, hrm_payments.bank, hrm_payments.bankacc, hrm_payments.year, hrm_payments.month, hrm_payments.gross, hrm_payments.paye, hrm_payments.paydate, hrm_payments.days, hrm_payments.createdby, hrm_payments.createdon, hrm_payments.lasteditedby, hrm_payments.lasteditedon";
		$join="";
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
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo $row->bank; ?></td>
			<td><?php echo $row->bankacc; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo formatNumber($row->gross); ?></td>
			<td><?php echo formatNumber($row->paye); ?></td>
			<td><?php echo formatDate($row->paydate); ?></td>
			<td><?php echo $row->days; ?></td>
<?php
//Authorization.
$auth->roleid="1179";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpayments_proc.php?id=<?php echo $row->id; ?>',600,540);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1180";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
