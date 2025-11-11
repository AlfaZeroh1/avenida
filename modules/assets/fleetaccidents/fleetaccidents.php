<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetaccidents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetaccidents";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7623";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetaccidents=new Fleetaccidents();
if(!empty($delid)){
	$fleetaccidents->id=$delid;
	$fleetaccidents->delete($fleetaccidents);
	redirect("fleetaccidents.php");
}
//Authorization.
$auth->roleid="7622";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetaccidents_proc.php',600,430);" value="Add Fleetaccidents " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Vehicle </th>
			<th>Description </th>
			<th>Accident Date </th>
			<th>Image </th>
			
<?php
//Authorization.
$auth->roleid="7624";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7625";//View
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
		$fields="assets_fleetaccidents.id, assets_fleetaccidents.fleetid, assets_fleetaccidents.description, assets_fleetaccidents.accidentdate,assets_fleetaccidents.image, assets_fleetaccidents.ipaddress, assets_fleetaccidents.createdby, assets_fleetaccidents.createdon, assets_fleetaccidents.lasteditedby, assets_fleetaccidents.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fleetaccidents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetaccidents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->fleetid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo formatDate($row->accidentdate); ?></td>
			<td><?php echo $row->image; ?></td>
<?php
//Authorization.
$auth->roleid="7624";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetaccidents_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7625";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetaccidents.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
