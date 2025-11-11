<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assignments_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/employees/Employees_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Assignments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1104";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$ob = (object)$_GET;

if(!empty($ob->employeeid)){
  $employees = new Employees();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='$ob->employeeid'";
  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $employees = $employees->fetchObject;
  $employees->assignmentid="";
  
  $emp = new Employees();
  $emp = $emp->setObject($employees);
  $emp->edit($emp);
  
  redirect("assignments.php");
  
}

$delid=$_GET['delid'];
$assignments=new Assignments();
if(!empty($delid)){
	$assignments->id=$delid;
	$assignments->delete($assignments);
	redirect("assignments.php");
}
//Authorization.
$auth->roleid="1103";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<a class="btn btn-info" onclick="showPopWin('addassignments_proc.php',600,430);">Add Assignments</a>
<?php }?>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Name </th>
			<th>Department </th>
			<th>HR Level </th>
			<th>Employee</th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="1105";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1106";//View
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
		$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_departments.name as departmentid, hrm_levels.name as levelid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress";
		$join=" left join hrm_departments on hrm_assignments.departmentid=hrm_departments.id  left join hrm_levels on hrm_assignments.levelid=hrm_levels.id ";
		$having="";
		$groupby="";
		$orderby="";
		$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$assignments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		$employees = new Employees();
		$fields="hrm_employees.id, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where assignmentid='$row->id'";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employees = $employees->fetchObject;
		
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->levelid; ?></td>
			<td><a href="../employees/addemployees_proc.php?id=<?php echo $employees->id; ?>"><?php echo $employees->names; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<?php if(!empty($employees->names)){?>
			<td><a href="assignments.php?employeeid=<?php echo $employees->id; ?>">Relieve</td>
			<?php }else{?>
			<td>&nbsp;</td>
			<?php }?>
<?php
//Authorization.
$auth->roleid="1105";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addassignments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1106";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='assignments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

<hr>
</div>
<!-- contEnd -->
<?php
include"../../../foot.php";
?>
