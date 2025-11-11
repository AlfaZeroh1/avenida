<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Managementfees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Managementfees";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4351";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$managementfees=new Managementfees();
if(!empty($delid)){
	$managementfees->id=$delid;
	$managementfees->delete($managementfees);
	redirect("managementfees.php");
}
//Authorization.
$auth->roleid="4350";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addmanagementfees_proc.php',600,430);" value="Add Managementfees " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tenant/Landlord </th>
			<th>Client Type </th>
			<th>Payment Term </th>
			<th>Perc </th>
			<th>VAT Class </th>
			<th>VAT Amount </th>
			<th>Amount </th>
			<th>Total </th>
			<th>Month </th>
			<th>Year </th>
			<th>Charged On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4352";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4353";//View
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
		$fields="em_managementfees.id, em_managementfees.clientid, em_managementfees.clienttype, em_managementfees.paymenttermid, em_managementfees.perc, em_managementfees.vatclasseid, em_managementfees.vatamount, em_managementfees.amount, em_managementfees.total, em_managementfees.month, em_managementfees.year, em_managementfees.chargedon, em_managementfees.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$managementfees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$managementfees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->clientid; ?></td>
			<td><?php echo $row->clienttype; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->perc); ?></td>
			<td><?php echo $row->vatclasseid; ?></td>
			<td><?php echo formatNumber($row->vatamount); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->chargedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4352";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmanagementfees_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4353";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='managementfees.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
