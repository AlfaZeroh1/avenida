<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
$db=new DB();

$obj=(object)$_POST;

require_once('../../../AfricasTalkingGateway.php');
if($obj->action=='Send'){
if(!empty($obj->tel)){
$tel=$obj->tel;
$message1=str_replace("<p>","",$obj->message);
$message2=str_replace("</p>","",$message1);
$message=str_replace("&nbsp;","",$message2);

//add notification			 
$notifications = new Notifications();
$notifications->subject="Custom SMS";//"Requisition Approval #".$obj->documentno;
$notifications->body=$message;//"A Requisition has been raised tht requires your attention";
$notifications->taskid=$tasksDBO->id;
$notifications->notificationtypeid=2;
$notifications->createdby=$_SESSION['userid'];
$notifications->createdon=date("Y-m-d H:i:s");
$notifications->lasteditedby=$_SESSION['userid'];
$notifications->lasteditedon=date("Y-m-d H:i:s");
$notifications->ipaddress=$_SERVER['REMOTE_ADDR'];
$notifications->setObject($notifications);
$notifications->add($notifications);

//add notification recipient
$notificationrecipients = new Notificationrecipients();
$notificationrecipients->id="";
$notificationrecipients->notificationtypeid=2;
$notificationrecipients->notificationid=$notifications->id;

$users = new Users();
$fields="*";
$where=" where id='".$_SESSION['userid']."'";
$having="";
$groupby="";
$orderby="";
$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$users = $users->fetchObject;

$notificationrecipients->fromemployeeid=$users->employeeid;
$notificationrecipients->email="";
$notificationrecipients->body=$message;
$notificationrecipients->tel=$tel;
$notificationrecipients->notifiedon=date("Y-m-d H:i:s");
$notificationrecipients->status="unread";
$notificationrecipients->createdby=$_SESSION['userid'];
$notificationrecipients->createdon=date("Y-m-d H:i:s");
$notificationrecipients->lasteditedby=$_SESSION['userid'];
$notificationrecipients->lasteditedon=date("Y-m-d H:i:s");
$notificationrecipients->ipaddress=$_SERVER['REMOTE_ADDR'];
$notificationrecipients = $notificationrecipients->setObject($notificationrecipients);
$notificationrecipients->add($notificationrecipients);
}
else{
if($obj->person=="tenants"){
$query="select * from em_tenants where statuss='Active'";
$ress=executeQuery($query);
while($res=getObject($ress))
{
$tel=$res->mobile;
$message1=str_replace("<p>","",$obj->message);
$message2=str_replace("</p>","",$message1);
$message=str_replace("&nbsp;","",$message2);

//add notification			 
$notifications = new Notifications();
$notifications->subject="Custom SMS";//"Requisition Approval #".$obj->documentno;
$notifications->body=$message;//"A Requisition has been raised tht requires your attention";
$notifications->taskid=$tasksDBO->id;
$notifications->notificationtypeid=2;
$notifications->createdby=$_SESSION['userid'];
$notifications->createdon=date("Y-m-d H:i:s");
$notifications->lasteditedby=$_SESSION['userid'];
$notifications->lasteditedon=date("Y-m-d H:i:s");
$notifications->ipaddress=$_SERVER['REMOTE_ADDR'];
$notifications->setObject($notifications);
$notifications->add($notifications);

//add notification recipient
$notificationrecipients = new Notificationrecipients();
$notificationrecipients->id="";
$notificationrecipients->notificationtypeid=2;
$notificationrecipients->notificationid=$notifications->id;
$notificationrecipients->tenantid=$res->id;

$users = new Users();
$fields="*";
$where=" where id='".$_SESSION['userid']."'";
$having="";
$groupby="";
$orderby="";
$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$users = $users->fetchObject;

$notificationrecipients->fromemployeeid=$users->employeeid;
$notificationrecipients->email=$obj->email;
$notificationrecipients->body=$message;
$notificationrecipients->tel=$tel;
$notificationrecipients->notifiedon=date("Y-m-d H:i:s");
$notificationrecipients->status="unread";
$notificationrecipients->createdby=$_SESSION['userid'];
$notificationrecipients->createdon=date("Y-m-d H:i:s");
$notificationrecipients->lasteditedby=$_SESSION['userid'];
$notificationrecipients->lasteditedon=date("Y-m-d H:i:s");
$notificationrecipients->ipaddress=$_SERVER['REMOTE_ADDR'];
$notificationrecipients = $notificationrecipients->setObject($notificationrecipients);
$notificationrecipients->add($notificationrecipients);

}
}
elseif($obj->person=="landlords"){
$query="select * from em_landlords";
$ress=executeQuery($query);
while($res=getObject($ress))
{
$tel=$res->tel;
$message1=str_replace("<p>","",$obj->message);
$message2=str_replace("</p>","",$message1);
$message=str_replace("&nbsp;","",$message2);

//add notification			 
$notifications = new Notifications();
$notifications->subject="Custom SMS";//"Requisition Approval #".$obj->documentno;
$notifications->body=$message;//"A Requisition has been raised tht requires your attention";
$notifications->taskid=$tasksDBO->id;
$notifications->notificationtypeid=2;
$notifications->createdby=$_SESSION['userid'];
$notifications->createdon=date("Y-m-d H:i:s");
$notifications->lasteditedby=$_SESSION['userid'];
$notifications->lasteditedon=date("Y-m-d H:i:s");
$notifications->ipaddress=$_SERVER['REMOTE_ADDR'];
$notifications->setObject($notifications);
$notifications->add($notifications);

//add notification recipient
$notificationrecipients = new Notificationrecipients();
$notificationrecipients->id="";
$notificationrecipients->notificationtypeid=2;
$notificationrecipients->notificationid=$notifications->id;
$notificationrecipients->landlordid=$res->id;


$users = new Users();
$fields="*";
$where=" where id='".$_SESSION['userid']."'";
$having="";
$groupby="";
$orderby="";
$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$users = $users->fetchObject;

$notificationrecipients->fromemployeeid=$users->employeeid;
$notificationrecipients->email=$obj->email;
$notificationrecipients->body=$message;
$notificationrecipients->tel=$tel;
$notificationrecipients->notifiedon=date("Y-m-d H:i:s");
$notificationrecipients->status="unread";
$notificationrecipients->createdby=$_SESSION['userid'];
$notificationrecipients->createdon=date("Y-m-d H:i:s");
$notificationrecipients->lasteditedby=$_SESSION['userid'];
$notificationrecipients->lasteditedon=date("Y-m-d H:i:s");
$notificationrecipients->ipaddress=$_SERVER['REMOTE_ADDR'];
$notificationrecipients = $notificationrecipients->setObject($notificationrecipients);
$notificationrecipients->add($notificationrecipients);
}
}
elseif($obj->person=="employees"){
$query="select * from hrm_employees";
$ress=executeQuery($query);
while($res=getObject($ress))
{
$tel=$res->phoneno;
$message1=str_replace("<p>","",$obj->message);
$message2=str_replace("</p>","",$message1);
$message=str_replace("&nbsp;","",$message2);

 //add notification			 
$notifications = new Notifications();
$notifications->subject="Custom SMS";//"Requisition Approval #".$obj->documentno;
$notifications->body=$message;//"A Requisition has been raised tht requires your attention";
$notifications->taskid=$tasksDBO->id;
$notifications->notificationtypeid=2;
$notifications->createdby=$_SESSION['userid'];
$notifications->createdon=date("Y-m-d H:i:s");
$notifications->lasteditedby=$_SESSION['userid'];
$notifications->lasteditedon=date("Y-m-d H:i:s");
$notifications->ipaddress=$_SERVER['REMOTE_ADDR'];
$notifications->setObject($notifications);
$notifications->add($notifications);

//add notification recipient
$notificationrecipients = new Notificationrecipients();
$notificationrecipients->id="";
$notificationrecipients->notificationtypeid=2;
$notificationrecipients->notificationid=$notifications->id;
$notificationrecipients->employeeid=$res->id;


$users = new Users();
$fields="*";
$where=" where id='".$_SESSION['userid']."'";
$having="";
$groupby="";
$orderby="";
$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$users = $users->fetchObject;

$notificationrecipients->fromemployeeid=$users->employeeid;
$notificationrecipients->email=$obj->email;
$notificationrecipients->body=$message;
$notificationrecipients->tel=$tel;
$notificationrecipients->notifiedon=date("Y-m-d H:i:s");
$notificationrecipients->status="unread";
$notificationrecipients->createdby=$_SESSION['userid'];
$notificationrecipients->createdon=date("Y-m-d H:i:s");
$notificationrecipients->lasteditedby=$_SESSION['userid'];
$notificationrecipients->lasteditedon=date("Y-m-d H:i:s");
$notificationrecipients->ipaddress=$_SERVER['REMOTE_ADDR'];
$notificationrecipients = $notificationrecipients->setObject($notificationrecipients);
$notificationrecipients->add($notificationrecipients);
}
}
}
$obj->tel="";
//redirect("customsms.php");
}

$page_title="Custom SMS";
//connect to db
$db=new DB();
//Authorization.
// $auth->roleid="4178";//<img src="../view.png" alt="view" title="view" />
// $auth->levelid=$_SESSION['level'];
// 
// auth($auth);
include"../../../head.php";

//Authorization.
$auth->roleid="4177";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];
?>
<script src="//cdn.ckeditor.com/4.5.4/standard/ckeditor.js"></script>
<form class="forms" action="" name="customsms.php" method="POST" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
<tr>
<td align="center">Send to:<input type="radio" name="person" value="tenants"/>Tenants&nbsp;<input type="radio" name="person" value="landlords"/>Landlords&nbsp;<input type="radio" name="person" value="employees"/>Employees&nbsp;<br/>Tel. No.<input type="text" name="tel" value="<?php echo $obj->tel; ?>"/></td>
</tr>
<tr>
<td align="center">Message:<textarea class="ckeditor" name="message"><?php echo $obj->message; ?></textarea>&nbsp;<input type="submit" class="btn btn-primary" name="action" value="Send"/></td>
</tr>
</table>
</form>
<?php
include"../../../foot.php";
?>
