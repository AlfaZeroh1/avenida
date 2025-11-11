<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankbranches_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bankbranches";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4815";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$bankbranches=new Bankbranches();
if(!empty($delid)){
	$bankbranches->id=$delid;
	$bankbranches->delete($bankbranches);
	redirect("bankbranches.php");
}
//Authorization.
$auth->roleid="4814";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addbankbranches_proc.php',600,430);">Add Bankbranches</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-striped table-bordered" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Bank Branch </th>
			<th>Clearing Code</th>
			<th>Bank </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4816";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4817";//View
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
		$fields="hrm_bankbranches.id, hrm_bankbranches.name, hrm_employeebanks.name as employeebankid, hrm_bankbranches.remarks, hrm_bankbranches.createdby, hrm_bankbranches.createdon, hrm_bankbranches.code, hrm_bankbranches.lasteditedby, hrm_bankbranches.lasteditedon, hrm_bankbranches.ipaddress";
		$join=" left join hrm_employeebanks on hrm_bankbranches.employeebankid=hrm_employeebanks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$bankbranches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$bankbranches->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->employeebankid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4816";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbankbranches_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4817";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='bankbranches.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
