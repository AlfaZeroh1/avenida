<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeclockings_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");


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
	
if($_GET['clock']=="clockin"){
	$users = new Users();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='".$_SESSION['userid']."'";
	$users->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$users = $users->fetchObject;
	
	$obj->starttime=date("H:i:s");
	$obj->today=date("Y-m-d");
	$obj->employeeid=$users->employeeid;
	$obj->action="Save";
}

if($_GET['clock']=="clockout"){
	$today=date("Y-m-d");
	$employeeclockings=new Employeeclockings();
	$fields=" hrm_employeeclockings.* ";
	$join=" left join auth_users on auth_users.employeeid=hrm_employeeclockings.employeeid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where auth_users.id='".$_SESSION['userid']."' and today='$today' and endtime='00:00:00' ";
	$employeeclockings->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employeeclockings = $employeeclockings->fetchObject;

	$obj->endtime=date("H:i:s");
	$obj->starttime=$employeeclockings->starttime;
	$obj->today=$employeeclockings->today;
	$obj->employeeid=$employeeclockings->employeeid;
	$obj->id=$employeeclockings->id;
	
	$employeeclocking=new Employeeclockings();
	$employeeclocking=$employeeclocking->setObject($obj);
	if($employeeclocking->edit($employeeclocking)){
		$error=UPDATESUCCESS;
		redirect("../../../index.php");
	}
	
}
	
if($obj->action=="Save"){
	$employeeclockings=new Employeeclockings();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeeclockings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeclockings=$employeeclockings->setObject($obj);
		if($employeeclockings->add($employeeclockings)){
			$error=SUCCESS;
			redirect("../../../index.php");
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeclockings=new Employeeclockings();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeclockings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeclockings=$employeeclockings->setObject($obj);
		if($employeeclockings->edit($employeeclockings)){
			$error=UPDATESUCCESS;
			redirect("addemployeeclockings_proc.php?id=".$employeeclockings->id."&error=".$error);
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
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $sql;

}

if(!empty($id)){
	$employeeclockings=new Employeeclockings();
	$where=" where id=$id ";
	$fields="hrm_employeeclockings.id, hrm_employeeclockings.employeeid, hrm_employeeclockings.starttime, hrm_employeeclockings.endtime, hrm_employeeclockings.today, hrm_employeeclockings.remarks, hrm_employeeclockings.createdby, hrm_employeeclockings.createdon, hrm_employeeclockings.lasteditedby, hrm_employeeclockings.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeclockings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeclockings->fetchObject;

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
	
	
$page_title="Employeeclockings ";
include "addemployeeclockings.php";
?>