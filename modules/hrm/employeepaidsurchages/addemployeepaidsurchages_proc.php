<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidsurchages_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1155";//Edit
}
else{
	$auth->roleid="1153";//Add
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
	$employeepaidsurchages=new Employeepaidsurchages();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeepaidsurchages->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidsurchages=$employeepaidsurchages->setObject($obj);
		if($employeepaidsurchages->add($employeepaidsurchages)){
			$error=SUCCESS;
			redirect("addemployeepaidsurchages_proc.php?id=".$employeepaidsurchages->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeepaidsurchages=new Employeepaidsurchages();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeepaidsurchages->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidsurchages=$employeepaidsurchages->setObject($obj);
		if($employeepaidsurchages->edit($employeepaidsurchages)){
			$error=UPDATESUCCESS;
			redirect("addemployeepaidsurchages_proc.php?id=".$employeepaidsurchages->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeepaidsurchages=new Employeepaidsurchages();
	$where=" where id=$id ";
	$fields="hrm_employeepaidsurchages.id, hrm_employeepaidsurchages.empsurchageid, hrm_employeepaidsurchages.employeeid, hrm_employeepaidsurchages.amount, hrm_employeepaidsurchages.month, hrm_employeepaidsurchages.year, hrm_employeepaidsurchages.createdby, hrm_employeepaidsurchages.createdon, hrm_employeepaidsurchages.lasteditedby, hrm_employeepaidsurchages.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepaidsurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeepaidsurchages->fetchObject;

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
	
	
$page_title="Employeepaidsurchages ";
include "addemployeepaidsurchages.php";
?>