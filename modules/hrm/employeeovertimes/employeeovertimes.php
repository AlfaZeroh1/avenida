<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeovertimes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeovertimes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9389";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeovertimes=new Employeeovertimes();
if(!empty($delid)){
	$employeeovertimes->id=$delid;
	$employeeovertimes->delete($employeeovertimes);
	redirect("employeeovertimes.php");
}
//Authorization.
$auth->roleid="9388";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeeovertimes_proc.php',600,430);" value="Add Employeeovertimes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Overtime Type </th>
			<th>Hours </th>
			<th>Date From </th>
			<th>To Date </th>
			<th>Month Payable </th>
			<th>Year Payable </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9390";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9391";//Add
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
		$fields="hrm_employeeovertimes.id, hrm_employees.name as employeeid, hrm_overtimes.name as overtimeid, hrm_employeeovertimes.hours, hrm_employeeovertimes.fromdate, hrm_employeeovertimes.todate, hrm_employeeovertimes.month, hrm_employeeovertimes.year, hrm_employeeovertimes.remarks, hrm_employeeovertimes.ipaddress, hrm_employeeovertimes.createdby, hrm_employeeovertimes.createdon, hrm_employeeovertimes.lasteditedby, hrm_employeeovertimes.lasteditedon";
		$join=" left join hrm_employees on hrm_employeeovertimes.employeeid=hrm_employees.id  left join hrm_overtimes on hrm_employeeovertimes.overtimeid=hrm_overtimes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeeovertimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeovertimes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->overtimeid; ?></td>
			<td><?php echo formatNumber($row->hours); ?></td>
			<td><?php echo formatDate($row->fromdate); ?></td>
			<td><?php echo formatDate($row->todate); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9390";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeovertimes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9391";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeeovertimes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
