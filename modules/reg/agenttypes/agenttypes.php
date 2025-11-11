<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agenttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Agenttypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8416";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$agenttypes=new Agenttypes();
if(!empty($delid)){
	$agenttypes->id=$delid;
	$agenttypes->delete($agenttypes);
	redirect("agenttypes.php");
}
//Authorization.
$auth->roleid="8415";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addagenttypes_proc.php',600,430);" value="Add Agenttypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Agent Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8417";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8418";//View
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
		$fields="reg_agenttypes.id, reg_agenttypes.name, reg_agenttypes.remarks, reg_agenttypes.ipaddress, reg_agenttypes.createdby, reg_agenttypes.createdon, reg_agenttypes.lasteditedby, reg_agenttypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$agenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$agenttypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8417";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addagenttypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8418";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='agenttypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
