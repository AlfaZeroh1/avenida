<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Submodules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/modules/Modules_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9584";//Edit
}
else{
	$auth->roleid="9582";//Add
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
	$submodules=new Submodules();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$submodules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$submodules=$submodules->setObject($obj);
		if($submodules->add($submodules)){
			$error=SUCCESS;
			redirect("addsubmodules_proc.php?id=".$submodules->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$submodules=new Submodules();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$submodules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$submodules=$submodules->setObject($obj);
		if($submodules->edit($submodules)){
			$error=UPDATESUCCESS;
			redirect("addsubmodules_proc.php?id=".$submodules->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$modules= new Modules();
	$fields="sys_modules.id, sys_modules.name, sys_modules.description, sys_modules.url, sys_modules.position, sys_modules.status, sys_modules.indx";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$submodules=new Submodules();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$submodules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$submodules->fetchObject;

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
$where=" where name='sys_submodules' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addsubmodules.php";
?>