<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Blocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8557";//Edit
}
else{
	$auth->roleid="8555";//Add
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
	$blocks=new Blocks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$blocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$blocks=$blocks->setObject($obj);
		if($blocks->add($blocks)){
			$error=SUCCESS;
			redirect("addblocks_proc.php?id=".$blocks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$blocks=new Blocks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$blocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$blocks=$blocks->setObject($obj);
		if($blocks->edit($blocks)){
			$error=UPDATESUCCESS;
			redirect("addblocks_proc.php?id=".$blocks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$blocks=new Blocks();
	$where=" where id=$id ";
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$blocks->fetchObject;

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
	
	
$page_title="Blocks ";
include "addblocks.php";
?>