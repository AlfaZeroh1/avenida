<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeebanks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeebanks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1128";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeebanks=new Employeebanks();
if(!empty($delid)){
	$employeebanks->id=$delid;
	$employeebanks->delete($employeebanks);
	redirect("employeebanks.php");
}
//Authorization.
$auth->roleid="1127";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeebanks_proc.php',600,430);">Add Employeebanks </a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1129";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1130";//View
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
		$fields="hrm_employeebanks.id, hrm_employeebanks.code, hrm_employeebanks.name, hrm_employeebanks.remarks, hrm_employeebanks.createdby, hrm_employeebanks.createdon, hrm_employeebanks.lasteditedby, hrm_employeebanks.lasteditedon, hrm_employeebanks.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employeebanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeebanks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="1129";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeebanks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1130";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeebanks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
