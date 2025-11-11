<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Notifications";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7764";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$notifications=new Notifications();
if(!empty($delid)){
	$notifications->id=$delid;
	$notifications->delete($notifications);
	redirect("notifications.php");
}
//Authorization.
$auth->roleid="7763";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addnotifications_proc.php',600,430);" value="Add Notifications " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Notification Type </th>
			<th>Employee </th>
			<th>Email </th>
			<th>Subject </th>
			<th>Body </th>
			<th>Date Notified </th>
<?php
//Authorization.
$auth->roleid="7765";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7766";//View
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
		$fields="sys_notifications.id, sys_notificationtypes.name as notificationtypeid, hrm_employees.name as employeeid, sys_notifications.email, sys_notifications.subject, sys_notifications.body, sys_notifications.notifiedon, sys_notifications.ipaddress, sys_notifications.createdby, sys_notifications.createdon, sys_notifications.lasteditedby, sys_notifications.lasteditedon";
		$join=" left join sys_notificationtypes on sys_notifications.notificationtypeid=sys_notificationtypes.id  left join hrm_employees on sys_notifications.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$notifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$notifications->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->notificationtypeid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->subject; ?></td>
			<td><?php echo $row->body; ?></td>
			<td><?php echo formatDate($row->notifiedon); ?></td>
<?php
//Authorization.
$auth->roleid="7765";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addnotifications_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7766";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='notifications.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
