<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetservicedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleetservicedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8966";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleetservicedetails=new Fleetservicedetails();
if(!empty($delid)){
	$fleetservicedetails->id=$delid;
	$fleetservicedetails->delete($fleetservicedetails);
	redirect("fleetservicedetails.php");
}
//Authorization.
$auth->roleid="8965";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleetservicedetails_proc.php',600,430);" value="Add Fleetservicedetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Fleet Service </th>
			<th>Service Item </th>
			<th>Replaced </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8967";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8968";//Add
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
		$fields="assets_fleetservicedetails.id, assets_fleetservices.name as fleetserviceid, assets_fleetserviceitems.name as fleetserviceitemid, assets_fleetservicedetails.replaced, assets_fleetservicedetails.remarks, assets_fleetservicedetails.ipaddress, assets_fleetservicedetails.createdby, assets_fleetservicedetails.createdon, assets_fleetservicedetails.lasteditedby, assets_fleetservicedetails.lasteditedon";
		$join=" left join assets_fleetservices on assets_fleetservicedetails.fleetserviceid=assets_fleetservices.id  left join assets_fleetserviceitems on assets_fleetservicedetails.fleetserviceitemid=assets_fleetserviceitems.id ";
		$having="";
		$groupby="";
		$orderby="";
		$fleetservicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleetservicedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->fleetserviceid; ?></td>
			<td><?php echo $row->fleetserviceitemid; ?></td>
			<td><?php echo $row->replaced; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8967";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleetservicedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8968";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleetservicedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
