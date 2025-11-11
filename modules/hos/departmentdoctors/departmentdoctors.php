<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departmentdoctors_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Departmentdoctors";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8500";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$departmentdoctors=new Departmentdoctors();
if(!empty($delid)){
	$departmentdoctors->id=$delid;
	$departmentdoctors->delete($departmentdoctors);
	redirect("departmentdoctors.php");
}
//Authorization.
$auth->roleid="8499";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddepartmentdoctors_proc.php',600,430);" value="Add Departmentdoctors " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Department </th>
			<th>Employee </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8501";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8502";//Add
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
		$fields="hos_departmentdoctors.id, hos_departments.name as departmentid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hos_departmentdoctors.remarks, hos_departmentdoctors.ipaddress, hos_departmentdoctors.createdby, hos_departmentdoctors.createdon, hos_departmentdoctors.lasteditedby, hos_departmentdoctors.lasteditedon";
		$join=" left join hos_departments on hos_departmentdoctors.departmentid=hos_departments.id  left join hrm_employees on hos_departmentdoctors.employeeid=hrm_employees.id "; 
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$departmentdoctors->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$departmentdoctors->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo initialCap($row->employeeid); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8501";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddepartmentdoctors_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8502";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='departmentdoctors.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
