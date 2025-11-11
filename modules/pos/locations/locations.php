<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Locations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Locations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2169";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$locations=new Locations();
if(!empty($delid)){
	$locations->id=$delid;
	$locations->delete($locations);
	redirect("locations.php");
}
//Authorization.
$auth->roleid="2168";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addlocations_proc.php',600,430);" value="Add Locations " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Location </th>
			<th>Description </th>
<?php
//Authorization.
$auth->roleid="2170";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2171";//View
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
		$fields="pos_locations.id, pos_locations.name, pos_locations.description, pos_locations.createdby, pos_locations.createdon, pos_locations.lasteditedby, pos_locations.lasteditedon, pos_locations.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$locations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$locations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="2170";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlocations_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2171";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='locations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
