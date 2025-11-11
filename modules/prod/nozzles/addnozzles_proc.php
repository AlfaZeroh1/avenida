<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nozzles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8713";//Edit
}
else{
	$auth->roleid="8711";//Add
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
	$nozzles=new Nozzles();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$nozzles->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nozzles=$nozzles->setObject($obj);
		if($nozzles->add($nozzles)){
			$error=SUCCESS;
			redirect("addnozzles_proc.php?id=".$nozzles->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$nozzles=new Nozzles();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$nozzles->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nozzles=$nozzles->setObject($obj);
		if($nozzles->edit($nozzles)){
			$error=UPDATESUCCESS;
			redirect("addnozzles_proc.php?id=".$nozzles->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$nozzles=new Nozzles();
	$where=" where id=$id ";
	$fields="prod_nozzles.id, prod_nozzles.name, prod_nozzles.remarks, prod_nozzles.ipaddress, prod_nozzles.createdby, prod_nozzles.createdon, prod_nozzles.lasteditedby, prod_nozzles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nozzles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$nozzles->fetchObject;

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
	
	
$page_title="Nozzles ";
include "addnozzles.php";
?>