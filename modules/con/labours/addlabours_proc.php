<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Labours_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8527";//Edit
}
else{
	$auth->roleid="8527";//Add
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
	$labours=new Labours();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$labours->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$labours=$labours->setObject($obj);
		if($labours->add($labours)){
			$error=SUCCESS;
			redirect("addlabours_proc.php?id=".$labours->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$labours=new Labours();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$labours->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$labours=$labours->setObject($obj);
		if($labours->edit($labours)){
			$error=UPDATESUCCESS;
			redirect("addlabours_proc.php?id=".$labours->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$labours=new Labours();
	$where=" where id=$id ";
	$fields="con_labours.id, con_labours.name, con_labours.rate, con_labours.remarks, con_labours.ipaddress, con_labours.createdby, con_labours.createdon, con_labours.lasteditedby, con_labours.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$labours->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$labours->fetchObject;

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
	
	
$page_title="Labours ";
include "addlabours.php";
?>