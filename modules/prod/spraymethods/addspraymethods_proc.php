<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Spraymethods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8717";//Edit
}
else{
	$auth->roleid="8715";//Add
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
	$spraymethods=new Spraymethods();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$spraymethods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$spraymethods=$spraymethods->setObject($obj);
		if($spraymethods->add($spraymethods)){
			$error=SUCCESS;
			redirect("addspraymethods_proc.php?id=".$spraymethods->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$spraymethods=new Spraymethods();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$spraymethods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$spraymethods=$spraymethods->setObject($obj);
		if($spraymethods->edit($spraymethods)){
			$error=UPDATESUCCESS;
			redirect("addspraymethods_proc.php?id=".$spraymethods->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$spraymethods=new Spraymethods();
	$where=" where id=$id ";
	$fields="prod_spraymethods.id, prod_spraymethods.name, prod_spraymethods.remarks, prod_spraymethods.ipaddress, prod_spraymethods.createdby, prod_spraymethods.createdon, prod_spraymethods.lasteditedby, prod_spraymethods.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$spraymethods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$spraymethods->fetchObject;

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
	
	
$page_title="Spraymethods ";
include "addspraymethods.php";
?>