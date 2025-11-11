<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deductioncharges_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/deductions/Deductions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4327";//Edit
}
else{
	$auth->roleid="4325";//Add
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
	$deductioncharges=new Deductioncharges();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$deductioncharges->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deductioncharges=$deductioncharges->setObject($obj);
		if($deductioncharges->add($deductioncharges)){
			$error=SUCCESS;
			redirect("adddeductioncharges_proc.php?id=".$deductioncharges->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$deductioncharges=new Deductioncharges();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$deductioncharges->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deductioncharges=$deductioncharges->setObject($obj);
		if($deductioncharges->edit($deductioncharges)){
			$error=UPDATESUCCESS;
			redirect("adddeductioncharges_proc.php?id=".$deductioncharges->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$deductions= new Deductions();
	$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.deductiontypeid, hrm_deductions.deductioninterval, hrm_deductions.amount, hrm_deductions.charged, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$deductioncharges=new Deductioncharges();
	$where=" where id=$id ";
	$fields="hrm_deductioncharges.id, hrm_deductioncharges.deductionid, hrm_deductioncharges.amountfrom, hrm_deductioncharges.amountto, hrm_deductioncharges.charge, hrm_deductioncharges.chargetype, hrm_deductioncharges.remarks, hrm_deductioncharges.formula";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductioncharges->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$deductioncharges->fetchObject;

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
	
	
$page_title="Deductioncharges ";
include "adddeductioncharges.php";
?>