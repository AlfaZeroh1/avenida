<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rejecttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Rejecttypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8596";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$rejecttypes=new Rejecttypes();
if(!empty($delid)){
	$rejecttypes->id=$delid;
	$rejecttypes->delete($rejecttypes);
	redirect("rejecttypes.php");
}
//Authorization.
$auth->roleid="8595";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-danger" onclick="showPopWin('addrejecttypes_proc.php',600,430);" value="Add Rejecttypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Reject Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8597";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8598";//View
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
		$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$rejecttypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8597";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addrejecttypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8598";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='rejecttypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
