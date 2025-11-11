<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tendertypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tendertypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7748";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tendertypes=new Tendertypes();
if(!empty($delid)){
	$tendertypes->id=$delid;
	$tendertypes->delete($tendertypes);
	redirect("tendertypes.php");
}
//Authorization.
$auth->roleid="7747";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtendertypes_proc.php',600,430);" value="Add Tendertypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tender Type </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7749";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7750";//View
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
		$fields="tender_tendertypes.id, tender_tendertypes.name, tender_tendertypes.description, tender_tendertypes.remarks, tender_tendertypes.ipaddress, tender_tendertypes.createdby, tender_tendertypes.createdon, tender_tendertypes.lasteditedby, tender_tendertypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$tendertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tendertypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7749";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtendertypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7750";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tendertypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
