<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4262";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeepayments=new Employeepayments();
if(!empty($delid)){
	$employeepayments->id=$delid;
	$employeepayments->delete($employeepayments);
	redirect("employeepayments.php");
}
//Authorization.
$auth->roleid="4261";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeepayments_proc.php',600,430);" value="Add Employeepayments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Assignment </th>
			<th> </th>
			<th>Paying Bank </th>
			<th>Bank (if Paid Via Bank) </th>
			<th>Bank Branch </th>
			<th>Bank Account </th>
			<th>Clearing Code </th>
			<th>Reference </th>
			<th>Month </th>
			<th>Year </th>
			<th>Basic </th>
			<th>Total Allowances </th>
			<th>Total Deductions </th>
			<th>Net Pay </th>
			<th>Paid On </th>
<?php
//Authorization.
$auth->roleid="4263";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4264";//View
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
		$fields="hrm_employeepayments.id, hrm_employees.name as employeeid, hrm_assignments.name as assignmentid, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, hrm_employeebanks.name as employeebankid, hrm_bankbranches.name as bankbrancheid, hrm_employeepayments.bankacc, hrm_employeepayments.clearingcode, hrm_employeepayments.ref, hrm_employeepayments.month, hrm_employeepayments.year, hrm_employeepayments.basic, hrm_employeepayments.allowances, hrm_employeepayments.deductions, hrm_employeepayments.netpay, hrm_employeepayments.paidon, hrm_employeepayments.ipaddress, hrm_employeepayments.createdby, hrm_employeepayments.createdon, hrm_employeepayments.lasteditedby, hrm_employeepayments.lasteditedon";
		$join=" left join hrm_employees on hrm_employeepayments.employeeid=hrm_employees.id  left join hrm_assignments on hrm_employeepayments.assignmentid=hrm_assignments.id  left join sys_paymentmodes on hrm_employeepayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on hrm_employeepayments.bankid=fn_banks.id  left join hrm_employeebanks on hrm_employeepayments.employeebankid=hrm_employeebanks.id  left join hrm_bankbranches on hrm_employeepayments.bankbrancheid=hrm_bankbranches.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeepayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->employeebankid; ?></td>
			<td><?php echo $row->bankbrancheid; ?></td>
			<td><?php echo $row->bankacc; ?></td>
			<td><?php echo $row->clearingcode; ?></td>
			<td><?php echo $row->ref; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatNumber($row->basic); ?></td>
			<td><?php echo formatNumber($row->allowances); ?></td>
			<td><?php echo formatNumber($row->deductions); ?></td>
			<td><?php echo formatNumber($row->netpay); ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
<?php
//Authorization.
$auth->roleid="4263";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeepayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4264";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeepayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
