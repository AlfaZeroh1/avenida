<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Exptransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addexptransactions_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Exptransactions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="752";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$exptransactions=new Exptransactions();
if(!empty($delid)){
	$exptransactions->id=$delid;
	$exptransactions->delete($exptransactions);
	redirect("exptransactions.php");
}
//Authorization.
$auth->roleid="751";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addexptransactions_proc.php'>New Exptransactions</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Expense </th>
			<th>Project </th>
			<th>Supplier </th>
			
			<th>Quantity </th>
			<th>Tax </th>
			<th>Discount </th>
			<th>Amount </th>
			<th>Total </th>
			<th>Expense Date </th>
			<th>Paid </th>
			<th>Remarks </th>
			<th>Memo </th>
			<th>Document No. </th>
<?php
//Authorization.
$auth->roleid="753";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="754";//View
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
		$fields="fn_exptransactions.id, fn_expenses.name as expenseid, con_projects.name as projectid, proc_suppliers.name as supplierid, sys_purchasemodes.name as purchasemodeid, fn_exptransactions.quantity, fn_exptransactions.tax, fn_exptransactions.discount, fn_exptransactions.amount, fn_exptransactions.total, fn_exptransactions.expensedate, fn_exptransactions.paid, fn_exptransactions.remarks, fn_exptransactions.memo, fn_exptransactions.documentno, fn_exptransactions.ipaddress, fn_exptransactions.createdby, fn_exptransactions.createdon, fn_exptransactions.lasteditedby, fn_exptransactions.lasteditedon";
		$join=" left join fn_expenses on fn_exptransactions.expenseid=fn_expenses.id  left join con_projects on fn_exptransactions.projectid=con_projects.id  left join proc_suppliers on fn_exptransactions.supplierid=proc_suppliers.id  left join sys_purchasemodes on fn_exptransactions.purchasemodeid=sys_purchasemodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$exptransactions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->purchasemodeid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo formatDate($row->expensedate); ?></td>
			<td><?php echo $row->paid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->documentno; ?></td>
<?php
//Authorization.
$auth->roleid="753";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addexptransactions_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="754";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='exptransactions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
