<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assetconsumables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Assetconsumables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9400";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$assetconsumables=new Assetconsumables();
if(!empty($delid)){
	$assetconsumables->id=$delid;
	$assetconsumables->delete($assetconsumables);
	redirect("assetconsumables.php");
}
//Authorization.
$auth->roleid="9399";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addassetconsumables_proc.php',600,430);" value="Add Assetconsumables " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Consumable </th>
			<th>Serial No </th>
			<th>Date </th>
			<th>Start Mileage </th>
			<th>Current Mileage </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9401";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9402";//Add
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
		$fields="assets_assetconsumables.id, assets_assets.name as assetid, assets_consumables.name as consumableid, assets_assetconsumables.serialno, assets_assetconsumables.fittedon, assets_assetconsumables.startmileage, assets_assetconsumables.currentmileage, assets_assetconsumables.remarks, assets_assetconsumables.ipaddress, assets_assetconsumables.createdby, assets_assetconsumables.createdon, assets_assetconsumables.lasteditedby, assets_assetconsumables.lasteditedon";
		$join=" left join assets_assets on assets_assetconsumables.assetid=assets_assets.id  left join assets_consumables on assets_assetconsumables.consumableid=assets_consumables.id ";
		$having="";
		$groupby="";
		$orderby="";
		$assetconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$assetconsumables->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->consumableid; ?></td>
			<td><?php echo $row->serialno; ?></td>
			<td><?php echo formatDate($row->fittedon); ?></td>
			<td><?php echo formatNumber($row->startmileage); ?></td>
			<td><?php echo formatNumber($row->currentmileage); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9401";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addassetconsumables_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9402";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='assetconsumables.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
