<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stores_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7492";//Edit
}
else{
	$auth->roleid="7490";//Add
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
	$stores=new Stores();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$stores->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stores=$stores->setObject($obj);
		if($stores->add($stores)){
			$error=SUCCESS;
			redirect("addstores_proc.php?id=".$stores->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$stores=new Stores();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$stores->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stores=$stores->setObject($obj);
		if($stores->edit($stores)){
			$error=UPDATESUCCESS;
			redirect("addstores_proc.php?id=".$stores->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$stores=new Stores();
	$where=" where id=$id ";
	$fields="inv_stores.id, inv_stores.name, inv_stores.remarks, inv_stores.ipaddress, inv_stores.createdby, inv_stores.createdon, inv_stores.lasteditedby, inv_stores.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$stores->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$stores->fetchObject;

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
	
	
$page_title="Stores ";
include "addstores.php";
?>