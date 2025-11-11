<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/irrigationsystems/Irrigationsystems_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9104";//Edit
}
else{
	$auth->roleid="9102";//Add
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
	$irrigations=new Irrigations();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$irrigations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigations=$irrigations->setObject($obj);
		if($irrigations->add($irrigations)){
			$error=SUCCESS;
			redirect("addirrigations_proc.php?id=".$irrigations->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$irrigations=new Irrigations();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$irrigations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigations=$irrigations->setObject($obj);
		if($irrigations->edit($irrigations)){
			$error=UPDATESUCCESS;
			redirect("addirrigations_proc.php?id=".$irrigations->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$irrigationsystems= new Irrigationsystems();
	$fields="prod_irrigationsystems.id, prod_irrigationsystems.name, prod_irrigationsystems.remarks, prod_irrigationsystems.ipaddress, prod_irrigationsystems.createdby, prod_irrigationsystems.createdon, prod_irrigationsystems.lasteditedby, prod_irrigationsystems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationsystems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$irrigations=new Irrigations();
	$where=" where id=$id ";
	$fields="prod_irrigations.id, prod_irrigations.irrigationsystemid, prod_irrigations.irrigationdate, prod_irrigations.remarks, prod_irrigations.ipaddress, prod_irrigations.createdby, prod_irrigations.createdon, prod_irrigations.lasteditedby, prod_irrigations.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$irrigations->fetchObject;

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
	
	
$page_title="Irrigations ";
include "addirrigations.php";
?>