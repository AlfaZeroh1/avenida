<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeecontracts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeecontracts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4758";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeecontracts=new Employeecontracts();
if(!empty($delid)){
	$employeecontracts->id=$delid;
	$employeecontracts->delete($employeecontracts);
	redirect("employeecontracts.php");
}
//Authorization.
$auth->roleid="4757";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeecontracts_proc.php',600,430);" value="Add Employeecontracts " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Contract Type </th>
			<th>Start Date </th>
			<th>Confirmation Date </th>
			<th>Probation (Months) </th>
			<th>Contract Period (Months) </th>
			<th>Status </th>
			<th>Remarks </th>
			<th>Employee </th>
<?php
//Authorization.
$auth->roleid="4759";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4760";//Add
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
		$fields="hrm_employeecontracts.id, hrm_contracttypes.name as contracttypeid, hrm_employeecontracts.startdate, hrm_employeecontracts.confirmationdate, hrm_employeecontracts.probation, hrm_employeecontracts.contractperiod, hrm_employeecontracts.status, hrm_employeecontracts.remarks, hrm_employees.name as employeeid, hrm_employeecontracts.createdby, hrm_employeecontracts.createdon, hrm_employeecontracts.lasteditedby, hrm_employeecontracts.lasteditedon";
		$join=" left join hrm_contracttypes on hrm_employeecontracts.contracttypeid=hrm_contracttypes.id  left join hrm_employees on hrm_employeecontracts.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeecontracts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeecontracts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->contracttypeid; ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo formatDate($row->confirmationdate); ?></td>
			<td><?php echo formatNumber($row->probation); ?></td>
			<td><?php echo formatNumber($row->contractperiod); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->employeeid; ?></td>
<?php
//Authorization.
$auth->roleid="4759";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeecontracts_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4760";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeecontracts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
