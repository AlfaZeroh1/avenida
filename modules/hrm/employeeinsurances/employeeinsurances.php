<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeinsurances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeinsurances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4226";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeinsurances=new Employeeinsurances();
if(!empty($delid)){
	$employeeinsurances->id=$delid;
	$employeeinsurances->delete($employeeinsurances);
	redirect("employeeinsurances.php");
}
//Authorization.
$auth->roleid="4225";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeeinsurances_proc.php',600,430);" value="Add Employeeinsurances " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Insurance </th>
			<th>Premium Paid </th>
			<th>Start Date </th>
			<th>Expected End Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4227";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4228";//View
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
		$fields="hrm_employeeinsurances.id, hrm_employeeinsurances.employeeid, hrm_insurances.name as insuranceid, hrm_employeeinsurances.premium, hrm_employeeinsurances.startdate, hrm_employeeinsurances.expectedenddate, hrm_employeeinsurances.remarks, hrm_employeeinsurances.createdby, hrm_employeeinsurances.createdon, hrm_employeeinsurances.lasteditedby, hrm_employeeinsurances.lasteditedon";
		$join=" left join hrm_insurances on hrm_employeeinsurances.insuranceid=hrm_insurances.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeeinsurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeinsurances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->insuranceid; ?></td>
			<td><?php echo formatNumber($row->premium); ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo formatDate($row->expectedenddate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4227";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeinsurances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4228";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeeinsurances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
