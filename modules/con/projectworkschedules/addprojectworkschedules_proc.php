<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectworkschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projectboqs/Projectboqs_class.php");
require_once("../../con/projectquantities/Projectquantities_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8169";//Edit
}
else{
	$auth->roleid="8167";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;


if(!empty($ob->projectboqid))
  $obj->projectboqid=$ob->projectboqid;

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
	$projectworkschedules=new Projectworkschedules();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectworkschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectworkschedules=$projectworkschedules->setObject($obj);
		if($projectworkschedules->add($projectworkschedules)){
			$error=SUCCESS;
			redirect("addprojectworkschedules_proc.php?id=".$projectworkschedules->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectworkschedules=new Projectworkschedules();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectworkschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectworkschedules=$projectworkschedules->setObject($obj);
		if($projectworkschedules->edit($projectworkschedules)){
			$error=UPDATESUCCESS;
			redirect("addprojectworkschedules_proc.php?id=".$projectworkschedules->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$projectboqs= new Projectboqs();
	$fields="con_projectboqs.id, con_projectboqs.billofquantitieid, con_projectboqs.name, con_projectboqs.quantity, con_projectboqs.unitofmeasureid, con_projectboqs.bqrate, con_projectboqs.total, con_projectboqs.remarks, con_projectboqs.ipaddress, con_projectboqs.createdby, con_projectboqs.createdon, con_projectboqs.lasteditedby, con_projectboqs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqs->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectworkschedules=new Projectworkschedules();
	$where=" where id=$id ";
	$fields="con_projectworkschedules.id, con_projectworkschedules.projectboqid, con_projectworkschedules.employeeid, con_projectworkschedules.projectweek, con_projectworkschedules.week, con_projectworkschedules.year, con_projectworkschedules.priority, con_projectworkschedules.tracktime, con_projectworkschedules.reqduration, con_projectworkschedules.reqdurationtype, con_projectworkschedules.deadline, con_projectworkschedules.startdate, con_projectworkschedules.starttime, con_projectworkschedules.enddate, con_projectworkschedules.endtime, con_projectworkschedules.duration, con_projectworkschedules.durationtype, con_projectworkschedules.remind, con_projectworkschedules.remarks, con_projectworkschedules.ipaddress, con_projectworkschedules.createdby, con_projectworkschedules.createdon, con_projectworkschedules.lasteditedby, con_projectworkschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectworkschedules->fetchObject;

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
	
	
$page_title="Projectworkschedules ";
include "addprojectworkschedules.php";
?>