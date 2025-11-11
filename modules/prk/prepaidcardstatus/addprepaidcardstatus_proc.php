<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidcardstatus_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8311";//Edit
}
else{
	$auth->roleid="8311";//Add
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
	$prepaidcardstatus=new Prepaidcardstatus();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$prepaidcardstatus->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidcardstatus=$prepaidcardstatus->setObject($obj);
		if($prepaidcardstatus->add($prepaidcardstatus)){
			$error=SUCCESS;
			redirect("addprepaidcardstatus_proc.php?id=".$prepaidcardstatus->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$prepaidcardstatus=new Prepaidcardstatus();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$prepaidcardstatus->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidcardstatus=$prepaidcardstatus->setObject($obj);
		if($prepaidcardstatus->edit($prepaidcardstatus)){
			$error=UPDATESUCCESS;
			redirect("addprepaidcardstatus_proc.php?id=".$prepaidcardstatus->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$prepaidcardstatus=new Prepaidcardstatus();
	$where=" where id=$id ";
	$fields="prk_prepaidcardstatus.Card_Number, prk_prepaidcardstatus.Amount, prk_prepaidcardstatus.Status, prk_prepaidcardstatus.User_pin, prk_prepaidcardstatus.User_id, prk_prepaidcardstatus.Card_Serial_number, prk_prepaidcardstatus.User_phone_number, prk_prepaidcardstatus.User_Pin_Retries, prk_prepaidcardstatus.User_Allowed_pin_Retries";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$prepaidcardstatus->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$prepaidcardstatus->fetchObject;

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
	
	
$page_title="Prepaidcardstatus ";
include "addprepaidcardstatus.php";
?>