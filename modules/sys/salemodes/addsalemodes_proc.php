<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Salemodes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="154";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="152";//Add
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
	$salemodes=new Salemodes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$salemodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$salemodes=$salemodes->setObject($obj);
		if($salemodes->add($salemodes)){
			$error=SUCCESS;
			redirect("addsalemodes_proc.php?id=".$salemodes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$salemodes=new Salemodes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$salemodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$salemodes=$salemodes->setObject($obj);
		if($salemodes->edit($salemodes)){
			$error=UPDATESUCCESS;
			redirect("addsalemodes_proc.php?id=".$salemodes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$salemodes=new Salemodes();
	$where=" where id=$id ";
	$fields="sys_salemodes.id, sys_salemodes.name, sys_salemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$salemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$salemodes->fetchObject;

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
	
	
$page_title="Salemodes ";
include "addsalemodes.php";
?>