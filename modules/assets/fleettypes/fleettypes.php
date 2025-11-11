<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleettypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fleettypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7655";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fleettypes=new Fleettypes();
if(!empty($delid)){
	$fleettypes->id=$delid;
	$fleettypes->delete($fleettypes);
	redirect("fleettypes.php");
}
//Authorization.
$auth->roleid="7654";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfleettypes_proc.php',600,430);" value="Add Fleettypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Fleet Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7656";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7657";//View
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
		$fields="assets_fleettypes.id, assets_fleettypes.name, assets_fleettypes.remarks, assets_fleettypes.ipaddress, assets_fleettypes.createdby, assets_fleettypes.createdon, assets_fleettypes.lasteditedby, assets_fleettypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fleettypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fleettypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7656";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfleettypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7657";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fleettypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
