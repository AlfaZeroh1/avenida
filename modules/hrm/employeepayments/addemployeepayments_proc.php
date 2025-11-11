<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4263";//Edit
}
else{
	$auth->roleid="4261";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	//$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
	
	
if($obj->action=="Save"){
	$employeepayments=new Employeepayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeepayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepayments=$employeepayments->setObject($obj);
		if($employeepayments->add($employeepayments)){
			$error=SUCCESS;
			redirect("addemployeepayments_proc.php?id=".$employeepayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeepayments=new Employeepayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeepayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepayments=$employeepayments->setObject($obj);
		if($employeepayments->edit($employeepayments)){
			$error=UPDATESUCCESS;
			redirect("addemployeepayments_proc.php?id=".$employeepayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeepayments=new Employeepayments();
	$where=" where id=$id ";
	$fields="hrm_employeepayments.id, hrm_employeepayments.employeeid, hrm_employeepayments.assignmentid, hrm_employeepayments.paymentmodeid, hrm_employeepayments.bankid, hrm_employeepayments.employeebankid, hrm_employeepayments.bankbrancheid, hrm_employeepayments.bankacc, hrm_employeepayments.clearingcode, hrm_employeepayments.ref, hrm_employeepayments.month, hrm_employeepayments.year, hrm_employeepayments.basic, hrm_employeepayments.paidon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeepayments->fetchObject;

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
	
	
$page_title="Employeepayments ";
include "addemployeepayments.php";
?>