<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Servicetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Servicetypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7716";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$servicetypes=new Servicetypes();
if(!empty($delid)){
	$servicetypes->id=$delid;
	$servicetypes->delete($servicetypes);
	redirect("servicetypes.php");
}
//Authorization.
$auth->roleid="7715";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addservicetypes_proc.php',600,430);" value="Add Servicetypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Service Type </th>
			<th>Duration </th>
			<th>Duration Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7717";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7718";//View
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
		$fields="assets_servicetypes.id, assets_servicetypes.name, assets_servicetypes.duration, assets_servicetypes.durationtype, assets_servicetypes.remarks, assets_servicetypes.ipaddress, assets_servicetypes.createdby, assets_servicetypes.createdon, assets_servicetypes.lasteditedby, assets_servicetypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$servicetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$servicetypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->duration); ?></td>
			<td><?php echo $row->durationtype; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7717";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addservicetypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7718";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='servicetypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
