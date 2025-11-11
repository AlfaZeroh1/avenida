<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Branchteams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/teamroles/Teamroles_class.php");
require_once("../../sys/branches/Branches_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11959";//Edit
}
else{
	$auth->roleid="11959";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
}

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
	$branchteams=new Branchteams();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$branchteams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branchteams=$branchteams->setObject($obj);
		if($branchteams->add($branchteams)){
			$error=SUCCESS;
			redirect("addbranchteams_proc.php?id=".$branchteams->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$branchteams=new Branchteams();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$branchteams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branchteams=$branchteams->setObject($obj);
		if($branchteams->edit($branchteams)){
			$error=UPDATESUCCESS;
			redirect("addbranchteams_proc.php?id=".$branchteams->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$teamroles= new Teamroles();
	$fields="pos_teamroles.id, pos_teamroles.name, pos_teamroles.type, pos_teamroles.remarks, pos_teamroles.ipaddress, pos_teamroles.createdby, pos_teamroles.createdon, pos_teamroles.lasteditedby, pos_teamroles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$branchteams=new Branchteams();
	$where=" where id=$id ";
	$fields="pos_branchteams.id, pos_branchteams.brancheid, pos_branchteams.teamroleid, pos_branchteams.number, pos_branchteams.createdby, pos_branchteams.createdon, pos_branchteams.lasteditedby, pos_branchteams.lasteditedon, pos_branchteams.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branchteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$branchteams->fetchObject;

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
$where=" where name='pos_branchteams' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addbranchteams.php";
?>