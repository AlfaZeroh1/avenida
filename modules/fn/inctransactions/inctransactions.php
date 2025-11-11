<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inctransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addinctransactions_proc.php?retrieve=".$_GET['retrieve']);
 
$page_title="Inctransactions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="752";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$inctransactions=new Inctransactions();
if(!empty($delid)){
	$inctransactions->id=$delid;
	$inctransactions->delete($inctransactions);
	redirect("inctransactions.php");
}
//Authorization.
$auth->roleid="751";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addinctransactions_proc.php'>New Inctransactions</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Income </th>
			<th>Project </th>
			<th>Supplier </th>
			<th>Purchase Mode </th>
			<th>Quantity </th>
			<th>Tax </th>
			<th>Discount </th>
			<th>Amount </th>
			<th>Total </th>
			<th>Income Date </th>
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
		$fields="fn_inctransactions.id, fn_expenses.name as expenseid, em_plots.name as plotid, proc_suppliers.name as supplierid, sys_purchasemodes.name as purchasemodeid, fn_inctransactions.quantity, fn_inctransactions.tax, fn_inctransactions.discount, fn_inctransactions.amount, fn_inctransactions.total, fn_inctransactions.expensedate, fn_inctransactions.paid, fn_inctransactions.remarks, fn_inctransactions.memo, fn_inctransactions.documentno, fn_inctransactions.ipaddress, fn_inctransactions.createdby, fn_inctransactions.createdon, fn_inctransactions.lasteditedby, fn_inctransactions.lasteditedon";
		$join=" left join fn_expenses on fn_inctransactions.expenseid=fn_expenses.id  left join em_plots on fn_inctransactions.projectid=em_plots.id  left join proc_suppliers on fn_inctransactions.supplierid=proc_suppliers.id  left join sys_purchasemodes on fn_inctransactions.purchasemodeid=sys_purchasemodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$inctransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inctransactions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo $row->plotid; ?></td>
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
			<td><a href="addinctransactions_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="754";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='inctransactions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
