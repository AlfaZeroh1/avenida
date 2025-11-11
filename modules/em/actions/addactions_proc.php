<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Actions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4093";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4091";//Add
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
	$actions=new Actions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$actions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$actions=$actions->setObject($obj);
		if($actions->add($actions)){
			$error=SUCCESS;
			redirect("addactions_proc.php?id=".$actions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$actions=new Actions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$actions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$actions=$actions->setObject($obj);
		if($actions->edit($actions)){
			$error=UPDATESUCCESS;
			redirect("addactions_proc.php?id=".$actions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$actions=new Actions();
	$where=" where id=$id ";
	$fields="em_actions.id, em_actions.name, em_actions.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$actions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$actions->fetchObject;

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
	
	
$page_title="Actions ";
include "addactions.php";
?>