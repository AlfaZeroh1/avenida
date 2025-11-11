<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Hsedescriptions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4125";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4123";//Add
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
	$hsedescriptions=new Hsedescriptions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$hsedescriptions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$hsedescriptions=$hsedescriptions->setObject($obj);
		if($hsedescriptions->add($hsedescriptions)){
			$error=SUCCESS;
			redirect("addhsedescriptions_proc.php?id=".$hsedescriptions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$hsedescriptions=new Hsedescriptions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$hsedescriptions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$hsedescriptions=$hsedescriptions->setObject($obj);
		if($hsedescriptions->edit($hsedescriptions)){
			$error=UPDATESUCCESS;
			redirect("addhsedescriptions_proc.php?id=".$hsedescriptions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$hsedescriptions=new Hsedescriptions();
	$where=" where id=$id ";
	$fields="em_hsedescriptions.id, em_hsedescriptions.name, em_hsedescriptions.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$hsedescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$hsedescriptions->fetchObject;

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
	
	
$page_title="Hsedescriptions ";
include "addhsedescriptions.php";
?>