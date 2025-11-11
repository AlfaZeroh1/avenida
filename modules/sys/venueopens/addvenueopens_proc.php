<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Venueopens_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="166";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="164";//Add
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
	$venueopens=new Venueopens();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$venueopens->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$venueopens=$venueopens->setObject($obj);
		if($venueopens->add($venueopens)){
			$error=SUCCESS;
			redirect("addvenueopens_proc.php?id=".$venueopens->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$venueopens=new Venueopens();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$venueopens->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$venueopens=$venueopens->setObject($obj);
		if($venueopens->edit($venueopens)){
			$error=UPDATESUCCESS;
			redirect("addvenueopens_proc.php?id=".$venueopens->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$venueopens=new Venueopens();
	$where=" where id=$id ";
	$fields="sys_venueopens.id, sys_venueopens.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$venueopens->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$venueopens->fetchObject;

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
	
	
$page_title="Venueopens ";
include "addvenueopens.php";
?>