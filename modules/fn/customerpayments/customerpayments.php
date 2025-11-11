<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customerpayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7487";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customerpayments=new Customerpayments();
if(!empty($delid)){
	$customerpayments->id=$delid;
	$customerpayments->delete($customerpayments);
	redirect("customerpayments.php");
}
//Authorization.
$auth->roleid="7486";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcustomerpayments_proc.php',600,430);" value="Add Customerpayments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer </th>
			<th>Voucher No </th>
			<th>Payment Date </th>
			<th>Amount </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
<?php
//Authorization.
$auth->roleid="7488";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7489";//View
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
		$fields="fn_customerpayments.id, fn_customerpayments.customerid, fn_customerpayments.documentno, fn_customerpayments.paidon, fn_customerpayments.amount, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, fn_customerpayments.chequeno, fn_customerpayments.ipaddress, fn_customerpayments.createdby, fn_customerpayments.createdon, fn_customerpayments.lasteditedby, fn_customerpayments.lasteditedon";
		$join=" left join sys_paymentmodes on fn_customerpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_customerpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$customerpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$customerpayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
<?php
//Authorization.
$auth->roleid="7488";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcustomerpayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7489";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='customerpayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
