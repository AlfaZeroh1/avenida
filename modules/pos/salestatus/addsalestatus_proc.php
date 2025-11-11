<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Salestatus_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2210";//Edit
}
else{
	$auth->roleid="2208";//Add
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
	$salestatus=new Salestatus();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$salestatus->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$salestatus=$salestatus->setObject($obj);
		if($salestatus->add($salestatus)){
			$error=SUCCESS;
			redirect("addsalestatus_proc.php?id=".$salestatus->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$salestatus=new Salestatus();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$salestatus->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$salestatus=$salestatus->setObject($obj);
		if($salestatus->edit($salestatus)){
			$error=UPDATESUCCESS;
			redirect("addsalestatus_proc.php?id=".$salestatus->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$salestatus=new Salestatus();
	$where=" where id=$id ";
	$fields="pos_salestatus.id, pos_salestatus.name, pos_salestatus.ipaddress, pos_salestatus.createdby, pos_salestatus.createdon, pos_salestatus.lasteditedby, pos_salestatus.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$salestatus->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$salestatus->fetchObject;

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
	
	
$page_title="Salestatus ";
include "addsalestatus.php";
?>