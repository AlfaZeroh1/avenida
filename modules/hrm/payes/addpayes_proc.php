<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4842";//Edit
}
else{
	$auth->roleid="4842";//Add
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
	$payes=new Payes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$payes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payes=$payes->setObject($obj);
		if($payes->add($payes)){
			$error=SUCCESS;
			redirect("addpayes_proc.php?id=".$payes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payes=new Payes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payes=$payes->setObject($obj);
		if($payes->edit($payes)){
			$error=UPDATESUCCESS;
			redirect("addpayes_proc.php?id=".$payes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$payes=new Payes();
	$where=" where id=$id ";
	$fields="hrm_payes.id, hrm_payes.low, hrm_payes.high, hrm_payes.percent";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payes->fetchObject;

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
	
	
$page_title="Payes ";
include "addpayes.php";
?>