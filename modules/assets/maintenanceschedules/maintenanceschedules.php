<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Maintenanceschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Maintenanceschedules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8978";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$maintenanceschedules=new Maintenanceschedules();
if(!empty($delid)){
	$maintenanceschedules->id=$delid;
	$maintenanceschedules->delete($maintenanceschedules);
	redirect("maintenanceschedules.php");
}
//Authorization.
$auth->roleid="8977";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addmaintenanceschedules_proc.php',600,430);" value="Add Maintenanceschedules " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Maintenance Types </th>
			<th>Asset </th>
			<th>Next Inspection Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8979";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8980";//View
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
		$fields="assets_maintenanceschedules.id, assets_maintenancetypes.name as maintenancetypeid, assets_assets.name as assetid, assets_maintenanceschedules.nextinspection, assets_maintenanceschedules.remarks, assets_maintenanceschedules.ipaddress, assets_maintenanceschedules.createdby, assets_maintenanceschedules.createdon, assets_maintenanceschedules.lasteditedby, assets_maintenanceschedules.lasteditedon";
		$join=" left join assets_maintenancetypes on assets_maintenanceschedules.maintenancetypeid=assets_maintenancetypes.id  left join assets_assets on assets_maintenanceschedules.assetid=assets_assets.id ";
		$having="";
		$groupby="";
		$orderby="";
		$maintenanceschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$maintenanceschedules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->maintenancetypeid; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo formatDate($row->nextinspection); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8979";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmaintenanceschedules_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8980";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='maintenanceschedules.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
