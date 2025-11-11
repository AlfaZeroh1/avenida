<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Schedulers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Schedulers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1186";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$schedulers=new Schedulers();
if(!empty($delid)){
	$schedulers->id=$delid;
	$schedulers->delete($schedulers);
	redirect("schedulers.php");
}
//Authorization.
$auth->roleid="1185";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addschedulers_proc.php',600,340);"><span>ADD SCHEDULERS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Assignment </th>
			<th>Schedule Date </th>
			<th>Remarks </th>
			<th>Created By </th>
<?php
//Authorization.
$auth->roleid="1187";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1188";//View
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
		$fields="hrm_schedulers.id, hrm_schedulers.employeeid, hrm_schedulers.assignmentid, hrm_schedulers.scheduledate, hrm_schedulers.remarks, hrm_schedulers.createby, hrm_schedulers.createdon, hrm_schedulers.lasteditedby, hrm_schedulers.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$schedulers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$schedulers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo formatDate($row->scheduledate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->createby; ?></td>
<?php
//Authorization.
$auth->roleid="1187";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addschedulers_proc.php?id=<?php echo $row->id; ?>',600,340);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1188";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='schedulers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
