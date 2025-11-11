<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Terms_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="158";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="156";//Add
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
	$terms=new Terms();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$terms->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$terms=$terms->setObject($obj);
		if($terms->add($terms)){
			$error=SUCCESS;
			redirect("addterms_proc.php?id=".$terms->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$terms=new Terms();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$terms->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$terms=$terms->setObject($obj);
		if($terms->edit($terms)){
			$error=UPDATESUCCESS;
			redirect("addterms_proc.php?id=".$terms->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$terms=new Terms();
	$where=" where id=$id ";
	$fields="sys_terms.id, sys_terms.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$terms->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$terms->fetchObject;

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
	
	
$page_title="Terms ";
include "addterms.php";
?>