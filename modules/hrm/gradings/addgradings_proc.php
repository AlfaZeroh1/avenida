<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Gradings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4321";//Edit
}
else{
	$auth->roleid="4321";//Add
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
	$gradings=new Gradings();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$gradings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$gradings=$gradings->setObject($obj);
		if($gradings->add($gradings)){
			$error=SUCCESS;
			redirect("addgradings_proc.php?id=".$gradings->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$gradings=new Gradings();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$gradings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$gradings=$gradings->setObject($obj);
		if($gradings->edit($gradings)){
			$error=UPDATESUCCESS;
			redirect("addgradings_proc.php?id=".$gradings->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$gradings=new Gradings();
	$where=" where id=$id ";
	$fields="hrm_gradings.id, hrm_gradings.name, hrm_gradings.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$gradings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$gradings->fetchObject;

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
	
	
$page_title="Gradings ";
include "addgradings.php";
?>