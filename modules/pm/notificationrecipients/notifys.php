<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$db = new DB();

$query = "select pm_notifications.subject, pm_notifications.taskid, pm_notifications.id notificationid, pm_notificationrecipients.id, pm_notificationrecipients.status, pm_notificationrecipients.notifiedon, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeeid from pm_notificationrecipients left join pm_notifications on pm_notifications.id=pm_notificationrecipients.notificationid left join hrm_employees on hrm_employees.id=pm_notificationrecipients.fromemployeeid where status='unread' and employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."') order by pm_notificationrecipients.createdon desc";
$res=mysql_query($query);

$num = mysql_affected_rows();
$desc="";
while($row=mysql_fetch_object($res)){
  mysql_query("update pm_notificationrecipients set status='notified' where id='$row->id'");
     $desc.=$row->subject."<br/>";
}

echo $desc;
?>
