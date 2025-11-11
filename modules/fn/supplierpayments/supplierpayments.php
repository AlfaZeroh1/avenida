<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Supplierpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addsupplierpayments_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Supplierpayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4734";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$supplierpayments=new Supplierpayments();
if(!empty($delid)){
	$supplierpayments->id=$delid;
	$supplierpayments->delete($supplierpayments);
	redirect("supplierpayments.php");
}
//Authorization.
$auth->roleid="4733";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addsupplierpayments_proc.php'>New Supplierpayments</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
			<th>Voucher No </th>
			<th>Payment Date </th>
			<th>Amount </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
<?php
//Authorization.
$auth->roleid="4735";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4736";//View
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
		$fields="fn_supplierpayments.id, proc_suppliers.name as supplierid, fn_supplierpayments.documentno, fn_supplierpayments.paidon, fn_supplierpayments.amount, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, fn_supplierpayments.chequeno, fn_supplierpayments.ipaddress, fn_supplierpayments.createdby, fn_supplierpayments.createdon, fn_supplierpayments.lasteditedby, fn_supplierpayments.lasteditedon";
		$join=" left join proc_suppliers on fn_supplierpayments.supplierid=proc_suppliers.id  left join sys_paymentmodes on fn_supplierpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_supplierpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$supplierpayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
<?php
//Authorization.
$auth->roleid="4735";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addsupplierpayments_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4736";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='supplierpayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
