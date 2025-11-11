<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetservices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetservices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7651";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetservices=new Fleetservices();
if(!empty($delid)){
	$fleetservices->id=$delid;
	$fleetservices->delete($fleetservices);
	redirect("fleetservices.php");
}
//Authorization.
$auth->roleid="7650";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetservices_proc.php',600,430);" value="Add Fleetservices " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Vehicle </th>
			<th>Description </th>
			<th>Supplier </th>
			<th>Cost </th>
			<th>Odometer Reading </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7652";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7653";//View
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
		$fields="assets_fleetservices.id, assets_fleetservices.fleetid, assets_fleetservices.description, assets_fleetservices.supplierid, assets_fleetservices.cost, assets_fleetservices.odometer, assets_fleetservices.remarks, assets_fleetservices.ipaddress, assets_fleetservices.createdby, assets_fleetservices.createdon, assets_fleetservices.lasteditedby, assets_fleetservices.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fleetservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetservices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->fleetid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo formatNumber($row->cost); ?></td>
			<td><?php echo formatNumber($row->odometer); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7652";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetservices_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7653";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetservices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
