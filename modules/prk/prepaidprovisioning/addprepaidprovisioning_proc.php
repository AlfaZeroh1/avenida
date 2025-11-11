<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidprovisioning_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8315";//Edit
}
else{
	$auth->roleid="8315";//Add
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
	$prepaidprovisioning=new Prepaidprovisioning();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$prepaidprovisioning->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidprovisioning=$prepaidprovisioning->setObject($obj);
		if($prepaidprovisioning->add($prepaidprovisioning)){
			$error=SUCCESS;
			redirect("addprepaidprovisioning_proc.php?id=".$prepaidprovisioning->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$prepaidprovisioning=new Prepaidprovisioning();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$prepaidprovisioning->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prepaidprovisioning=$prepaidprovisioning->setObject($obj);
		if($prepaidprovisioning->edit($prepaidprovisioning)){
			$error=UPDATESUCCESS;
			redirect("addprepaidprovisioning_proc.php?id=".$prepaidprovisioning->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$prepaidprovisioning=new Prepaidprovisioning();
	$where=" where id=$id ";
	$fields="prk_prepaidprovisioning.Card_Number, prk_prepaidprovisioning.Amount, prk_prepaidprovisioning.Status, prk_prepaidprovisioning.Hash_Key";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$prepaidprovisioning->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$prepaidprovisioning->fetchObject;

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
	
	
$page_title="Prepaidprovisioning ";
include "addprepaidprovisioning.php";
?>