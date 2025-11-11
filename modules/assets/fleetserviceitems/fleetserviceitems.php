<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetserviceitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetserviceitems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8970";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetserviceitems=new Fleetserviceitems();
if(!empty($delid)){
	$fleetserviceitems->id=$delid;
	$fleetserviceitems->delete($fleetserviceitems);
	redirect("fleetserviceitems.php");
}
//Authorization.
$auth->roleid="8969";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetserviceitems_proc.php',600,430);" value="Add Fleetserviceitems " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Service Item </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8971";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8972";//Add
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
		$fields="assets_fleetserviceitems.id, assets_fleetserviceitems.name, assets_fleetserviceitems.remarks, assets_fleetserviceitems.ipaddress, assets_fleetserviceitems.createdby, assets_fleetserviceitems.createdon, assets_fleetserviceitems.lasteditedby, assets_fleetserviceitems.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fleetserviceitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetserviceitems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8971";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetserviceitems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8972";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetserviceitems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
