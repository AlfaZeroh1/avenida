<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Wards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/departments/Departments_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1313";//Edit
}
else{
	$auth->roleid="1311";//Add
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
	$wards=new Wards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$wards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$wards=$wards->setObject($obj);
		if($wards->add($wards)){
			$error=SUCCESS;
			redirect("addwards_proc.php?id=".$wards->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$wards=new Wards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$wards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$wards=$wards->setObject($obj);
		if($wards->edit($wards)){
			$error=UPDATESUCCESS;
			redirect("addwards_proc.php?id=".$wards->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$wards=new Wards();
	$where=" where id=$id ";
	$fields="hos_wards.id, hos_wards.name, hos_wards.departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$wards->fetchObject;

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
	
	
$page_title="Wards ";
include "addwards.php";
?>