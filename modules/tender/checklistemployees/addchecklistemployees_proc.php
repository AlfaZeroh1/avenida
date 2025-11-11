<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklistemployees_class.php");
require_once("../../auth/rules/Rules_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../tender/checklists/Checklists_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../pm/tasks/Tasks_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7733";//Edit
}
else{
	$auth->roleid="7731";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
if(!empty($ob->tenderid)){
	$obj=$ob;
}
	
if($obj->action=="Save"){
	$checklistemployees=new Checklistemployees();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$checklistemployees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklistemployees=$checklistemployees->setObject($obj);
		if($checklistemployees->add($checklistemployees)){
			$error=SUCCESS;
			
			//make a notification
			$notifications = new Notifications();
			$not->notificationtypeid=1;
			$not->employeeid=$obj->employeeid;
			$employees = new Employees();
			$fields="*";
			$where=" where id='$obj->employeeid' ";
			$having="";
			$join="";
			$groupby="";
			$orderby="";
			$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$employees->fetchObject;
			
			$not->email=$employees->officemail;
			$not->subject="Action Plan Assignment";
			$checklists=new Checklists();
			$where=" where tender_checklists.tenderid='$obj->tenderid'  ";
			$fields="tender_checklists.id, tender_checklists.name, tender_checklists.checklistcategoryid, tender_checklists.tenderid, tender_checklists.description, tender_checklists.deadline, tender_checklists.status, tender_checklists.doneon, tender_checklists.completedon, tender_checklists.remarks, tender_checklists.ipaddress, tender_checklists.createdby, tender_checklists.createdon, tender_checklists.lasteditedby, tender_checklists.lasteditedon";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$checklists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$checklists->fetchObject;
			$not->body="Dear $obj->firstname,<p>You have been assigned an action plan task to work on $checklists->name.<p>\"$checklists->description\"";
			$notifications->add($not);
			
			sendNotification($not->email,$obj->firstname,$not->subject,$not->body);
			
			redirect("addchecklistemployees_proc.php?id=".$checklistemployees->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$checklistemployees=new Checklistemployees();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$checklistemployees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklistemployees=$checklistemployees->setObject($obj);
		if($checklistemployees->edit($checklistemployees)){
			$error=UPDATESUCCESS;
			redirect("addchecklistemployees_proc.php?id=".$checklistemployees->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$checklists= new Checklists();
	$fields="tender_checklists.id, tender_checklists.name, tender_checklists.checklistcategoryid, tender_checklists.tenderid, tender_checklists.description, tender_checklists.deadline, tender_checklists.status, tender_checklists.doneon, tender_checklists.completedon, tender_checklists.remarks, tender_checklists.ipaddress, tender_checklists.createdby, tender_checklists.createdon, tender_checklists.lasteditedby, tender_checklists.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklists->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$checklistemployees=new Checklistemployees();
	$where=" where id=$id ";
	$fields="tender_checklistemployees.id, tender_checklistemployees.checklistid, tender_checklistemployees.employeeid, tender_checklistemployees.remarks, tender_checklistemployees.ipaddress, tender_checklistemployees.createdby, tender_checklistemployees.createdon, tender_checklistemployees.lasteditedby, tender_checklistemployees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklistemployees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$checklistemployees->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Checklistemployees ";
include "addchecklistemployees.php";
?>