<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeereliefs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeereliefs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1158";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeereliefs=new Employeereliefs();
if(!empty($delid)){
	$employeereliefs->id=$delid;
	$employeereliefs->delete($employeereliefs);
	redirect("employeereliefs.php");
}
//Authorization.
$auth->roleid="1157";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeereliefs_proc.php',500,380);">ADD EMPLOYEE RELIEFS</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Relief </th>
			<th>Employee </th>
			<th>% </th>
			<th>Premium </th>
			<th>Amount </th>
			<th>Month </th>
			<th>Year </th>
<?php
//Authorization.
$auth->roleid="1159";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1160";//View
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
		$fields="hrm_employeereliefs.id, hrm_employeereliefs.reliefid, hrm_employeereliefs.employeeid, hrm_employeereliefs.percent, hrm_employeereliefs.premium, hrm_employeereliefs.amount, hrm_employeereliefs.month, hrm_employeereliefs.year, hrm_employeereliefs.createdby, hrm_employeereliefs.createdon, hrm_employeereliefs.lasteditedby, hrm_employeereliefs.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employeereliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeereliefs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->reliefid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->percent); ?></td>
			<td><?php echo formatNumber($row->premium); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
<?php
//Authorization.
$auth->roleid="1159";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeereliefs_proc.php?id=<?php echo $row->id; ?>',500,380);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1160";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeereliefs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
