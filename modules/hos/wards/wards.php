<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Wards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Wards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1312";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$wards=new Wards();
if(!empty($delid)){
	$wards->id=$delid;
	$wards->delete($wards);
	redirect("wards.php");
}
//Authorization.
$auth->roleid="1311";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addwards_proc.php',600,430);" value="Add Wards " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Department </th>
			<th>Remarks </th>
			<th>Room Number Of The First Room </th>
			<th>Room Number Of The Last Room </th>
			<th>Room Prefix </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="1313";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1314";//View
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
		$fields="hos_wards.id, hos_wards.name, hos_departments.name as departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
		$join=" left join hos_departments on hos_wards.departmentid=hos_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$wards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->firstroom; ?></td>
			<td><?php echo $row->lastroom; ?></td>
			<td><?php echo $row->roomprefix; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="1313";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addwards_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1314";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='wards.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
