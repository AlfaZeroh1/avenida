<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nhifs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4834";//Edit
}
else{
	$auth->roleid="4834";//Add
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
	$nhifs=new Nhifs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$nhifs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nhifs=$nhifs->setObject($obj);
		if($nhifs->add($nhifs)){
			$error=SUCCESS;
			redirect("addnhifs_proc.php?id=".$nhifs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$nhifs=new Nhifs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$nhifs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nhifs=$nhifs->setObject($obj);
		if($nhifs->edit($nhifs)){
			$error=UPDATESUCCESS;
			redirect("addnhifs_proc.php?id=".$nhifs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$nhifs=new Nhifs();
	$where=" where id=$id ";
	$fields="hrm_nhifs.id, hrm_nhifs.low, hrm_nhifs.high, hrm_nhifs.amount";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nhifs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$nhifs->fetchObject;

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
	
	
$page_title="Nhifs ";
include "addnhifs.php";
?>