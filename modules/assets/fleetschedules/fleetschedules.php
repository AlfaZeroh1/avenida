<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetschedules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8476";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetschedules=new Fleetschedules();
if(!empty($delid)){
	$fleetschedules->id=$delid;
	$fleetschedules->delete($fleetschedules);
	redirect("fleetschedules.php");
}
//Authorization.
$auth->roleid="8475";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetschedules_proc.php',600,430);" value="Add Fleetschedules " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Driver </th>
			<th>Project </th>
			<th>Customer </th>
			<th>Source </th>
			<th>Destination </th>
			<th>Departure Time </th>
			<th>Expected Arrival Time </th>
			<th>Actual Arrival Time </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8477";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8478";//Add
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
		$fields="assets_fleetschedules.id, assets_assets.name as assetid,  concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeeid, con_projects.name as projectid, crm_customers.name as customerid, assets_fleetschedules.source, assets_fleetschedules.destination, assets_fleetschedules.departuretime, assets_fleetschedules.expectedarrivaltime, assets_fleetschedules.arrivaltime, assets_fleetschedules.remarks, assets_fleetschedules.ipaddress, assets_fleetschedules.createdby, assets_fleetschedules.createdon, assets_fleetschedules.lasteditedby, assets_fleetschedules.lasteditedon";
		$join=" left join assets_assets on assets_fleetschedules.assetid=assets_assets.id  left join hrm_employees on assets_fleetschedules.employeeid=hrm_employees.id  left join con_projects on assets_fleetschedules.projectid=con_projects.id  left join crm_customers on assets_fleetschedules.customerid=crm_customers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$fleetschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $fleetschedules->sql;echo mysql_error();
		$res=$fleetschedules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->source; ?></td>
			<td><?php echo $row->destination; ?></td>
			<td><?php echo formatDate($row->departuretime); ?></td>
			<td><?php echo formatDate($row->expectedarrivaltime); ?></td>
			<td><?php echo formatDate($row->arrivaltime); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8477";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addfleetschedules_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8478";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetschedules.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
