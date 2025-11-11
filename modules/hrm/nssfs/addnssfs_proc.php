<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nssfs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4838";//Edit
}
else{
	$auth->roleid="4838";//Add
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
	
	
if($obj->action=="Save"){
	$nssfs=new Nssfs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$nssfs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nssfs=$nssfs->setObject($obj);
		if($nssfs->add($nssfs)){
			$error=SUCCESS;
			redirect("addnssfs_proc.php?id=".$nssfs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$nssfs=new Nssfs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$nssfs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nssfs=$nssfs->setObject($obj);
		if($nssfs->edit($nssfs)){
			$error=UPDATESUCCESS;
			redirect("addnssfs_proc.php?id=".$nssfs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$nssfs=new Nssfs();
	$where=" where id=$id ";
	$fields="hrm_nssfs.id, hrm_nssfs.low, hrm_nssfs.high, hrm_nssfs.amount";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nssfs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$nssfs->fetchObject;

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
	
	
$page_title="Nssfs ";
include "addnssfs.php";
?>