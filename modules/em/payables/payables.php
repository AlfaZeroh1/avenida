<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpayables_proc.php");

$page_title="Payables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4254";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$payables=new Payables();
if(!empty($delid)){
	$payables->id=$delid;
	$payables->delete($payables);
	redirect("payables.php");
}
//Authorization.
$auth->roleid="4253";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="button icon chat" href='addpayables_proc.php'><span>New Payables</span></a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Invoice No </th>
			<th>Payment Term </th>
			<th>House </th>
			<th>Tenant </th>
			<th>Month </th>
			<th>Year </th>
			<th>Invoiced On </th>
			<th>Quantity </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4255";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4256";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_payables.id, em_payables.documentno, em_paymentterms.name as paymenttermid, em_houses.name as houseid, em_tenants.name as tenantid, em_payables.month, em_payables.year, em_payables.invoicedon, em_payables.quantity, em_payables.amount, em_payables.remarks";
		$join=" left join em_paymentterms on em_payables.paymenttermid=em_paymentterms.id  left join em_houses on em_payables.houseid=em_houses.id  left join em_tenants on em_payables.tenantid=em_tenants.id ";
		$having="";
		$groupby="";
		$orderby="";
		$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payables->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->invoicedon); ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4255";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpayables_proc.php?id=<?php echo $row->id; ?>"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4256";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payables.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
