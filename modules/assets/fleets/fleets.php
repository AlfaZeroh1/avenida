<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7647";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleets=new Fleets();
if(!empty($delid)){
	$fleets->id=$delid;
	$fleets->delete($fleets);
	redirect("fleets.php");
}
//Authorization.
$auth->roleid="7646";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<a class="btn btn-info" href='addfleets_proc.php'>New Fleets</a>
<?php }?>
<div style="clear:both;"></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Fleet </th>
			<th>Model </th>
			<th>Year </th>
			<th>Color </th>
			<th>Vehicle Identification Number </th>
			<th>Vehicle Type </th>
			<th>Plate No </th>
			<th>Engine </th>
			<th>Fuel Type </th>
			<th>Odometer Type </th>
			<th>Service Mileage </th>
			<th>Last Service Mileage </th>
			<th>Allocated To </th>
			<th>HR Department </th>
<?php
//Authorization.
$auth->roleid="7648";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7649";//View
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
		$fields="assets_fleets.id, assets_fleets.assetid, assets_fleetmodels.name as fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleettypes.name as fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleetfueltypes.name as fleetfueltypeid, assets_fleetodometertypes.name as fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_departments.name as departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
		$join=" left join assets_fleetmodels on assets_fleets.fleetmodelid=assets_fleetmodels.id  left join assets_fleettypes on assets_fleets.fleettypeid=assets_fleettypes.id  left join assets_fleetfueltypes on assets_fleets.fleetfueltypeid=assets_fleetfueltypes.id  left join assets_fleetodometertypes on assets_fleets.fleetodometertypeid=assets_fleetodometertypes.id  left join hrm_employees on assets_fleets.employeeid=hrm_employees.id  left join hrm_departments on assets_fleets.departmentid=hrm_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->fleetmodelid; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->fleetcolorid; ?></td>
			<td><?php echo $row->vin; ?></td>
			<td><?php echo $row->fleettypeid; ?></td>
			<td><?php echo $row->plateno; ?></td>
			<td><?php echo $row->engine; ?></td>
			<td><?php echo $row->fleetfueltypeid; ?></td>
			<td><?php echo $row->fleetodometertypeid; ?></td>
			<td><?php echo formatNumber($row->mileage); ?></td>
			<td><?php echo formatNumber($row->lastservicemileage); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
<?php
//Authorization.
$auth->roleid="7648";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addfleets_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7649";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleets.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
</div>
<?php
include"../../../foot.php";
?>
