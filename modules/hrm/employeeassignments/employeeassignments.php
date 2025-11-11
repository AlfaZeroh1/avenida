<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeassignments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeassignments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1124";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeassignments=new Employeeassignments();
if(!empty($delid)){
	$employeeassignments->id=$delid;
	$employeeassignments->delete($employeeassignments);
	redirect("employeeassignments.php");
}
//Authorization.
$auth->roleid="1123";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addemployeeassignments_proc.php',540,280);"><span>ADD EMPLOYEE ASSIGNMENTS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Assignment </th>
			<th>Date Assigned </th>
			<th>Date Moved </th>
<?php
//Authorization.
$auth->roleid="1125";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1126";//View
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
		$fields="hrm_employeeassignments.id, hrm_employeeassignments.employeeid, hrm_employeeassignments.assignmentid, hrm_employeeassignments.fromdate, hrm_employeeassignments.todate, hrm_employeeassignments.createdby, hrm_employeeassignments.createdon, hrm_employeeassignments.lasteditedby, hrm_employeeassignments.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employeeassignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeassignments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo formatDate($row->fromdate); ?></td>
			<td><?php echo formatDate($row->todate); ?></td>
<?php
//Authorization.
$auth->roleid="1125";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeassignments_proc.php?id=<?php echo $row->id; ?>',520,280);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1126";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeeassignments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
