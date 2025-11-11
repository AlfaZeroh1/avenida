<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeereliefs_class.php");
require_once("../reliefs/Reliefs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1159";//Edit
}
else{
	$auth->roleid="1157";//Add
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
	$employeereliefs=new Employeereliefs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeereliefs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeereliefs=$employeereliefs->setObject($obj);
		if($employeereliefs->add($employeereliefs)){
			$error=SUCCESS;
			redirect("addemployeereliefs_proc.php?id=".$employeereliefs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeereliefs=new Employeereliefs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeereliefs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeereliefs=$employeereliefs->setObject($obj);
		if($employeereliefs->edit($employeereliefs)){
			$error=UPDATESUCCESS;
			redirect("addemployeereliefs_proc.php?id=".$employeereliefs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeereliefs=new Employeereliefs();
	$where=" where id=$id ";
	$fields="hrm_employeereliefs.id, hrm_employeereliefs.reliefid, hrm_employeereliefs.employeeid, hrm_employeereliefs.percent, hrm_employeereliefs.premium, hrm_employeereliefs.amount, hrm_employeereliefs.month, hrm_employeereliefs.year, hrm_employeereliefs.createdby, hrm_employeereliefs.createdon, hrm_employeereliefs.lasteditedby, hrm_employeereliefs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeereliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeereliefs->fetchObject;

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
	
	
$page_title="Employeereliefs ";
include "addemployeereliefs.php";
?>