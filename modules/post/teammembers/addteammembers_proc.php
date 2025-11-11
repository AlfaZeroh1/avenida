<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teammembers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../post/teams/Teams_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../post/teamroles/Teamroles_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8633";//Edit
}
else{
	$auth->roleid="8631";//Add
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
	$teammembers=new Teammembers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teammembers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teammembers=$teammembers->setObject($obj);
		if($teammembers->add($teammembers)){
			$error=SUCCESS;
			redirect("addteammembers_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teammembers=new Teammembers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teammembers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teammembers=$teammembers->setObject($obj);
		if($teammembers->edit($teammembers)){
			$error=UPDATESUCCESS;
			redirect("addteammembers_proc.php?id=".$teammembers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$teams= new Teams();
	$fields="post_teams.id, post_teams.name, post_teams.remarks, post_teams.ipaddress, post_teams.createdby, post_teams.createdon, post_teams.lasteditedby, post_teams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum,concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$teamroles= new Teamroles();
	$fields="post_teamroles.id, post_teamroles.name, post_teamroles.remarks, post_teamroles.ipaddress, post_teamroles.createdby, post_teamroles.createdon, post_teamroles.lasteditedby, post_teamroles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$teammembers=new Teammembers();
	$where=" where id=$id ";
	$fields="post_teammembers.id, post_teammembers.teamid, post_teammembers.employeeid, post_teammembers.teamroleid, post_teammembers.teamedon, post_teammembers.remarks, post_teammembers.ipaddress, post_teammembers.createdby, post_teammembers.createdon, post_teammembers.lasteditedby, post_teammembers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teammembers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$teammembers->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->teamedon=date("Y-m-d");
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}

$teamid = $_GET['teamid'];
if(!empty($teamid)){
  $obj->teamid=$teamid;
}
	
$page_title="Teammembers ";
include "addteammembers.php";
?>