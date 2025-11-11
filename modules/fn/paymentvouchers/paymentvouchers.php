<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentvouchers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpaymentvouchers_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Paymentvouchers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8148";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$paymentvouchers=new Paymentvouchers();
if(!empty($delid)){
	$paymentvouchers->id=$delid;
	$paymentvouchers->delete($paymentvouchers);
	redirect("paymentvouchers.php");
}
//Authorization.
$auth->roleid="8147";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addpaymentvouchers_proc.php'>New Paymentvouchers</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No </th>
			<th>Payment Voucher No </th>
			<th>Voucher Date </th>
			<th>Payee </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
			<th>Cheque Date </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8149";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8150";//View
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
		$fields="fn_paymentvouchers.id, fn_paymentvouchers.documentno, fn_paymentvouchers.voucherno, fn_paymentvouchers.voucherdate, fn_paymentvouchers.payee, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, fn_paymentvouchers.chequeno, fn_paymentvouchers.chequedate, fn_paymentvouchers.remarks, fn_paymentvouchers.status, fn_paymentvouchers.ipaddress, fn_paymentvouchers.createdby, fn_paymentvouchers.createdon, fn_paymentvouchers.lasteditedby, fn_paymentvouchers.lasteditedon";
		$join=" left join sys_paymentmodes on fn_paymentvouchers.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_paymentvouchers.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$paymentvouchers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$paymentvouchers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->voucherno; ?></td>
			<td><?php echo formatDate($row->voucherdate); ?></td>
			<td><?php echo $row->payee; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatDate($row->chequedate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8149";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpaymentvouchers_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8150";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='paymentvouchers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
