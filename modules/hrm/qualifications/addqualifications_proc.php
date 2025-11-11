<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Qualifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4211";//Edit
}
else{
	$auth->roleid="4209";//Add
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
	$qualifications=new Qualifications();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$qualifications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$qualifications=$qualifications->setObject($obj);
		if($qualifications->add($qualifications)){
			$error=SUCCESS;
			redirect("addqualifications_proc.php?id=".$qualifications->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$qualifications=new Qualifications();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$qualifications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$qualifications=$qualifications->setObject($obj);
		if($qualifications->edit($qualifications)){
			$error=UPDATESUCCESS;
			redirect("addqualifications_proc.php?id=".$qualifications->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$qualifications=new Qualifications();
	$where=" where id=$id ";
	$fields="hrm_qualifications.id, hrm_qualifications.name, hrm_qualifications.remarks, hrm_qualifications.createdby, hrm_qualifications.createdon, hrm_qualifications.lasteditedby, hrm_qualifications.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$qualifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$qualifications->fetchObject;

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
	
	
$page_title="Qualifications ";
include "addqualifications.php";
?>