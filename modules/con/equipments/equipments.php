<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Equipments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Equipments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8444";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$equipments=new Equipments();
if(!empty($delid)){
	$equipments->id=$delid;
	$equipments->delete($equipments);
	redirect("equipments.php");
}
//Authorization.
$auth->roleid="8443";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addequipments_proc.php',600,430);">Add Equipments</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Equipment </th>
			<th>Hire Cost </th>
			<th>Purchase Cost </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8445";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8446";//View
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
		$fields="con_equipments.id, con_equipments.name, con_equipments.hirecost, con_equipments.purchasecost, con_equipments.remarks, con_equipments.ipaddress, con_equipments.createdby, con_equipments.createdon, con_equipments.lasteditedby, con_equipments.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$equipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$equipments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->hirecost); ?></td>
			<td><?php echo formatNumber($row->purchasecost); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8445";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addequipments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8446";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='equipments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
