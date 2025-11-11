<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Greenhouses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/sections/Sections_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9020";//Edit
}
else{
	$auth->roleid="9018";//Add
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
	$greenhouses=new Greenhouses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$greenhouses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$greenhouses=$greenhouses->setObject($obj);
		if($greenhouses->add($greenhouses)){
			$error=SUCCESS;
			redirect("addgreenhouses_proc.php?id=".$greenhouses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$greenhouses=new Greenhouses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$greenhouses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$greenhouses=$greenhouses->setObject($obj);
		if($greenhouses->edit($greenhouses)){
			$error=UPDATESUCCESS;
			redirect("addgreenhouses_proc.php?id=".$greenhouses->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$sections= new Sections();
	$fields="prod_sections.id, prod_sections.name, prod_sections.blockid, prod_sections.employeeid, prod_sections.remarks, prod_sections.ipaddress, prod_sections.createdby, prod_sections.createdon, prod_sections.lasteditedby, prod_sections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$greenhouses=new Greenhouses();
	$where=" where id=$id ";
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$greenhouses->fetchObject;

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
	
	
$page_title="Greenhouses ";
include "addgreenhouses.php";
?>