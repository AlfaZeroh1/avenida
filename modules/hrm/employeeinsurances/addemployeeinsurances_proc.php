<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeinsurances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/insurances/Insurances_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4227";//Edit
}
else{
	$auth->roleid="4225";//Add
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
	
	
if($obj->action=="Save"){
	$employeeinsurances=new Employeeinsurances();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeeinsurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeinsurances=$employeeinsurances->setObject($obj);
		if($employeeinsurances->add($employeeinsurances)){
			$error=SUCCESS;
			redirect("addemployeeinsurances_proc.php?id=".$employeeinsurances->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeinsurances=new Employeeinsurances();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeinsurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeinsurances=$employeeinsurances->setObject($obj);
		if($employeeinsurances->edit($employeeinsurances)){
			$error=UPDATESUCCESS;
			redirect("addemployeeinsurances_proc.php?id=".$employeeinsurances->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$insurances= new Insurances();
	$fields="hrm_insurances.id, hrm_insurances.name, hrm_insurances.remarks, hrm_insurances.createdby, hrm_insurances.createdon, hrm_insurances.lasteditedby, hrm_insurances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeeinsurances=new Employeeinsurances();
	$where=" where id=$id ";
	$fields="hrm_employeeinsurances.id, hrm_employeeinsurances.employeeid, hrm_employeeinsurances.insuranceid, hrm_employeeinsurances.premium, hrm_employeeinsurances.startdate, hrm_employeeinsurances.expectedenddate, hrm_employeeinsurances.remarks, hrm_employeeinsurances.createdby, hrm_employeeinsurances.createdon, hrm_employeeinsurances.lasteditedby, hrm_employeeinsurances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeinsurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeinsurances->fetchObject;

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
	
	
$page_title="Employeeinsurances ";
include "addemployeeinsurances.php";
?>