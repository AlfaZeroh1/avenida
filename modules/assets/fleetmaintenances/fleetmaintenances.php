<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetmaintenances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetmaintenances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8472";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetmaintenances=new Fleetmaintenances();
if(!empty($delid)){
	$fleetmaintenances->id=$delid;
	$fleetmaintenances->delete($fleetmaintenances);
	redirect("fleetmaintenances.php");
}
//Authorization.
$auth->roleid="8471";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetmaintenances_proc.php',600,430);" value="Add Fleetmaintenances " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Maintenance Date </th>
			<th>Start Mileage </th>
			<th>End Mileage </th>
			<th>Supplier </th>
			<th>Purchase Mode </th>
			<th>Oil Added (Ltrs) </th>
			<th>Oil Cost </th>
			<th>Fuel Added (Ltrs) </th>
			<th>Fuel Cost </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8473";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8474";//Add
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
		$fields="assets_fleetmaintenances.id, assets_assets.name as assetid, assets_fleetmaintenances.maintenanceon, assets_fleetmaintenances.startmileage, assets_fleetmaintenances.endmileage, proc_suppliers.name as supplierid, sys_purchasemodes.name as purchasemodeid, assets_fleetmaintenances.oiladded, assets_fleetmaintenances.oilcost, assets_fleetmaintenances.fueladded, assets_fleetmaintenances.fuelcost, assets_fleetmaintenances.remarks, assets_fleetmaintenances.ipaddress, assets_fleetmaintenances.createdby, assets_fleetmaintenances.createdon, assets_fleetmaintenances.lasteditedby, assets_fleetmaintenances.lasteditedon";
		$join=" left join assets_assets on assets_fleetmaintenances.assetid=assets_assets.id  left join proc_suppliers on assets_fleetmaintenances.supplierid=proc_suppliers.id  left join sys_purchasemodes on assets_fleetmaintenances.purchasemodeid=sys_purchasemodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$fleetmaintenances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetmaintenances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo formatDate($row->maintenanceon); ?></td>
			<td><?php echo formatNumber($row->startmileage); ?></td>
			<td><?php echo formatNumber($row->endmileage); ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->purchasemodeid; ?></td>
			<td><?php echo formatNumber($row->oiladded); ?></td>
			<td><?php echo formatNumber($row->oilcost); ?></td>
			<td><?php echo formatNumber($row->fueladded); ?></td>
			<td><?php echo formatNumber($row->fuelcost); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8473";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetmaintenances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8474";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetmaintenances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
