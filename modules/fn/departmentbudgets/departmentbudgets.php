<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departmentbudgets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Departmentbudgets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8400";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$departmentbudgets=new Departmentbudgets();
if(!empty($delid)){
	$departmentbudgets->id=$delid;
	$departmentbudgets->delete($departmentbudgets);
	redirect("departmentbudgets.php");
}
//Authorization.
$auth->roleid="8399";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddepartmentbudgets_proc.php',600,430);" value="Add Departmentbudgets " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Department </th>
			<th>From Month </th>
			<th>From Year </th>
			<th>To Month </th>
			<th>To Year </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8401";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8402";//View
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
		$fields="fn_departmentbudgets.id, hrm_departments.name as departmentid, con_projects.name as projectid, fn_departmentbudgets.frommonth, fn_departmentbudgets.fromyear, fn_departmentbudgets.tomonth, fn_departmentbudgets.toyear, fn_departmentbudgets.amount, fn_departmentbudgets.remarks, fn_departmentbudgets.ipaddress, fn_departmentbudgets.createdby, fn_departmentbudgets.createdon, fn_departmentbudgets.lasteditedby, fn_departmentbudgets.lasteditedon";
		$join=" left join hrm_departments on fn_departmentbudgets.departmentid=hrm_departments.id  left join con_projects on fn_departmentbudgets.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$departmentbudgets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$departmentbudgets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->frommonth; ?></td>
			<td><?php echo $row->fromyear; ?></td>
			<td><?php echo $row->tomonth; ?></td>
			<td><?php echo $row->toyear; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8401";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddepartmentbudgets_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8402";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='departmentbudgets.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
