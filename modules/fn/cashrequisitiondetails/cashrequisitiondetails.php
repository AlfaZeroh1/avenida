<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cashrequisitiondetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Cashrequisitiondetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8452";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$cashrequisitiondetails=new Cashrequisitiondetails();
if(!empty($delid)){
	$cashrequisitiondetails->id=$delid;
	$cashrequisitiondetails->delete($cashrequisitiondetails);
	redirect("cashrequisitiondetails.php");
}
//Authorization.
$auth->roleid="8451";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcashrequisitiondetails_proc.php',600,430);" value="Add Cashrequisitiondetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Cash Requisition </th>
			<th>Expense </th>
			<th>Quantity </th>
			<th>Amount </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="8453";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8454";//View
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
		$fields="fn_cashrequisitiondetails.id, fn_cashrequisitions.name as cashrequisitionid, fn_expenses.name as expenseid, fn_cashrequisitiondetails.quantity, fn_cashrequisitiondetails.amount, fn_cashrequisitiondetails.total, fn_cashrequisitiondetails.ipaddress, fn_cashrequisitiondetails.createdby, fn_cashrequisitiondetails.createdon, fn_cashrequisitiondetails.lasteditedby, fn_cashrequisitiondetails.lasteditedon";
		$join=" left join fn_cashrequisitions on fn_cashrequisitiondetails.cashrequisitionid=fn_cashrequisitions.id  left join fn_expenses on fn_cashrequisitiondetails.expenseid=fn_expenses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$cashrequisitiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$cashrequisitiondetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->cashrequisitionid; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="8453";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcashrequisitiondetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8454";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='cashrequisitiondetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
