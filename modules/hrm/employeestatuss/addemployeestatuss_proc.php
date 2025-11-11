<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeestatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1167";//Edit
}
else{
	$auth->roleid="1165";//Add
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
	$employeestatuss=new Employeestatuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeestatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeestatuss=$employeestatuss->setObject($obj);
		if($employeestatuss->add($employeestatuss)){
			$error=SUCCESS;
			redirect("addemployeestatuss_proc.php?id=".$employeestatuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeestatuss=new Employeestatuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeestatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeestatuss=$employeestatuss->setObject($obj);
		if($employeestatuss->edit($employeestatuss)){
			$error=UPDATESUCCESS;
			redirect("addemployeestatuss_proc.php?id=".$employeestatuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeestatuss=new Employeestatuss();
	$where=" where id=$id ";
	$fields="hrm_employeestatuss.id, hrm_employeestatuss.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeestatuss->fetchObject;

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
	
	
$page_title="Employeestatuss ";
include "addemployeestatuss.php";
?>