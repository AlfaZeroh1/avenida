<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Diagnosis_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8459";//Edit
}
else{
	$auth->roleid="8459";//Add
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
	$diagnosis=new Diagnosis();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$diagnosis->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$diagnosis=$diagnosis->setObject($obj);
		if($diagnosis->add($diagnosis)){
			$error=SUCCESS;
			redirect("adddiagnosis_proc.php?id=".$diagnosis->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$diagnosis=new Diagnosis();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$diagnosis->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$diagnosis=$diagnosis->setObject($obj);
		if($diagnosis->edit($diagnosis)){
			$error=UPDATESUCCESS;
			redirect("adddiagnosis_proc.php?id=".$diagnosis->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$diagnosis=new Diagnosis();
	$where=" where id=$id ";
	$fields="hos_diagnosis.id, hos_diagnosis.name, hos_diagnosis.remarks, hos_diagnosis.ipaddress, hos_diagnosis.createdby, hos_diagnosis.createdon, hos_diagnosis.lasteditedby, hos_diagnosis.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$diagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$diagnosis->fetchObject;

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
	
	
$page_title="Diagnosis ";
include "adddiagnosis.php";
?>