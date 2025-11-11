<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notificationrecipients_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Notificationrecipients";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8344";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$notificationrecipients=new Notificationrecipients();
if(!empty($delid)){
	$notificationrecipients->id=$delid;
	$notificationrecipients->delete($notificationrecipients);
	redirect("notificationrecipients.php");
}
//Authorization.
$auth->roleid="8343";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick='addnotificationrecipients_proc.php' value="Add Notificationrecipients " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-striped table-bordered" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Notification </th>
			<th>Employee </th>
			<th>Email </th>
			<th>Notified On </th>
			<th>Read On </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8345";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8346";//View
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
		$fields="pm_notificationrecipients.id, pm_notifications.subject as notificationid, concat(hrm_employees.pfnum,' ', concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) as employeeid, pm_notificationrecipients.email, pm_notificationrecipients.notifiedon, pm_notificationrecipients.readon, pm_notificationrecipients.status, pm_notificationrecipients.ipaddress, pm_notificationrecipients.createdby, pm_notificationrecipients.createdon, pm_notificationrecipients.lasteditedby, pm_notificationrecipients.lasteditedon";
		$join=" left join pm_notifications on pm_notificationrecipients.notificationid=pm_notifications.id  left join hrm_employees on pm_notificationrecipients.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$notificationrecipients->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$notificationrecipients->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->notificationid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo formatDate($row->notifiedon); ?></td>
			<td><?php echo formatDate($row->readon); ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8345";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a data-toggle="modal" data-target="#popUp" href='addnotificationrecipients_proc.php?id=<?php echo $row->id; ?>'>View</a></td>
<?php
}
//Authorization.
$auth->roleid="8346";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='notificationrecipients.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
