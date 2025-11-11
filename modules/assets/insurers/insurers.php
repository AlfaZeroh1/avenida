<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Insurers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Insurers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7663";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../hd.php";

$delid=$_GET['delid'];
$insurers=new Insurers();
if(!empty($delid)){
	$insurers->id=$delid;
	$insurers->delete($insurers);
	redirect("insurers.php");
}
//Authorization.
$auth->roleid="7662";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addinsurers_proc.php',600,430);" value="Add Insurers " class="btn"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Insurer </th>
			<th>Physical Address </th>
			<th>Contact Person </th>
			<th>Contact Tel </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7664";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7665";//View
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
		$fields="assets_insurers.id, assets_insurers.name, assets_insurers.physicaladdress, assets_insurers.contactperson, assets_insurers.contacttel, assets_insurers.remarks, assets_insurers.ipaddress, assets_insurers.createdby, assets_insurers.createdon, assets_insurers.lasteditedby, assets_insurers.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$insurers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$insurers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->physicaladdress; ?></td>
			<td><?php echo $row->contactperson; ?></td>
			<td><?php echo $row->contacttel; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7664";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinsurers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7665";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='insurers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
