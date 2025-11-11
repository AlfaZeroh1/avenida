<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Surchagetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Surchagetypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4811";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$surchagetypes=new Surchagetypes();
if(!empty($delid)){
	$surchagetypes->id=$delid;
	$surchagetypes->delete($surchagetypes);
	redirect("surchagetypes.php");
}
//Authorization.
$auth->roleid="4810";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addsurchagetypes_proc.php',600,430);">Add Surchagetypes </a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Surcharge Type </th>
			<th>Repeat After </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4812";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4813";//Add
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
		$fields="hrm_surchagetypes.id, hrm_surchagetypes.name, hrm_surchagetypes.repeatafter, hrm_surchagetypes.remarks, hrm_surchagetypes.createdby, hrm_surchagetypes.createdon, hrm_surchagetypes.lasteditedby, hrm_surchagetypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$surchagetypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->repeatafter; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4812";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsurchagetypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4813";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='surchagetypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
