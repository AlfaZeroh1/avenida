<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidbilling_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8307";//Edit
}
else{
	$auth->roleid="8307";//Add
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
	$prepaidbilling=new Prepaidbilling();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$prepaidbilling->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidbilling=$prepaidbilling->setObject($obj);
		if($prepaidbilling->add($prepaidbilling)){
			$error=SUCCESS;
			redirect("addprepaidbilling_proc.php?id=".$prepaidbilling->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$prepaidbilling=new Prepaidbilling();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$prepaidbilling->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidbilling=$prepaidbilling->setObject($obj);
		if($prepaidbilling->edit($prepaidbilling)){
			$error=UPDATESUCCESS;
			redirect("addprepaidbilling_proc.php?id=".$prepaidbilling->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$prepaidbilling=new Prepaidbilling();
	$where=" where id=$id ";
	$fields="prk_prepaidbilling.User_id, prk_prepaidbilling.User_id_type, prk_prepaidbilling.Transaction_Type, prk_prepaidbilling.Transaction_Amount, prk_prepaidbilling.Account_Balance, prk_prepaidbilling.Card_number";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$prepaidbilling->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$prepaidbilling->fetchObject;

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
	
	
$page_title="Prepaidbilling ";
include "addprepaidbilling.php";
?>