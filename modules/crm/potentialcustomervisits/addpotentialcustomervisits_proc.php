<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Potentialcustomervisits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8495";//Edit
}
else{
	$auth->roleid="8495";//Add
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
	$potentialcustomervisits=new Potentialcustomervisits();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$potentialcustomervisits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$potentialcustomervisits=$potentialcustomervisits->setObject($obj);
		if($potentialcustomervisits->add($potentialcustomervisits)){
			$error=SUCCESS;
			redirect("addpotentialcustomervisits_proc.php?id=".$potentialcustomervisits->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$potentialcustomervisits=new Potentialcustomervisits();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$potentialcustomervisits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$potentialcustomervisits=$potentialcustomervisits->setObject($obj);
		if($potentialcustomervisits->edit($potentialcustomervisits)){
			$error=UPDATESUCCESS;
			redirect("addpotentialcustomervisits_proc.php?id=".$potentialcustomervisits->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$potentialcustomervisits=new Potentialcustomervisits();
	$where=" where id=$id ";
	$fields="crm_potentialcustomervisits.id, crm_potentialcustomervisits.potentialcustomerid, crm_potentialcustomervisits.vistedon, crm_potentialcustomervisits.employeeid, crm_potentialcustomervisits.findings, crm_potentialcustomervisits.recommendations, crm_potentialcustomervisits.remarks, crm_potentialcustomervisits.ipaddress, crm_potentialcustomervisits.createdby, crm_potentialcustomervisits.createdon, crm_potentialcustomervisits.lasteditedby, crm_potentialcustomervisits.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$potentialcustomervisits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$potentialcustomervisits->fetchObject;

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
	
	
$page_title="Potentialcustomervisits ";
include "addpotentialcustomervisits.php";
?>