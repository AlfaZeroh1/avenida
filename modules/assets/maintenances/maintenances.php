<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Maintenances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Maintenances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8974";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$maintenances=new Maintenances();
if(!empty($delid)){
	$maintenances->id=$delid;
	$maintenances->delete($maintenances);
	redirect("maintenances.php");
}
//Authorization.
$auth->roleid="8973";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addmaintenances_proc.php',600,430);" value="Add Maintenances " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Maintenance Types </th>
			<th>Asset </th>
			<th>Maintenance Date </th>
			<th>Maintenance Done By </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8975";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8976";//View
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
		$fields="assets_maintenances.id, assets_maintenancetypes.name as maintenancetypeid, assets_assets.name as assetid, assets_maintenances.maintainedon, assets_maintenances.doneby, assets_maintenances.remarks, assets_maintenances.ipaddress, assets_maintenances.createdby, assets_maintenances.createdon, assets_maintenances.lasteditedby, assets_maintenances.lasteditedon";
		$join=" left join assets_maintenancetypes on assets_maintenances.maintenancetypeid=assets_maintenancetypes.id  left join assets_assets on assets_maintenances.assetid=assets_assets.id ";
		$having="";
		$groupby="";
		$orderby="";
		$maintenances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$maintenances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->maintenancetypeid; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo formatDate($row->maintainedon); ?></td>
			<td><?php echo $row->doneby; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8975";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmaintenances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8976";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='maintenances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
