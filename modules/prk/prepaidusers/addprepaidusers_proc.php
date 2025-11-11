<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidusers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8319";//Edit
}
else{
	$auth->roleid="8319";//Add
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
	$prepaidusers=new Prepaidusers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$prepaidusers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidusers=$prepaidusers->setObject($obj);
		if($prepaidusers->add($prepaidusers)){
			$error=SUCCESS;
			redirect("addprepaidusers_proc.php?id=".$prepaidusers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$prepaidusers=new Prepaidusers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$prepaidusers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidusers=$prepaidusers->setObject($obj);
		if($prepaidusers->edit($prepaidusers)){
			$error=UPDATESUCCESS;
			redirect("addprepaidusers_proc.php?id=".$prepaidusers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$prepaidusers=new Prepaidusers();
	$where=" where id=$id ";
	$fields="prk_prepaidusers.User_id, prk_prepaidusers.User_pin, prk_prepaidusers.Account_balance, prk_prepaidusers.last_reload_card, prk_prepaidusers.Status, prk_prepaidusers.User_phone_number, prk_prepaidusers.User_Pin_Retries, prk_prepaidusers.User_Allowed_pin_Retries";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$prepaidusers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$prepaidusers->fetchObject;

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
	
	
$page_title="Prepaidusers ";
include "addprepaidusers.php";
?>