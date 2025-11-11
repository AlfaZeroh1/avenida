<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Maintenancetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Maintenancetypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8982";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$maintenancetypes=new Maintenancetypes();
if(!empty($delid)){
	$maintenancetypes->id=$delid;
	$maintenancetypes->delete($maintenancetypes);
	redirect("maintenancetypes.php");
}
//Authorization.
$auth->roleid="8981";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addmaintenancetypes_proc.php',600,430);" value="Add Maintenancetypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Maintenance Type </th>
			<th>Duration </th>
			<th>Duration Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8983";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8984";//View
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
		$fields="assets_maintenancetypes.id, assets_maintenancetypes.name, assets_maintenancetypes.duration, assets_maintenancetypes.durationtype, assets_maintenancetypes.remarks, assets_maintenancetypes.ipaddress, assets_maintenancetypes.createdby, assets_maintenancetypes.createdon, assets_maintenancetypes.lasteditedby, assets_maintenancetypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$maintenancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$maintenancetypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo $row->durationtype; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8983";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmaintenancetypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8984";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='maintenancetypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
