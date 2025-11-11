<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nationalitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4207";//Edit
}
else{
	$auth->roleid="4205";//Add
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
	$nationalitys=new Nationalitys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$nationalitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nationalitys=$nationalitys->setObject($obj);
		if($nationalitys->add($nationalitys)){
			$error=SUCCESS;
			redirect("addnationalitys_proc.php?id=".$nationalitys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$nationalitys=new Nationalitys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$nationalitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$nationalitys=$nationalitys->setObject($obj);
		if($nationalitys->edit($nationalitys)){
			$error=UPDATESUCCESS;
			redirect("addnationalitys_proc.php?id=".$nationalitys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$nationalitys=new Nationalitys();
	$where=" where id=$id ";
	$fields="hrm_nationalitys.id, hrm_nationalitys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$nationalitys->fetchObject;

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
	
	
$page_title="Nationalitys ";
include "addnationalitys.php";
?>