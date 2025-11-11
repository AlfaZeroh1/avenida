<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectequipments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectequipments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8448";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectequipments=new Projectequipments();
if(!empty($delid)){
	$projectequipments->id=$delid;
	$projectequipments->delete($projectequipments);
	redirect("projectequipments.php");
}
//Authorization.
$auth->roleid="8447";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectequipments_proc.php',600,430);" value="Add Projectequipments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Equipment </th>
			<th>Work Schedule </th>
			<th>Project Week </th>
			<th>Calendar Week </th>
			<th>Month </th>
			<th>Year </th>
			<th>Equipment Type </th>
			<th>Rate </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8449";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8450";//View
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
		$fields="con_projectequipments.id, con_equipments.name as equipmentid, con_projectworkschedules.name as projectworkscheduleid, con_projectequipments.projectweek, con_projectequipments.week, con_projectequipments.month, con_projectequipments.year, con_projectequipments.type, con_projectequipments.rate, con_projectequipments.remarks, con_projectequipments.ipaddress, con_projectequipments.createdby, con_projectequipments.createdon, con_projectequipments.lasteditedby, con_projectequipments.lasteditedon";
		$join=" left join con_equipments on con_projectequipments.equipmentid=con_equipments.id  left join con_projectworkschedules on con_projectequipments.projectworkscheduleid=con_projectworkschedules.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectequipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectequipments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->equipmentid; ?></td>
			<td><?php echo $row->projectworkscheduleid; ?></td>
			<td><?php echo $row->projectweek; ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8449";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectequipments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8450";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectequipments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
