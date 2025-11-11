<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Potentialcustomers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/agents/Agents_class.php");
require_once("../../crm/departments/Departments_class.php");
require_once("../../crm/categorydepartments/Categorydepartments_class.php");
require_once("../../crm/categorys/Categorys_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8491";//Edit
}
else{
	$auth->roleid="8491";//Add
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
	$potentialcustomers=new Potentialcustomers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$potentialcustomers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$potentialcustomers=$potentialcustomers->setObject($obj);
		if($potentialcustomers->add($potentialcustomers)){
			$error=SUCCESS;
			redirect("addpotentialcustomers_proc.php?id=".$potentialcustomers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$potentialcustomers=new Potentialcustomers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$potentialcustomers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$potentialcustomers=$potentialcustomers->setObject($obj);
		if($potentialcustomers->edit($potentialcustomers)){
			$error=UPDATESUCCESS;
			redirect("addpotentialcustomers_proc.php?id=".$potentialcustomers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$agents= new Agents();
	$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_agents.statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon, crm_agents.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="crm_departments.id, crm_departments.name, crm_departments.remarks, crm_departments.createdby, crm_departments.createdon, crm_departments.lasteditedby, crm_departments.lasteditedon, crm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorydepartments= new Categorydepartments();
	$fields="crm_categorydepartments.id, crm_categorydepartments.name, crm_categorydepartments.departmentid, crm_categorydepartments.remarks, crm_categorydepartments.createdby, crm_categorydepartments.createdon, crm_categorydepartments.lasteditedby, crm_categorydepartments.lasteditedon, crm_categorydepartments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorydepartments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorys= new Categorys();
	$fields="crm_categorys.id, crm_categorys.name, crm_categorys.remarks, crm_categorys.createdby, crm_categorys.createdon, crm_categorys.lasteditedby, crm_categorys.lasteditedon, crm_categorys.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$potentialcustomers=new Potentialcustomers();
	$where=" where id=$id ";
	$fields="crm_potentialcustomers.id, crm_potentialcustomers.name, crm_potentialcustomers.agentid, crm_potentialcustomers.departmentid, crm_potentialcustomers.categorydepartmentid, crm_potentialcustomers.categoryid, crm_potentialcustomers.employeeid, crm_potentialcustomers.idno, crm_potentialcustomers.pinno, crm_potentialcustomers.address, crm_potentialcustomers.tel, crm_potentialcustomers.fax, crm_potentialcustomers.email, crm_potentialcustomers.contactname, crm_potentialcustomers.contactphone, crm_potentialcustomers.remarks, crm_potentialcustomers.status, crm_potentialcustomers.createdby, crm_potentialcustomers.createdon, crm_potentialcustomers.lasteditedby, crm_potentialcustomers.lasteditedon, crm_potentialcustomers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$potentialcustomers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$potentialcustomers->fetchObject;

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
	
	
$page_title="Potentialcustomers ";
include "addpotentialcustomers.php";
?>