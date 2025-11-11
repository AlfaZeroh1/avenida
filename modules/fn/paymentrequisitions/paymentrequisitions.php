<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentrequisitions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Paymentrequisitions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7607";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$paymentrequisitions=new Paymentrequisitions();
if(!empty($delid)){
	$paymentrequisitions->id=$delid;
	$paymentrequisitions->delete($paymentrequisitions);
	redirect("paymentrequisitions.php");
}
//Authorization.
$auth->roleid="7606";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpaymentrequisitions_proc.php',600,430);" value="Add Paymentrequisitions " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requsition No </th>
			<th>Supplier </th>
			<th>Invoice No(s) </th>
			<th>Amount </th>
			<th>Requisition Date </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="7608";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7609";//View
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
		$fields="fn_paymentrequisitions.id, fn_paymentrequisitions.documentno, proc_suppliers.name as supplierid, fn_paymentrequisitions.invoicenos, fn_paymentrequisitions.amount, fn_paymentrequisitions.requisitiondate, fn_paymentrequisitions.remarks, fn_paymentrequisitions.status, fn_paymentrequisitions.ipaddress, fn_paymentrequisitions.createdby, fn_paymentrequisitions.createdon, fn_paymentrequisitions.lasteditedby, fn_paymentrequisitions.lasteditedon";
		$join=" left join proc_suppliers on fn_paymentrequisitions.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$paymentrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$paymentrequisitions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->invoicenos; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->requisitiondate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="7608";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpaymentrequisitions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7609";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='paymentrequisitions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
