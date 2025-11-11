<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientstatuss_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$patientstatuss=new Patientstatuss();
	$where=" where id=$id ";
	$fields="hos_patientstatuss.id, hos_patientstatuss.name";
$join="";
$having="";
$groupby="";
$orderby="";
	$patientstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientstatuss->fetchObject;
}
	
if($obj->action=="Save"){
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientstatuss=new Patientstatuss();
		$patientstatuss=setObject($obj);
		if($patientstatuss->add($patientstatuss)){
			$error=SUCCESS;
			redirect("addpatientstatuss_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientstatuss=new Patientstatuss();
		$patientstatuss=setObject($obj);
		if($patientstatuss->edit($patientstatuss)){
			$obj="";
			$error=UPDATESUCCESS;
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->name)){
		$error="name should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$patientstatuss= new Patientstatuss();
		$patientstatuss->id=str_replace(',','',$obj->id);
		$patientstatuss->name=str_replace(',','',$obj->name);
		return $patientstatuss;
	
}
$page_title="Patientstatuss";
include "addpatientstatuss.php";
?>