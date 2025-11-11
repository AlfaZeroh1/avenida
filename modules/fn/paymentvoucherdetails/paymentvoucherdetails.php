<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentvoucherdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Paymentvoucherdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8144";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$paymentvoucherdetails=new Paymentvoucherdetails();
if(!empty($delid)){
	$paymentvoucherdetails->id=$delid;
	$paymentvoucherdetails->delete($paymentvoucherdetails);
	redirect("paymentvoucherdetails.php");
}
//Authorization.
$auth->roleid="8143";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpaymentvoucherdetails_proc.php',600,430);" value="Add Paymentvoucherdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Payment Voucher </th>
			<th>Cash Requisition </th>
			<th>Payment Requisition </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8145";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8146";//View
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
		$fields="fn_paymentvoucherdetails.id, fn_paymentvouchers.name as paymentvoucherid, fn_cashrequisitions.name as cashrequisitionid, fn_paymentrequisitions.name as paymentrequisitionid, fn_paymentvoucherdetails.amount, fn_paymentvoucherdetails.remarks, fn_paymentvoucherdetails.ipaddress, fn_paymentvoucherdetails.createdby, fn_paymentvoucherdetails.createdon, fn_paymentvoucherdetails.lasteditedby, fn_paymentvoucherdetails.lasteditedon";
		$join=" left join fn_paymentvouchers on fn_paymentvoucherdetails.paymentvoucherid=fn_paymentvouchers.id  left join fn_cashrequisitions on fn_paymentvoucherdetails.cashrequisitionid=fn_cashrequisitions.id  left join fn_paymentrequisitions on fn_paymentvoucherdetails.paymentrequisitionid=fn_paymentrequisitions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$paymentvoucherdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$paymentvoucherdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->paymentvoucherid; ?></td>
			<td><?php echo $row->cashrequisitionid; ?></td>
			<td><?php echo $row->paymentrequisitionid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8145";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpaymentvoucherdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8146";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='paymentvoucherdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
