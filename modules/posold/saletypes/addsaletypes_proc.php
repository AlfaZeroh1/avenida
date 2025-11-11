<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saletypes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9066";//Edit
}
else{
	$auth->roleid="9064";//Add
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
	$saletypes=new Saletypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$saletypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$saletypes=$saletypes->setObject($obj);
		if($saletypes->add($saletypes)){
			
			$error=SUCCESS;
			redirect("addsaletypes_proc.php?id=".$saletypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$saletypes=new Saletypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$saletypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$saletypes=$saletypes->setObject($obj);
		if($saletypes->edit($saletypes)){
			$error=UPDATESUCCESS;
			redirect("addsaletypes_proc.php?id=".$saletypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$saletypes= new Saletypes();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saletypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$saletypes=new Saletypes();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saletypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$saletypes->fetchObject;

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
	
	
$page_title="Saletypes ";
include "addsaletypes.php";
?>