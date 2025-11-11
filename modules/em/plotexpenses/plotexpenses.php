<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotexpenses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addplotexpenses_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Plotexpenses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4355";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotexpenses=new Plotexpenses();
if(!empty($delid)){
	$plotexpenses->id=$delid;
	$plotexpenses->delete($plotexpenses);
	redirect("plotexpenses.php");
}
//Authorization.
$auth->roleid="4354";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addplotexpenses_proc.php'>New Plotexpenses</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Expense </th>
			<th>Quantity </th>
			<th>Amount </th>
			<th>Total </th>
			<th>Expense Date </th>
			<th>Document No </th>
			<th>Month </th>
			<th>Year </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4356";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4357";//View
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
		$fields="em_plotexpenses.id, em_plots.name as plotid, fn_expenses.name as expenseid, em_plotexpenses.quantity, em_plotexpenses.amount, em_plotexpenses.total, em_plotexpenses.expensedate, em_plotexpenses.documentno, em_plotexpenses.month, em_plotexpenses.year, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_plotexpenses.chequeno, em_plotexpenses.remarks, em_plotexpenses.ipaddress, em_plotexpenses.createdby, em_plotexpenses.createdon, em_plotexpenses.lasteditedby, em_plotexpenses.lasteditedon";
		$join=" left join em_plots on em_plotexpenses.plotid=em_plots.id  left join fn_expenses on em_plotexpenses.expenseid=fn_expenses.id  left join sys_paymentmodes on em_plotexpenses.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_plotexpenses.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotexpenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotexpenses->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo formatDate($row->expensedate); ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4356";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addplotexpenses_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4357";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotexpenses.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
