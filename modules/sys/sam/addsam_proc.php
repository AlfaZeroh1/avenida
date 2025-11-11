<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Sam_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/branches/Branches_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="12472";//Edit
}
else{
	$auth->roleid="12472";//Add
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
	$sam=new Sam();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$sam->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sam=$sam->setObject($obj);
		if($sam->add($sam)){
			$error=SUCCESS;
			redirect("addsam_proc.php?id=".$sam->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sam=new Sam();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sam->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sam=$sam->setObject($obj);
		if($sam->edit($sam)){
			$error=UPDATESUCCESS;
			redirect("addsam_proc.php?id=".$sam->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$sam=new Sam();
	$where=" where id=$id ";
	$fields="sys_sam.id, sys_sam.firstname, sys_sam.othernames, sys_sam.address, sys_sam.brancheid, sys_sam.ipaddress, sys_sam.createdby, sys_sam.createdon, sys_sam.lasteditedby, sys_sam.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sam->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sam->fetchObject;

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
$where=" where name='sys_sam' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addsam.php";
?>