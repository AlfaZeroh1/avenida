<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Countys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4187";//Edit
}
else{
	$auth->roleid="4185";//Add
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
	$countys=new Countys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$countys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$countys=$countys->setObject($obj);
		if($countys->add($countys)){
			$error=SUCCESS;
			redirect("addcountys_proc.php?id=".$countys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$countys=new Countys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$countys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$countys=$countys->setObject($obj);
		if($countys->edit($countys)){
			$error=UPDATESUCCESS;
			redirect("addcountys_proc.php?id=".$countys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$countys=new Countys();
	$where=" where id=$id ";
	$fields="hrm_countys.id, hrm_countys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$countys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$countys->fetchObject;

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
	
	
$page_title="Countys ";
include "addcountys.php";
?>