<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Forms_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="130";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="128";//Add
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
	$forms=new Forms();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$forms->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$forms=$forms->setObject($obj);
		if($forms->add($forms)){
			$error=SUCCESS;
			redirect("addforms_proc.php?id=".$forms->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$forms=new Forms();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$forms->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$forms=$forms->setObject($obj);
		if($forms->edit($forms)){
			$error=UPDATESUCCESS;
			redirect("addforms_proc.php?id=".$forms->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$forms=new Forms();
	$where=" where id=$id ";
	$fields="sys_forms.id, sys_forms.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$forms->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$forms->fetchObject;

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
	
	
$page_title="Forms ";
include "addforms.php";
?>