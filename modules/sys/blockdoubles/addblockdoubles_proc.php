<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Blockdoubles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="118";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="116";//Add
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
	$blockdoubles=new Blockdoubles();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$blockdoubles->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$blockdoubles=$blockdoubles->setObject($obj);
		if($blockdoubles->add($blockdoubles)){
			$error=SUCCESS;
			redirect("addblockdoubles_proc.php?id=".$blockdoubles->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$blockdoubles=new Blockdoubles();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$blockdoubles->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$blockdoubles=$blockdoubles->setObject($obj);
		if($blockdoubles->edit($blockdoubles)){
			$error=UPDATESUCCESS;
			redirect("addblockdoubles_proc.php?id=".$blockdoubles->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$blockdoubles=new Blockdoubles();
	$where=" where id=$id ";
	$fields="sys_blockdoubles.id, sys_blockdoubles.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blockdoubles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$blockdoubles->fetchObject;

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
	
	
$page_title="Blockdoubles ";
include "addblockdoubles.php";
?>