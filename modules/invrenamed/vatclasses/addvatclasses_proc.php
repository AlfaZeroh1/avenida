<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Vatclasses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4747";//Edit
}
else{
	$auth->roleid="4745";//Add
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
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$vatclasses=new Vatclasses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$vatclasses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vatclasses=$vatclasses->setObject($obj);
		if($vatclasses->add($vatclasses)){
			$error=SUCCESS;
			redirect("addvatclasses_proc.php?id=".$vatclasses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$vatclasses=new Vatclasses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$vatclasses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vatclasses=$vatclasses->setObject($obj);
		if($vatclasses->edit($vatclasses)){
			$error=UPDATESUCCESS;
			redirect("addvatclasses_proc.php?id=".$vatclasses->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$vatclasses=new Vatclasses();
	$where=" where id=$id ";
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$vatclasses->fetchObject;

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
	
	
$page_title="Vatclasses ";
include "addvatclasses.php";
?>