<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectteams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/projects/Projects_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../pm/teampositions/Teampositions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9047";//Edit
}
else{
	$auth->roleid="9047";//Add
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
	$projectteams=new Projectteams();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectteams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectteams=$projectteams->setObject($obj);
		if($projectteams->add($projectteams)){
			$error=SUCCESS;
			redirect("addprojectteams_proc.php?id=".$projectteams->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectteams=new Projectteams();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectteams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectteams=$projectteams->setObject($obj);
		if($projectteams->edit($projectteams)){
			$error=UPDATESUCCESS;
			redirect("addprojectteams_proc.php?id=".$projectteams->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$projects= new Projects();
	$fields="pm_projects.id, pm_projects.customerid, pm_projects.name, pm_projects.description, pm_projects.startdate, pm_projects.expectedcompletion, pm_projects.actualcompletion, pm_projects.remarks, pm_projects.ipaddress, pm_projects.createdby, pm_projects.createdon, pm_projects.lasteditedby, pm_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$teampositions= new Teampositions();
	$fields="pm_teampositions.id, pm_teampositions.name, pm_teampositions.remarks, pm_teampositions.ipaddress, pm_teampositions.createdby, pm_teampositions.createdon, pm_teampositions.lasteditedby, pm_teampositions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teampositions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectteams=new Projectteams();
	$where=" where id=$id ";
	$fields="pm_projectteams.id, pm_projectteams.projectid, pm_projectteams.employeeid, pm_projectteams.teampositionid, pm_projectteams.remarks, pm_projectteams.ipaddress, pm_projectteams.createdby, pm_projectteams.createdon, pm_projectteams.lasteditedby, pm_projectteams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectteams->fetchObject;

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
	
	
$page_title="Projectteams ";
include "addprojectteams.php";
?>