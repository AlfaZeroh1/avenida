<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Systemtasks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7460";//Edit
}
else{
	$auth->roleid="7458";//Add
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
	$systemtasks=new Systemtasks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$systemtasks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$systemtasks=$systemtasks->setObject($obj);
		if($systemtasks->add($systemtasks)){
			$error=SUCCESS;
			redirect("addsystemtasks_proc.php?id=".$systemtasks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$systemtasks=new Systemtasks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$systemtasks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$systemtasks=$systemtasks->setObject($obj);
		if($systemtasks->edit($systemtasks)){
			$error=UPDATESUCCESS;
			redirect("addsystemtasks_proc.php?id=".$systemtasks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$systemtasks=new Systemtasks();
	$where=" where id=$id ";
	$fields="wf_systemtasks.id, wf_systemtasks.name, wf_systemtasks.action, wf_systemtasks.remarks, wf_systemtasks.ipaddress, wf_systemtasks.createdby, wf_systemtasks.createdon, wf_systemtasks.lasteditedby, wf_systemtasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$systemtasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$systemtasks->fetchObject;

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
	
	
$page_title="Systemtasks ";
include "addsystemtasks.php";
?>