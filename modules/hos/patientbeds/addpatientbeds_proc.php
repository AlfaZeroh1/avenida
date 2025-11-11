<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientbeds_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4507";//Edit
}
else{
	$auth->roleid="4507";//Add
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
	$patientbeds=new Patientbeds();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$patientbeds->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientbeds=$patientbeds->setObject($obj);
		if($patientbeds->add($patientbeds)){
			$error=SUCCESS;
			redirect("addpatientbeds_proc.php?id=".$patientbeds->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$patientbeds=new Patientbeds();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$patientbeds->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientbeds=$patientbeds->setObject($obj);
		if($patientbeds->edit($patientbeds)){
			$error=UPDATESUCCESS;
			redirect("addpatientbeds_proc.php?id=".$patientbeds->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$patientbeds=new Patientbeds();
	$where=" where id=$id ";
	$fields="hos_patientbeds.id, hos_patientbeds.bedid, hos_patientbeds.patientid, hos_patientbeds.treatmentid, hos_patientbeds.allocatedon, hos_patientbeds.lefton, hos_patientbeds.createdby, hos_patientbeds.createdon, hos_patientbeds.lasteditedby, hos_patientbeds.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientbeds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientbeds->fetchObject;

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
	
	
$page_title="Patientbeds ";
include "addpatientbeds.php";
?>