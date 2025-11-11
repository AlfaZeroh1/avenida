<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetfueltypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetfueltypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7631";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetfueltypes=new Fleetfueltypes();
if(!empty($delid)){
	$fleetfueltypes->id=$delid;
	$fleetfueltypes->delete($fleetfueltypes);
	redirect("fleetfueltypes.php");
}
//Authorization.
$auth->roleid="7630";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetfueltypes_proc.php',600,430);" value="Add Fleetfueltypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Fuel Types </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7632";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7633";//View
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
		$fields="assets_fleetfueltypes.id, assets_fleetfueltypes.name, assets_fleetfueltypes.remarks, assets_fleetfueltypes.ipaddress, assets_fleetfueltypes.createdby, assets_fleetfueltypes.createdon, assets_fleetfueltypes.lasteditedby, assets_fleetfueltypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fleetfueltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetfueltypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7632";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetfueltypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7633";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetfueltypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
