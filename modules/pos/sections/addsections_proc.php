<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="725";//Edit
}
else{
	$auth->roleid="723";//Add
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
	$sections=new Sections();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$sections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sections=$sections->setObject($obj);
		if($sections->add($sections)){
			$error=SUCCESS;
			redirect("addsections_proc.php?id=".$sections->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sections=new Sections();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sections=$sections->setObject($obj);
		if($sections->edit($sections)){
			$error=UPDATESUCCESS;
			redirect("addsections_proc.php?id=".$sections->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$sections=new Sections();
	$where=" where id=$id ";
	$fields="inv_sections.id, inv_sections.section, inv_sections.code, inv_sections.description, inv_sections.createdby, inv_sections.createdon, inv_sections.lasteditedby, inv_sections.lasteditedon, inv_sections.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sections->fetchObject;

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
	
	
$page_title="Sections ";
include "addsections.php";
?>