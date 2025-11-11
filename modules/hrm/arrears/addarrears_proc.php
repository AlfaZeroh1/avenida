<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Arrears_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9370";//Edit
}
else{
	$auth->roleid="9368";//Add
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
	$arrears=new Arrears();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$arrears->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$arrears=$arrears->setObject($obj);
		if($arrears->add($arrears)){
			$error=SUCCESS;
			redirect("addarrears_proc.php?id=".$arrears->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$arrears=new Arrears();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$arrears->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$arrears=$arrears->setObject($obj);
		if($arrears->edit($arrears)){
			$error=UPDATESUCCESS;
			redirect("addarrears_proc.php?id=".$arrears->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$arrears=new Arrears();
	$where=" where id=$id ";
	$fields="hrm_arrears.id, hrm_arrears.name, hrm_arrears.taxable, hrm_arrears.status, hrm_arrears.remarks, hrm_arrears.createdby, hrm_arrears.createdon, hrm_arrears.lasteditedby, hrm_arrears.lasteditedon, hrm_arrears.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$arrears->fetchObject;

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
	
	
$page_title="Arrears ";
include "addarrears.php";
?>