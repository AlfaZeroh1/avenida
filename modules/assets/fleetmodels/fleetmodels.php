<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetmodels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetmodels";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7639";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetmodels=new Fleetmodels();
if(!empty($delid)){
	$fleetmodels->id=$delid;
	$fleetmodels->delete($fleetmodels);
	redirect("fleetmodels.php");
}
//Authorization.
$auth->roleid="7638";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetmodels_proc.php',600,430);" value="Add Fleetmodels " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Model </th>
			<th>Make </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7640";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7641";//View
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
		$fields="assets_fleetmodels.id, assets_fleetmodels.name, assets_fleetmakes.name as fleetmakeid, assets_fleetmodels.remarks, assets_fleetmodels.ipaddress, assets_fleetmodels.createdby, assets_fleetmodels.createdon, assets_fleetmodels.lasteditedby, assets_fleetmodels.lasteditedon";
		$join=" left join assets_fleetmakes on assets_fleetmodels.fleetmakeid=assets_fleetmakes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$fleetmodels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetmodels->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->fleetmakeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7640";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetmodels_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7641";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetmodels.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
