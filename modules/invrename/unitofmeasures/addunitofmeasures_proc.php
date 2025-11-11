<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Unitofmeasures_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="737";//Edit
}
else{
	$auth->roleid="735";//Add
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
	$unitofmeasures=new Unitofmeasures();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$unitofmeasures->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$unitofmeasures=$unitofmeasures->setObject($obj);
		if($unitofmeasures->add($unitofmeasures)){
			$error=SUCCESS;
			redirect("addunitofmeasures_proc.php?id=".$unitofmeasures->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$unitofmeasures=new Unitofmeasures();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$unitofmeasures->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$unitofmeasures=$unitofmeasures->setObject($obj);
		if($unitofmeasures->edit($unitofmeasures)){
			$error=UPDATESUCCESS;
			redirect("addunitofmeasures_proc.php?id=".$unitofmeasures->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$unitofmeasures=new Unitofmeasures();
	$where=" where id=$id ";
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$unitofmeasures->fetchObject;

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
	
	
$page_title="Unitofmeasures ";
include "addunitofmeasures.php";
?>