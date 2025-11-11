<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeequalifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeequalifications";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4198";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeequalifications=new Employeequalifications();
if(!empty($delid)){
	$employeequalifications->id=$delid;
	$employeequalifications->delete($employeequalifications);
	redirect("employeequalifications.php");
}
//Authorization.
$auth->roleid="4197";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeequalifications_proc.php',600,430);" value="Add Employeequalifications " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Qualification </th>
			<th>Title </th>
			<th>Institution </th>
			<th>Grade </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4199";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4200";//View
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
		$fields="hrm_employeequalifications.id, hrm_employees.name as employeeid, hrm_qualifications.name as qualificationid, hrm_employeequalifications.title, hrm_employeequalifications.institution, hrm_gradings.name as gradingid, hrm_employeequalifications.remarks, hrm_employeequalifications.createdby, hrm_employeequalifications.createdon, hrm_employeequalifications.lasteditedby, hrm_employeequalifications.lasteditedon";
		$join=" left join hrm_employees on hrm_employeequalifications.employeeid=hrm_employees.id  left join hrm_qualifications on hrm_employeequalifications.qualificationid=hrm_qualifications.id  left join hrm_gradings on hrm_employeequalifications.gradingid=hrm_gradings.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeequalifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeequalifications->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->qualificationid; ?></td>
			<td><?php echo $row->title; ?></td>
			<td><?php echo $row->institution; ?></td>
			<td><?php echo $row->gradingid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4199";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeequalifications_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4200";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeequalifications.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
