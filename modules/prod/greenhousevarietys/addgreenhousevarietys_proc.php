<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Greenhousevarietys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/greenhouses/Greenhouses_class.php");
require_once("../../prod/varietys/Varietys_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/breeders/Breeders_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9058";//Edit
}
else{
	$auth->roleid="9056";//Add
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
	$greenhousevarietys=new Greenhousevarietys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$greenhousevarietys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$greenhousevarietys=$greenhousevarietys->setObject($obj);
		if($greenhousevarietys->add($greenhousevarietys)){
			$error=SUCCESS;
			redirect("addgreenhousevarietys_proc.php?id=".$greenhousevarietys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$greenhousevarietys=new Greenhousevarietys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$greenhousevarietys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$greenhousevarietys=$greenhousevarietys->setObject($obj);
		if($greenhousevarietys->edit($greenhousevarietys)){
			$error=UPDATESUCCESS;
			redirect("addgreenhousevarietys_proc.php?id=".$greenhousevarietys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$greenhouses= new Greenhouses();
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$greenhousevarietys=new Greenhousevarietys();
	$where=" where id=$id ";
	$fields="prod_greenhousevarietys.id, prod_greenhousevarietys.greenhouseid, prod_greenhousevarietys.varietyid, prod_greenhousevarietys.employeeid, prod_greenhousevarietys.area, prod_greenhousevarietys.plants, prod_greenhousevarietys.remarks, prod_greenhousevarietys.ipaddress, prod_greenhousevarietys.createdby, prod_greenhousevarietys.createdon, prod_greenhousevarietys.lasteditedby, prod_greenhousevarietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhousevarietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$greenhousevarietys->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
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
	
	
$page_title="Greenhousevarietys ";
include "addgreenhousevarietys.php";
?>