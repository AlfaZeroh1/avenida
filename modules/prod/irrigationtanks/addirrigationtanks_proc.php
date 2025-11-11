<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationtanks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9221";//Edit
}
else{
	$auth->roleid="9221";//Add
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
	$irrigationtanks=new Irrigationtanks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$irrigationtanks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationtanks=$irrigationtanks->setObject($obj);
		if($irrigationtanks->add($irrigationtanks)){
			$error=SUCCESS;
			redirect("addirrigationtanks_proc.php?id=".$irrigationtanks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$irrigationtanks=new Irrigationtanks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$irrigationtanks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationtanks=$irrigationtanks->setObject($obj);
		if($irrigationtanks->edit($irrigationtanks)){
			$error=UPDATESUCCESS;
			redirect("addirrigationtanks_proc.php?id=".$irrigationtanks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$irrigationtanks=new Irrigationtanks();
	$where=" where id=$id ";
	$fields="prod_irrigationtanks.id, prod_irrigationtanks.name, prod_irrigationtanks.remarks, prod_irrigationtanks.ipaddress, prod_irrigationtanks.createdby, prod_irrigationtanks.createdon, prod_irrigationtanks.lasteditedby, prod_irrigationtanks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationtanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$irrigationtanks->fetchObject;

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
	
	
$page_title="Irrigationtanks ";
include "addirrigationtanks.php";
?>