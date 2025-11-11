<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Disciplinarytypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Disciplinarytypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4823";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$disciplinarytypes=new Disciplinarytypes();
if(!empty($delid)){
	$disciplinarytypes->id=$delid;
	$disciplinarytypes->delete($disciplinarytypes);
	redirect("disciplinarytypes.php");
}
//Authorization.
$auth->roleid="4822";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('adddisciplinarytypes_proc.php',600,430);">Add Disciplinarytypes</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Displinary Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4824";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4825";//Add
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
		$fields="hrm_disciplinarytypes.id, hrm_disciplinarytypes.name, hrm_disciplinarytypes.remarks, hrm_disciplinarytypes.createdby, hrm_disciplinarytypes.createdon, hrm_disciplinarytypes.lasteditedby, hrm_disciplinarytypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$disciplinarytypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$disciplinarytypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4824";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddisciplinarytypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4825";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='disciplinarytypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
