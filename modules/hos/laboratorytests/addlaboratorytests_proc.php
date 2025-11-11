<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Laboratorytests_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$laboratorytests=new Laboratorytests();
	$where=" where id=$id ";
	$fields="hos_laboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.remarks, hos_laboratorytests.charge";
$join="";
$having="";
$groupby="";
$orderby="";
	$laboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$laboratorytests->fetchObject;
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
		$laboratorytests=new Laboratorytests();
		$laboratorytests=setObject($obj);
		if($laboratorytests->add($laboratorytests)){
			$error=SUCCESS;
			redirect("addlaboratorytests_proc.php?error=".$error);
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
		$laboratorytests=new Laboratorytests();
		$laboratorytests=setObject($obj);
		if($laboratorytests->edit($laboratorytests)){
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
		$laboratorytests= new Laboratorytests();
		$laboratorytests->id=str_replace(',','',$obj->id);
		$laboratorytests->name=str_replace(',','',$obj->name);
		$laboratorytests->remarks=str_replace(',','',$obj->remarks);
		$laboratorytests->charge=str_replace(',','',$obj->charge);
		return $laboratorytests;
	
}
$page_title="Laboratorytests";
include "addlaboratorytests.php";
?>