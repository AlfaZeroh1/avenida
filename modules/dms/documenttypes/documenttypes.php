<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documenttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Documenttypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7567";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

if(!empty($ob->id))
  $where=" where moduleid='$ob->id' ";

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$documenttypes=new Documenttypes();
if(!empty($delid)){
	$documenttypes->id=$delid;
	$documenttypes->delete($documenttypes);
	redirect("documenttypes.php");
}
//Authorization.
$auth->roleid="7566";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddocumenttypes_proc.php',600,430);" value="Add Documenttypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document Type </th>
			<th> </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7568";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7569";//View
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
		$fields="dms_documenttypes.id, dms_documenttypes.name, sys_modules.name as moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
		$join=" left join sys_modules on dms_documenttypes.moduleid=sys_modules.id ";
		$having="";
		$groupby="";
		$orderby="";
		$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$documenttypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->moduleid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7568";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocumenttypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7569";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='documenttypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
