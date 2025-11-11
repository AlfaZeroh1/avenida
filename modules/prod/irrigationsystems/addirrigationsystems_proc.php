<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationsystems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9217";//Edit
}
else{
	$auth->roleid="9217";//Add
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
	$irrigationsystems=new Irrigationsystems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$irrigationsystems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationsystems=$irrigationsystems->setObject($obj);
		if($irrigationsystems->add($irrigationsystems)){
			$error=SUCCESS;
			redirect("addirrigationsystems_proc.php?id=".$irrigationsystems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$irrigationsystems=new Irrigationsystems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$irrigationsystems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationsystems=$irrigationsystems->setObject($obj);
		if($irrigationsystems->edit($irrigationsystems)){
			$error=UPDATESUCCESS;
			redirect("addirrigationsystems_proc.php?id=".$irrigationsystems->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$irrigationsystems=new Irrigationsystems();
	$where=" where id=$id ";
	$fields="prod_irrigationsystems.id, prod_irrigationsystems.name, prod_irrigationsystems.remarks, prod_irrigationsystems.ipaddress, prod_irrigationsystems.createdby, prod_irrigationsystems.createdon, prod_irrigationsystems.lasteditedby, prod_irrigationsystems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationsystems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$irrigationsystems->fetchObject;

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
	
	
$page_title="Irrigationsystems ";
include "addirrigationsystems.php";
?>