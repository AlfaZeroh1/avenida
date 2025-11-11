<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Tests_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11340";//Edit
}
else{
	$auth->roleid="11340";//Add
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
	$tests=new Tests();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tests->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tests=$tests->setObject($obj);
		if($tests->add($tests)){
			$error=SUCCESS;
			redirect("addtests_proc.php?id=".$tests->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tests=new Tests();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tests->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tests=$tests->setObject($obj);
		if($tests->edit($tests)){
			$error=UPDATESUCCESS;
			redirect("addtests_proc.php?id=".$tests->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$tests=new Tests();
	$where=" where id=$id ";
	$fields="hos_tests.id, hos_tests.name, hos_tests.remarks, hos_tests.ipaddres, hos_tests.createdby, hos_tests.createdon, hos_tests.lasteditedby, hos_tests.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tests->fetchObject;

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
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hos_tests' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addtests.php";
?>