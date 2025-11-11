<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerissues_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8405";//Edit
}
else{
	$auth->roleid="8403";//Add
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
	
	
if($obj->action=="Save"){
	$customerissues=new Customerissues();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customerissues->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerissues=$customerissues->setObject($obj);
		if($customerissues->add($customerissues)){
			$error=SUCCESS;
			redirect("addcustomerissues_proc.php?id=".$customerissues->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customerissues=new Customerissues();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$customerissues->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerissues=$customerissues->setObject($obj);
		if($customerissues->edit($customerissues)){
			$error=UPDATESUCCESS;
			redirect("addcustomerissues_proc.php?id=".$customerissues->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$customerissues=new Customerissues();
	$where=" where id=$id ";
	$fields="crm_customerissues.id, crm_customerissues.documentno, crm_customerissues.customerid, crm_customerissues.issuetypeid, crm_customerissues.description, crm_customerissues.remarks, crm_customerissues.status, crm_customerissues.employeeid, crm_customerissues.startedon, crm_customerissues.finishedon, crm_customerissues.ipaddress, crm_customerissues.createdby, crm_customerissues.createdon, crm_customerissues.lasteditedby, crm_customerissues.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerissues->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customerissues->fetchObject;

	//for autocompletes
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
	
	
$page_title="Customerissues ";
include "addcustomerissues.php";
?>