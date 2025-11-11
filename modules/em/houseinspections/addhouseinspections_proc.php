<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houseinspections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
require_once("../../em/housestatuss/Housestatuss_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8105";//Edit
}
else{
	$auth->roleid="8103";//Add
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
	$houseinspections=new Houseinspections();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$houseinspections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houseinspections=$houseinspections->setObject($obj);
		if($houseinspections->add($houseinspections)){
			$error=SUCCESS;
			redirect("addhouseinspections_proc.php?id=".$houseinspections->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$houseinspections=new Houseinspections();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$houseinspections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houseinspections=$houseinspections->setObject($obj);
		if($houseinspections->edit($houseinspections)){
			$error=UPDATESUCCESS;
			redirect("addhouseinspections_proc.php?id=".$houseinspections->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks, em_houses.ipaddress, em_houses.createdby, em_houses.createdon, em_houses.lasteditedby, em_houses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$housestatuss= new Housestatuss();
	$fields="em_housestatuss.id, em_housestatuss.name, em_housestatuss.remarks, em_housestatuss.ipaddress, em_housestatuss.createdby, em_housestatuss.createdon, em_housestatuss.lasteditedby, em_housestatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$houseinspections=new Houseinspections();
	$where=" where id=$id ";
	$fields="em_houseinspections.id, em_houseinspections.houseid, em_houseinspections.housestatusid, em_houseinspections.findings, em_houseinspections.recommendations, em_houseinspections.remarks, em_houseinspections.employeeid, em_houseinspections.doneon, em_houseinspections.ipaddress, em_houseinspections.createdby, em_houseinspections.createdon, em_houseinspections.lasteditedby, em_houseinspections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houseinspections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$houseinspections->fetchObject;

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
	
	
$page_title="Houseinspections ";
include "addhouseinspections.php";
?>