<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Contracttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Contracttypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4182";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$contracttypes=new Contracttypes();
if(!empty($delid)){
	$contracttypes->id=$delid;
	$contracttypes->delete($contracttypes);
	redirect("contracttypes.php");
}
//Authorization.
$auth->roleid="4181";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">

<a class="btn btn-info" onclick="showPopWin('addcontracttypes_proc.php',600,430);">Add Contracttypes</a>
<?php }?>

<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Contract Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4183";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4184";//View
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
		$fields="hrm_contracttypes.id, hrm_contracttypes.name, hrm_contracttypes.remarks, hrm_contracttypes.createdby, hrm_contracttypes.createdon, hrm_contracttypes.lasteditedby, hrm_contracttypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$contracttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$contracttypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4183";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcontracttypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4184";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='contracttypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

</div><!-- contend -->
<?php
include"../../../foot.php";
?>
