<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tenantdeposits";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9061";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tenantdeposits=new Tenantdeposits();
if(!empty($delid)){
	$tenantdeposits->id=$delid;
	$tenantdeposits->delete($tenantdeposits);
	redirect("tenantdeposits.php");
}
//Authorization.
$auth->roleid="9060";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtenantdeposits_proc.php',600,430);" value="Add Tenantdeposits " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tenant </th>
			<th>Unit </th>
			<th> </th>
			<th> </th>
			<th>Payment Term </th>
			<th>Amount </th>
			<th>Date Paid </th>
			<th>Remarks </th>
			<th>With Landlord/Office </th>
<?php
//Authorization.
$auth->roleid="9062";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9063";//View
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
		$fields="em_tenantdeposits.id, em_tenants.name as tenantid, em_houses.name as houseid, em_tenantdeposits.houserentingid, em_tenantdeposits.tenantpaymentid, em_paymentterms.name as paymenttermid, em_tenantdeposits.amount, em_tenantdeposits.paidon, em_tenantdeposits.remarks, em_tenantdeposits.status, em_tenantdeposits.ipaddress, em_tenantdeposits.createdby, em_tenantdeposits.createdon, em_tenantdeposits.lasteditedby, em_tenantdeposits.lasteditedon";
		$join=" left join em_tenants on em_tenantdeposits.tenantid=em_tenants.id  left join em_houses on em_tenantdeposits.houseid=em_houses.id  left join em_paymentterms on em_tenantdeposits.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tenantdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tenantdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->houserentingid; ?></td>
			<td><?php echo $row->tenantpaymentid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="9062";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtenantdeposits_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9063";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tenantdeposits.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
