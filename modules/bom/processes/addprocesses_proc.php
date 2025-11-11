<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Processes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../bom/estimations/Estimations_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="12614";//Edit
}
else{
	$auth->roleid="12614";//Add
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
	$processes=new Processes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$processes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$processes=$processes->setObject($obj);
		if($processes->add($processes)){
			$error=SUCCESS;
			redirect("addprocesses_proc.php?id=".$processes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$processes=new Processes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$processes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$processes=$processes->setObject($obj);
		if($processes->edit($processes)){
			$error=UPDATESUCCESS;
			redirect("addprocesses_proc.php?id=".$processes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$estimations= new Estimations();
	$fields="bom_estimations.id, bom_estimations.name, bom_estimations.itemid, bom_estimations.prc, bom_estimations.createdby, bom_estimations.createdon, bom_estimations.lasteditedby, bom_estimations.lasteditedon, bom_estimations.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimations->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$processes=new Processes();
	$where=" where id=$id ";
	$fields="bom_processes.id, bom_processes.estimationid, bom_processes.processedon, bom_processes.quantity, bom_processes.actual, bom_processes.remarks, bom_processes.ipaddress, bom_processes.createdby, bom_processes.createdon, bom_processes.lasteditedby, bom_processes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$processes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$processes->fetchObject;

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
$where=" where name='bom_processes' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addprocesses.php";
?>