<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Clientbanks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4179";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4177";//Add
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
	$clientbanks=new Clientbanks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$clientbanks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$clientbanks=$clientbanks->setObject($obj);
		if($clientbanks->add($clientbanks)){
			$error=SUCCESS;
			redirect("addclientbanks_proc.php?id=".$clientbanks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$clientbanks=new Clientbanks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$clientbanks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$clientbanks=$clientbanks->setObject($obj);
		if($clientbanks->edit($clientbanks)){
			$error=UPDATESUCCESS;
			redirect("addclientbanks_proc.php?id=".$clientbanks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$clientbanks=new Clientbanks();
	$where=" where id=$id ";
	$fields="em_clientbanks.id, em_clientbanks.name, em_clientbanks.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$clientbanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$clientbanks->fetchObject;

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
	
	
$page_title="Clientbanks ";
include "addclientbanks.php";
?>