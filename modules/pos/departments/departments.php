<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Departments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4016";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$departments=new Departments();
if(!empty($delid)){
	$departments->id=$delid;
	$departments->delete($departments);
	redirect("departments.php");
}
//Authorization.
$auth->roleid="4015";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('adddepartments_proc.php',600,430);" value="Add Departments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Department </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4017";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4018";//View
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
		$fields="pos_departments.id, pos_departments.name, pos_departments.remarks, pos_departments.ipaddress, pos_departments.createdby, pos_departments.createdon, pos_departments.lasteditedby, pos_departments.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$departments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4017";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddepartments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4018";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='departments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
