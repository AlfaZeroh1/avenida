<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Continents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8997";//Edit
}
else{
	$auth->roleid="8997";//Add
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
	$continents=new Continents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$continents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$continents=$continents->setObject($obj);
		if($continents->add($continents)){
			$error=SUCCESS;
			redirect("addcontinents_proc.php?id=".$continents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$continents=new Continents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$continents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$continents=$continents->setObject($obj);
		if($continents->edit($continents)){
			$error=UPDATESUCCESS;
			redirect("addcontinents_proc.php?id=".$continents->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$continents=new Continents();
	$where=" where id=$id ";
	$fields="crm_continents.id, crm_continents.name, crm_continents.remarks, crm_continents.ipaddress, crm_continents.createdby, crm_continents.createdon, crm_continents.lasteditedby, crm_continents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$continents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$continents->fetchObject;

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
	
	
$page_title="Continents ";
include "addcontinents.php";
?>