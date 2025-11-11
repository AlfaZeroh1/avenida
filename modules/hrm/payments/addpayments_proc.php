<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1179";//Edit
}
else{
	$auth->roleid="1177";//Add
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
	$payments=new Payments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$payments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payments=$payments->setObject($obj);
		if($payments->add($payments)){
			$error=SUCCESS;
			redirect("addpayments_proc.php?id=".$payments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payments=new Payments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payments=$payments->setObject($obj);
		if($payments->edit($payments)){
			$error=UPDATESUCCESS;
			redirect("addpayments_proc.php?id=".$payments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$payments=new Payments();
	$where=" where id=$id ";
	$fields="hrm_payments.id, hrm_payments.employeeid, hrm_payments.paymentmodeid, hrm_payments.assignmentid, hrm_payments.bank, hrm_payments.bankacc, hrm_payments.year, hrm_payments.month, hrm_payments.gross, hrm_payments.paye, hrm_payments.paydate, hrm_payments.days, hrm_payments.createdby, hrm_payments.createdon, hrm_payments.lasteditedby, hrm_payments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payments->fetchObject;

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
	
	
$page_title="Payments ";
include "addpayments.php";
?>