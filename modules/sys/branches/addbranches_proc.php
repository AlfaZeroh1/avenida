<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Branches_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9487";//Edit
}
else{
	$auth->roleid="9485";//Add
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
	$branches=new Branches();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$branches->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branches=$branches->setObject($obj);
		if($branches->add($branches)){
			$error=SUCCESS;
			
			$items=new Items();
			$where=" ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($items->result)){
			      $branchstocks = new Branchstocks();
			      $obj->brancheid=$branches->id;
			      $obj->itemid=$rw->id;	
			      $obj->quantity=0;
			      $ob=$branchstocks->setObject($obj);
			      $branchstocks->add($ob);
			}
				
			redirect("addbranches_proc.php?id=".$branches->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$branches=new Branches();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$branches->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branches=$branches->setObject($obj);
		if($branches->edit($branches)){
			$error=UPDATESUCCESS;
			redirect("addbranches_proc.php?id=".$branches->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$branches=new Branches();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$branches->fetchObject;

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
$where=" where name='sys_branches' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addbranches.php";
?>