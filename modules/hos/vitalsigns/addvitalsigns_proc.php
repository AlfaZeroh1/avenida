<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Vitalsigns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4363";//Edit
}
else{
	$auth->roleid="4363";//Add
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
	$vitalsigns=new Vitalsigns();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$vitalsigns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vitalsigns=$vitalsigns->setObject($obj);
		if($vitalsigns->add($vitalsigns)){
			$error=SUCCESS;
			redirect("addvitalsigns_proc.php?id=".$vitalsigns->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$vitalsigns=new Vitalsigns();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$vitalsigns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vitalsigns=$vitalsigns->setObject($obj);
		if($vitalsigns->edit($vitalsigns)){
			$error=UPDATESUCCESS;
			redirect("addvitalsigns_proc.php?id=".$vitalsigns->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$vitalsigns=new Vitalsigns();
	$where=" where id=$id ";
	$fields="hos_vitalsigns.id, hos_vitalsigns.name, hos_vitalsigns.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$vitalsigns->fetchObject;

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
	
	
$page_title="Vitalsigns ";
include "addvitalsigns.php";
?>