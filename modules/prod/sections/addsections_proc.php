<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/blocks/Blocks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9024";//Edit
}
else{
	$auth->roleid="9022";//Add
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
	$sections=new Sections();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$sections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sections=$sections->setObject($obj);
		if($sections->add($sections)){
			$error=SUCCESS;
			redirect("addsections_proc.php?id=".$sections->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sections=new Sections();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sections=$sections->setObject($obj);
		if($sections->edit($sections)){
			$error=UPDATESUCCESS;
			redirect("addsections_proc.php?id=".$sections->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$blocks= new Blocks();
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$sections=new Sections();
	$where=" where id=$id ";
	$fields="prod_sections.id, prod_sections.name, prod_sections.blockid, prod_sections.employeeid, prod_sections.remarks, prod_sections.ipaddress, prod_sections.createdby, prod_sections.createdon, prod_sections.lasteditedby, prod_sections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sections->fetchObject;

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
	
	
$page_title="Sections ";
include "addsections.php";
?>