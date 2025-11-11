<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Parkingslots_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8303";//Edit
}
else{
	$auth->roleid="8303";//Add
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
	$parkingslots=new Parkingslots();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$parkingslots->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$parkingslots=$parkingslots->setObject($obj);
		if($parkingslots->add($parkingslots)){
			$error=SUCCESS;
			redirect("addparkingslots_proc.php?id=".$parkingslots->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$parkingslots=new Parkingslots();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$parkingslots->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$parkingslots=$parkingslots->setObject($obj);
		if($parkingslots->edit($parkingslots)){
			$error=UPDATESUCCESS;
			redirect("addparkingslots_proc.php?id=".$parkingslots->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$parkingslots=new Parkingslots();
	$where=" where id=$id ";
	$fields="prk_parkingslots.SlotID, prk_parkingslots.Street_Name, prk_parkingslots.X, prk_parkingslots.Y, prk_parkingslots.Agent_ID";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$parkingslots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$parkingslots->fetchObject;

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
	
	
$page_title="Parkingslots ";
include "addparkingslots.php";
?>