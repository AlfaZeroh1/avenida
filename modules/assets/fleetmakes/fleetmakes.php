<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetmakes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetmakes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7635";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetmakes=new Fleetmakes();
if(!empty($delid)){
	$fleetmakes->id=$delid;
	$fleetmakes->delete($fleetmakes);
	redirect("fleetmakes.php");
}
//Authorization.
$auth->roleid="7634";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetmakes_proc.php',600,430);" value="Add Fleetmakes " class="btn"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Make </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7636";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7637";//View
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
		$fields="assets_fleetmakes.id, assets_fleetmakes.name, assets_fleetmakes.remarks, assets_fleetmakes.ipaddress, assets_fleetmakes.createdby, assets_fleetmakes.createdon, assets_fleetmakes.lasteditedby, assets_fleetmakes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fleetmakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetmakes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7636";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetmakes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7637";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetmakes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
