<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Equipments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8445";//Edit
}
else{
	$auth->roleid="8443";//Add
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
	$equipments=new Equipments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$equipments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$equipments=$equipments->setObject($obj);
		if($equipments->add($equipments)){
			$error=SUCCESS;
			redirect("addequipments_proc.php?id=".$equipments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$equipments=new Equipments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$equipments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$equipments=$equipments->setObject($obj);
		if($equipments->edit($equipments)){
			$error=UPDATESUCCESS;
			redirect("addequipments_proc.php?id=".$equipments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$equipments=new Equipments();
	$where=" where id=$id ";
	$fields="con_equipments.id, con_equipments.name, con_equipments.hirecost, con_equipments.purchasecost, con_equipments.remarks, con_equipments.ipaddress, con_equipments.createdby, con_equipments.createdon, con_equipments.lasteditedby, con_equipments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$equipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$equipments->fetchObject;

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
	
	
$page_title="Equipments ";
include "addequipments.php";
?>