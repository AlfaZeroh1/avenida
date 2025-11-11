<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeesurchages_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/surchages/Surchages_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/surchagetypes/Surchagetypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1171";//Edit
}
else{
	$auth->roleid="1169";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(empty($obj->action)){
  $obj->chargedon=date("Y-m-d");
  $obj->frommonth=date("m");
  $obj->fromyear=date("Y");
  $obj->toyear=date("Y");
  $obj->tomonth=date("m");
}

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
	
	
if($obj->action=="Save"){
	$employeesurchages=new Employeesurchages();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeesurchages->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeesurchages=$employeesurchages->setObject($obj);
		if($employeesurchages->add($employeesurchages)){
			$error=SUCCESS;
			redirect("addemployeesurchages_proc.php?id=".$employeesurchages->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeesurchages=new Employeesurchages();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeesurchages->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeesurchages=$employeesurchages->setObject($obj);
		if($employeesurchages->edit($employeesurchages)){
			$error=UPDATESUCCESS;
			redirect("addemployeesurchages_proc.php?id=".$employeesurchages->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$surchages= new Surchages();
	$fields="hrm_surchages.id, hrm_surchages.name, hrm_surchages.amount, hrm_surchages.remarks, hrm_surchages.surchagetypeid, hrm_surchages.frommonth, hrm_surchages.fromyear, hrm_surchages.tomonth, hrm_surchages.toyear, hrm_surchages.overall, hrm_surchages.status, hrm_surchages.createdby, hrm_surchages.createdon, hrm_surchages.lasteditedby, hrm_surchages.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$surchagetypes= new Surchagetypes();
	$fields="hrm_surchagetypes.id, hrm_surchagetypes.name, hrm_surchagetypes.repeatafter, hrm_surchagetypes.remarks, hrm_surchagetypes.createdby, hrm_surchagetypes.createdon, hrm_surchagetypes.lasteditedby, hrm_surchagetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeesurchages=new Employeesurchages();
	$where=" where id=$id ";
	$fields="hrm_employeesurchages.id, hrm_employeesurchages.surchageid, hrm_employeesurchages.employeeid, hrm_employeesurchages.surchagetypeid, hrm_employeesurchages.amount, hrm_employeesurchages.chargedon, hrm_employeesurchages.frommonth, hrm_employeesurchages.fromyear, hrm_employeesurchages.tomonth, hrm_employeesurchages.toyear, hrm_employeesurchages.remarks, hrm_employeesurchages.createdby, hrm_employeesurchages.createdon, hrm_employeesurchages.lasteditedby, hrm_employeesurchages.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeesurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeesurchages->fetchObject;

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
	
	
$page_title="Employeesurchages ";
include "addemployeesurchages.php";
?>