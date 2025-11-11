<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Autocomplete_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="114";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="112";//Add
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
	$autocomplete=new Autocomplete();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$autocomplete->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$autocomplete=$autocomplete->setObject($obj);
		if($autocomplete->add($autocomplete)){
			$error=SUCCESS;
			redirect("addautocomplete_proc.php?id=".$autocomplete->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$autocomplete=new Autocomplete();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$autocomplete->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$autocomplete=$autocomplete->setObject($obj);
		if($autocomplete->edit($autocomplete)){
			$error=UPDATESUCCESS;
			redirect("addautocomplete_proc.php?id=".$autocomplete->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$autocomplete=new Autocomplete();
	$where=" where id=$id ";
	$fields="sys_autocomplete.id, sys_autocomplete.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$autocomplete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$autocomplete->fetchObject;

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
	
	
$page_title="Autocomplete ";
include "addautocomplete.php";
?>