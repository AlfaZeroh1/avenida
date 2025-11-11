<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deductiontypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Deductiontypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1112";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$deductiontypes=new Deductiontypes();
if(!empty($delid)){
	$deductiontypes->id=$delid;
	$deductiontypes->delete($deductiontypes);
	redirect("deductiontypes.php");
}
//Authorization.
$auth->roleid="1111";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('adddeductiontypes_proc.php',600,430);">Add Deductiontypes</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Repeat After (Months) </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1113";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1114";//View
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
		$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$deductiontypes->result;
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
$auth->roleid="1113";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddeductiontypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1114";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='deductiontypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
