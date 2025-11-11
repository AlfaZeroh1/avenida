<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Genders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="134";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="132";//Add
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
	$genders=new Genders();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$genders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$genders=$genders->setObject($obj);
		if($genders->add($genders)){
			$error=SUCCESS;
			redirect("addgenders_proc.php?id=".$genders->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$genders=new Genders();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$genders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$genders=$genders->setObject($obj);
		if($genders->edit($genders)){
			$error=UPDATESUCCESS;
			redirect("addgenders_proc.php?id=".$genders->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$genders=new Genders();
	$where=" where id=$id ";
	$fields="sys_genders.id, sys_genders.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$genders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$genders->fetchObject;

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
	
	
$page_title="Genders ";
include "addgenders.php";
?>