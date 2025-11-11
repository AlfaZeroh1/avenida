<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantrefunds_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addtenantrefunds_proc.php");

$page_title="Tenantrefunds";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4334";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tenantrefunds=new Tenantrefunds();
if(!empty($delid)){
	$tenantrefunds->id=$delid;
	$tenantrefunds->delete($tenantrefunds);
	redirect("tenantrefunds.php");
}
//Authorization.
$auth->roleid="4333";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addtenantrefunds_proc.php'>New Tenantrefunds</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Refund No </th>
			<th>Tenant </th>
			<th>House </th>
			<th>Paymnet Term </th>
			<th>Amount </th>
			<th>Refunded On </th>
			<th>Paid Through </th>
			<th>Bank </th>
			<th>Cheque No </th>
			<th>Month </th>
			<th>Year </th>
			<th>Received By </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4335";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4336";//View
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
		$fields="em_tenantrefunds.id, em_tenantrefunds.documentno, em_tenants.name as tenantid, em_houses.name as houseid, em_paymentterms.name as paymenttermid, em_tenantrefunds.amount, em_tenantrefunds.refundedon, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_tenantrefunds.chequeno, em_tenantrefunds.month, em_tenantrefunds.year, em_tenantrefunds.receivedby, em_tenantrefunds.remarks";
		$join=" left join em_tenants on em_tenantrefunds.tenantid=em_tenants.id  left join em_houses on em_tenantrefunds.houseid=em_houses.id  left join em_paymentterms on em_tenantrefunds.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantrefunds.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantrefunds.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tenantrefunds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tenantrefunds->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->refundedon); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->receivedby; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4335";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addtenantrefunds_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4336";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tenantrefunds.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
