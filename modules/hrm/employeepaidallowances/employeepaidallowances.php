<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidallowances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepaidallowances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1140";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeepaidallowances=new Employeepaidallowances();
if(!empty($delid)){
	$employeepaidallowances->id=$delid;
	$employeepaidallowances->delete($employeepaidallowances);
	redirect("employeepaidallowances.php");
}
//Authorization.
$auth->roleid="1139";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeepaidallowances_proc.php',600,430);">Add Employeepaidallowances</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Payment </th>
			<th>Allowance </th>
			<th>Employee </th>
			<th>Amount </th>
			<th>Month </th>
			<th>Year </th>
			<th>Payment Date </th>
<?php
//Authorization.
$auth->roleid="1141";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4171";//View
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
		$fields="hrm_employeepaidallowances.id, hrm_employeepayments.name as employeepaymentid, hrm_allowances.name as allowanceid, hrm_employees.name as employeeid, hrm_employeepaidallowances.amount, hrm_employeepaidallowances.month, hrm_employeepaidallowances.year, hrm_employeepaidallowances.paidon, hrm_employeepaidallowances.createdby, hrm_employeepaidallowances.createdon, hrm_employeepaidallowances.lasteditedby, hrm_employeepaidallowances.lasteditedon, hrm_employeepaidallowances.ipaddress";
		$join=" left join hrm_employeepayments on hrm_employeepaidallowances.employeepaymentid=hrm_employeepayments.id  left join hrm_allowances on hrm_employeepaidallowances.allowanceid=hrm_allowances.id  left join hrm_employees on hrm_employeepaidallowances.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeepaidallowances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeepaymentid; ?></td>
			<td><?php echo $row->allowanceid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
<?php
//Authorization.
$auth->roleid="1141";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeepaidallowances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4171";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeepaidallowances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
