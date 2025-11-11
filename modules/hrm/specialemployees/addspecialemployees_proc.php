<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Specialemployees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1191";//Edit
}
else{
	$auth->roleid="1189";//Add
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
	$specialemployees=new Specialemployees();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$specialemployees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$specialemployees=$specialemployees->setObject($obj);
		if($specialemployees->add($specialemployees)){
			$error=SUCCESS;
			redirect("addspecialemployees_proc.php?id=".$specialemployees->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$specialemployees=new Specialemployees();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$specialemployees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$specialemployees=$specialemployees->setObject($obj);
		if($specialemployees->edit($specialemployees)){
			$error=UPDATESUCCESS;
			redirect("addspecialemployees_proc.php?id=".$specialemployees->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$specialemployees=new Specialemployees();
	$where=" where id=$id ";
	$fields="hrm_specialemployees.id, hrm_specialemployees.employeeid, hrm_specialemployees.paye, hrm_specialemployees.nhif, hrm_specialemployees.nssf, hrm_specialemployees.createdby, hrm_specialemployees.createdon, hrm_specialemployees.lasteditedby, hrm_specialemployees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$specialemployees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$specialemployees->fetchObject;

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
	
	
$page_title="Specialemployees ";
include "addspecialemployees.php";
?>