<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedisplinarys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/disciplinarytypes/Disciplinarytypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4830";//Edit
}
else{
	$auth->roleid="4830";//Add
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
	
	
if($obj->action=="Save"){
	$employeedisplinarys=new Employeedisplinarys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeedisplinarys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedisplinarys=$employeedisplinarys->setObject($obj);
		if($employeedisplinarys->add($employeedisplinarys)){
			$error=SUCCESS;
			redirect("addemployeedisplinarys_proc.php?id=".$employeedisplinarys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeedisplinarys=new Employeedisplinarys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeedisplinarys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedisplinarys=$employeedisplinarys->setObject($obj);
		if($employeedisplinarys->edit($employeedisplinarys)){
			$error=UPDATESUCCESS;
			redirect("addemployeedisplinarys_proc.php?id=".$employeedisplinarys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$disciplinarytypes= new Disciplinarytypes();
	$fields="hrm_disciplinarytypes.id, hrm_disciplinarytypes.name, hrm_disciplinarytypes.remarks, hrm_disciplinarytypes.createdby, hrm_disciplinarytypes.createdon, hrm_disciplinarytypes.lasteditedby, hrm_disciplinarytypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$disciplinarytypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeedisplinarys=new Employeedisplinarys();
	$where=" where id=$id ";
	$fields="hrm_employeedisplinarys.id, hrm_employeedisplinarys.employeeid, hrm_employeedisplinarys.disciplinarytypeid, hrm_employeedisplinarys.disciplinarydate, hrm_employeedisplinarys.description, hrm_employeedisplinarys.remarks, hrm_employeedisplinarys.createdby, hrm_employeedisplinarys.createdon, hrm_employeedisplinarys.lasteditedby, hrm_employeedisplinarys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeedisplinarys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeedisplinarys->fetchObject;

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
	
	
$page_title="Employeedisplinarys ";
include "addemployeedisplinarys.php";
?>