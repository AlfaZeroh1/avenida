<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidsurchages_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepaidsurchages";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1154";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeepaidsurchages=new Employeepaidsurchages();
if(!empty($delid)){
	$employeepaidsurchages->id=$delid;
	$employeepaidsurchages->delete($employeepaidsurchages);
	redirect("employeepaidsurchages.php");
}
//Authorization.
$auth->roleid="1153";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat"  onclick="showPopWin('addemployeepaidsurchages_proc.php',500,310);"><span>ADD EMPLOYEE PAID SURCHARGES</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Surcharge </th>
			<th>Employee </th>
			<th>Amount </th>
			<th>Month </th>
			<th>Year </th>
<?php
//Authorization.
$auth->roleid="1155";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1156";//View
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
		$fields="hrm_employeepaidsurchages.id, hrm_employeepaidsurchages.empsurchageid, hrm_employeepaidsurchages.employeeid, hrm_employeepaidsurchages.amount, hrm_employeepaidsurchages.month, hrm_employeepaidsurchages.year, hrm_employeepaidsurchages.createdby, hrm_employeepaidsurchages.createdon, hrm_employeepaidsurchages.lasteditedby, hrm_employeepaidsurchages.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employeepaidsurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeepaidsurchages->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->empsurchageid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
<?php
//Authorization.
$auth->roleid="1155";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeepaidsurchages_proc.php?id=<?php echo $row->id; ?>',500,310);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1156";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeepaidsurchages.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
