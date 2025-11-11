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
$auth->roleid="1116";//View
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
$auth->roleid="1115";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('adddepartments_proc.php',600,300);">ADD DEPARTMENTS</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-striped table-bordered" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Code </th>
			<th>No That Can Be On Leave At The Same Time </th>
			<th>Description </th>
<?php
//Authorization.
$auth->roleid="1117";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1118";//View
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
		$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon";
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
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->leavemembers; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="1117";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddepartments_proc.php?id=<?php echo $row->id; ?>',600,300);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1118";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='departments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div> <!-- contend -->
<?php
include"../../../foot.php";
?>
