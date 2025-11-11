<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employees";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8846";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employees=new Employees();
if(!empty($delid)){
	$employees->id=$delid;
	$employees->delete($employees);
	redirect("employees.php");
}
//Authorization.
$auth->roleid="8845";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployees_proc.php',600,430);" value="Add Employees " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Employee </th>
			<th>Date From </th>
			<th>To Date </th>
			<th>Reason </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8847";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8848";//Add
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
		$fields="assets_employees.id, assets_assets.name as assetid, hrm_employees.name as employeeid, assets_employees.datefrom, assets_employees.todate, assets_employees.reason, assets_employees.remarks, assets_employees.ipaddress, assets_employees.createdby, assets_employees.createdon, assets_employees.lasteditedby, assets_employees.lasteditedon";
		$join=" left join assets_assets on assets_employees.assetid=assets_assets.id  left join hrm_employees on assets_employees.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->datefrom); ?></td>
			<td><?php echo formatDate($row->todate); ?></td>
			<td><?php echo $row->reason; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8847";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployees_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8848";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employees.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
