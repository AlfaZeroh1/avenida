<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationfetilizers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/fertilizers/Fertilizers_class.php");
require_once("../../prod/irrigations/Irrigations_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9100";//Edit
}
else{
	$auth->roleid="9098";//Add
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
	$irrigationfetilizers=new Irrigationfetilizers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$irrigationfetilizers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationfetilizers=$irrigationfetilizers->setObject($obj);
		if($irrigationfetilizers->add($irrigationfetilizers)){
			$error=SUCCESS;
			redirect("addirrigationfetilizers_proc.php?id=".$irrigationfetilizers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$irrigationfetilizers=new Irrigationfetilizers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$irrigationfetilizers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationfetilizers=$irrigationfetilizers->setObject($obj);
		if($irrigationfetilizers->edit($irrigationfetilizers)){
			$error=UPDATESUCCESS;
			redirect("addirrigationfetilizers_proc.php?id=".$irrigationfetilizers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$fertilizers= new Fertilizers();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fertilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$irrigations= new Irrigations();
	$fields="prod_irrigations.id, prod_irrigations.irrigationdate, prod_irrigations.remarks, prod_irrigations.ipaddress, prod_irrigations.createdby, prod_irrigations.createdon, prod_irrigations.lasteditedby, prod_irrigations.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigations->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$irrigationfetilizers=new Irrigationfetilizers();
	$where=" where id=$id ";
	$fields="prod_irrigationfetilizers.id, prod_irrigationfetilizers.irrigationid, prod_irrigationfetilizers.fertilizerid, prod_irrigationfetilizers.amount, prod_irrigationfetilizers.remarks, prod_irrigationfetilizers.ipaddress, prod_irrigationfetilizers.createdby, prod_irrigationfetilizers.createdon, prod_irrigationfetilizers.lasteditedby, prod_irrigationfetilizers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationfetilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$irrigationfetilizers->fetchObject;

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
	
	
$page_title="Irrigationfetilizers ";
include "addirrigationfetilizers.php";
?>