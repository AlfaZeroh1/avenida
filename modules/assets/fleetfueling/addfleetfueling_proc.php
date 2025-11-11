<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetfueling_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/fleets/Fleets_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7719";//Edit
}
else{
	$auth->roleid="7719";//Add
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
	$fleetfueling=new Fleetfueling();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetfueling->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetfueling=$fleetfueling->setObject($obj);
		if($fleetfueling->add($fleetfueling)){
			$error=SUCCESS;
			redirect("addfleetfueling_proc.php?id=".$fleetfueling->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetfueling=new Fleetfueling();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetfueling->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetfueling=$fleetfueling->setObject($obj);
		if($fleetfueling->edit($fleetfueling)){
			$error=UPDATESUCCESS;
			redirect("addfleetfueling_proc.php?id=".$fleetfueling->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$fleets= new Fleets();
	$fields="assets_fleets.id, assets_fleets.assetid, assets_fleets.fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleets.fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleets.fleetfueltypeid, assets_fleets.fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, assets_fleets.employeeid, assets_fleets.departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$fleetfueling=new Fleetfueling();
	$where=" where id=$id ";
	$fields="assets_fleetfueling.id, assets_fleetfueling.fleetid, assets_fleetfueling.quantity, assets_fleetfueling.cost, assets_fleetfueling.fueledon, assets_fleetfueling.employeeid, assets_fleetfueling.documentno, assets_fleetfueling.startodometer, assets_fleetfueling.endodometer, assets_fleetfueling.destination, assets_fleetfueling.remarks, assets_fleetfueling.ipaddress, assets_fleetfueling.createdby, assets_fleetfueling.createdon, assets_fleetfueling.lasteditedby, assets_fleetfueling.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetfueling->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetfueling->fetchObject;

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
	
	
$page_title="Fleetfueling ";
include "addfleetfueling.php";
?>