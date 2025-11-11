<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetfueling_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetfueling";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7720";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetfueling=new Fleetfueling();
if(!empty($delid)){
	$fleetfueling->id=$delid;
	$fleetfueling->delete($fleetfueling);
	redirect("fleetfueling.php");
}
//Authorization.
$auth->roleid="7719";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetfueling_proc.php',600,430);" value="Add Fleetfueling " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Vehicle </th>
			<th>Quantity(Ltrs) </th>
			<th>Cost </th>
			<th>Date </th>
			<th>Driver </th>
			<th>Reference No </th>
			<th>Start Odometer Reading </th>
			<th>End Odometer </th>
			<th>Destination </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7721";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7722";//Add
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
		$fields="assets_fleets.id, assets_assets.name assetid, assets_fleetmodels.name as fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleettypes.name as fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleetfueltypes.name as fleetfueltypeid, assets_fleetodometertypes.name as fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_departments.name as departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
		$join=" left join assets_assets on assets_assets.id=assets_fleets.assetid left join assets_fleetmodels on assets_fleets.fleetmodelid=assets_fleetmodels.id  left join assets_fleettypes on assets_fleets.fleettypeid=assets_fleettypes.id  left join assets_fleetfueltypes on assets_fleets.fleetfueltypeid=assets_fleetfueltypes.id  left join assets_fleetodometertypes on assets_fleets.fleetodometertypeid=assets_fleetodometertypes.id  left join hrm_employees on assets_fleets.employeeid=hrm_employees.id  left join hrm_departments on assets_fleets.departmentid=hrm_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$fleetfueling->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetfueling->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->fleetid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->cost); ?></td>
			<td><?php echo formatDate($row->fueledon); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo formatNumber($row->startodometer); ?></td>
			<td><?php echo formatNumber($row->endodometer); ?></td>
			<td><?php echo $row->destination; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7721";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetfueling_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7722";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetfueling.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
