<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Statuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4798";//Edit
}
else{
	$auth->roleid="4798";//Add
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
	$statuss=new Statuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$statuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$statuss=$statuss->setObject($obj);
		if($statuss->add($statuss)){
			$error=SUCCESS;
			redirect("addstatuss_proc.php?id=".$statuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$statuss=new Statuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$statuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$statuss=$statuss->setObject($obj);
		if($statuss->edit($statuss)){
			$error=UPDATESUCCESS;
			redirect("addstatuss_proc.php?id=".$statuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$statuss=new Statuss();
	$where=" where id=$id ";
	$fields="crm_statuss.id, crm_statuss.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$statuss->fetchObject;

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
	
	
$page_title="Statuss ";
include "addstatuss.php";
?>