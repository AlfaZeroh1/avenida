<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teampositions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9051";//Edit
}
else{
	$auth->roleid="9051";//Add
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
	$teampositions=new Teampositions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teampositions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teampositions=$teampositions->setObject($obj);
		if($teampositions->add($teampositions)){
			$error=SUCCESS;
			redirect("addteampositions_proc.php?id=".$teampositions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teampositions=new Teampositions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teampositions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teampositions=$teampositions->setObject($obj);
		if($teampositions->edit($teampositions)){
			$error=UPDATESUCCESS;
			redirect("addteampositions_proc.php?id=".$teampositions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$teampositions=new Teampositions();
	$where=" where id=$id ";
	$fields="pm_teampositions.id, pm_teampositions.name, pm_teampositions.remarks, pm_teampositions.ipaddress, pm_teampositions.createdby, pm_teampositions.createdon, pm_teampositions.lasteditedby, pm_teampositions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teampositions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$teampositions->fetchObject;

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
	
	
$page_title="Teampositions ";
include "addteampositions.php";
?>