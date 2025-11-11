<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Chemicals_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8709";//Edit
}
else{
	$auth->roleid="8707";//Add
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
	$chemicals=new Chemicals();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$chemicals->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$chemicals=$chemicals->setObject($obj);
		if($chemicals->add($chemicals)){
			$error=SUCCESS;
			redirect("addchemicals_proc.php?id=".$chemicals->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$chemicals=new Chemicals();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$chemicals->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$chemicals=$chemicals->setObject($obj);
		if($chemicals->edit($chemicals)){
			$error=UPDATESUCCESS;
			redirect("addchemicals_proc.php?id=".$chemicals->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$chemicals=new Chemicals();
	$where=" where id=$id ";
	$fields="prod_chemicals.id, prod_chemicals.name, prod_chemicals.remarks, prod_chemicals.ipaddress, prod_chemicals.createdby, prod_chemicals.createdon, prod_chemicals.lasteditedby, prod_chemicals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$chemicals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$chemicals->fetchObject;

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
	
	
$page_title="Chemicals ";
include "addchemicals.php";
?>