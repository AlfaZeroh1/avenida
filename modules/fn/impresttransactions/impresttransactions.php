<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Impresttransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addimpresttransactions_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Impresttransactions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8136";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$impresttransactions=new Impresttransactions();
if(!empty($delid)){
	$impresttransactions->id=$delid;
	$impresttransactions->delete($impresttransactions);
	redirect("impresttransactions.php");
}
//Authorization.
$auth->roleid="8135";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addimpresttransactions_proc.php'>New Impresttransactions</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Imprest No </th>
			<th>Imprest Account </th>
			<th>Imprest </th>
			<th>Memo </th>
			<th>Quantity </th>
			<th>Amount </th>
			<th>Transaction Date </th>
			<th>Entered On </th>
			<th>Remarks </th>
			<th>Status </th>
			<th>Expense </th>
<?php
//Authorization.
$auth->roleid="8137";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8138";//View
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
		$fields="fn_impresttransactions.id, fn_impresttransactions.documentno, fn_imprestaccounts.name as imprestaccountid, fn_imprests.name as imprestid, fn_impresttransactions.memo, fn_impresttransactions.quantity, fn_impresttransactions.amount, fn_impresttransactions.incurredon, fn_impresttransactions.enteredon, fn_impresttransactions.remarks, fn_impresttransactions.status, fn_impresttransactions.ipaddress, fn_impresttransactions.createdby, fn_impresttransactions.createdon, fn_impresttransactions.lasteditedby, fn_impresttransactions.lasteditedon, fn_expenses.name as expenseid";
		$join=" left join fn_imprestaccounts on fn_impresttransactions.imprestaccountid=fn_imprestaccounts.id  left join fn_imprests on fn_impresttransactions.imprestid=fn_imprests.id  left join fn_expenses on fn_impresttransactions.expenseid=fn_expenses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$impresttransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$impresttransactions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->imprestaccountid; ?></td>
			<td><?php echo $row->imprestid; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->incurredon); ?></td>
			<td><?php echo formatDate($row->enteredon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->expenseid; ?></td>
<?php
//Authorization.
$auth->roleid="8137";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addimpresttransactions_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8138";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='impresttransactions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
