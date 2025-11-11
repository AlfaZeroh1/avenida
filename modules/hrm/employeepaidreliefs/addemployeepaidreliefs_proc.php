<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidreliefs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1151";//Edit
}
else{
	$auth->roleid="1149";//Add
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
	$employeepaidreliefs=new Employeepaidreliefs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeepaidreliefs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidreliefs=$employeepaidreliefs->setObject($obj);
		if($employeepaidreliefs->add($employeepaidreliefs)){
			$error=SUCCESS;
			redirect("addemployeepaidreliefs_proc.php?id=".$employeepaidreliefs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeepaidreliefs=new Employeepaidreliefs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeepaidreliefs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidreliefs=$employeepaidreliefs->setObject($obj);
		if($employeepaidreliefs->edit($employeepaidreliefs)){
			$error=UPDATESUCCESS;
			redirect("addemployeepaidreliefs_proc.php?id=".$employeepaidreliefs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeepaidreliefs=new Employeepaidreliefs();
	$where=" where id=$id ";
	$fields="hrm_employeepaidreliefs.id, hrm_employeepaidreliefs.employeeid, hrm_employeepaidreliefs.employeereliefid, hrm_employeepaidreliefs.createdby, hrm_employeepaidreliefs.createdon, hrm_employeepaidreliefs.lasteditedby, hrm_employeepaidreliefs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepaidreliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeepaidreliefs->fetchObject;

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
	
	
$page_title="Employeepaidreliefs ";
include "addemployeepaidreliefs.php";
?>