<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationmixtures_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/irrigations/Irrigations_class.php");
require_once("../../prod/irrigationtanks/Irrigationtanks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9213";//Edit
}
else{
	$auth->roleid="9213";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->irrigationid))
  $obj->irrigationid=$ob->irrigationid;

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
	$irrigationmixtures=new Irrigationmixtures();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$irrigationmixtures->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationmixtures=$irrigationmixtures->setObject($obj);
		if($irrigationmixtures->add($irrigationmixtures)){
			$error=SUCCESS;
			redirect("addirrigationmixtures_proc.php?id=".$irrigationmixtures->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$irrigationmixtures=new Irrigationmixtures();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$irrigationmixtures->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationmixtures=$irrigationmixtures->setObject($obj);
		if($irrigationmixtures->edit($irrigationmixtures)){
			$error=UPDATESUCCESS;
			redirect("addirrigationmixtures_proc.php?id=".$irrigationmixtures->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$irrigations= new Irrigations();
	$fields="prod_irrigations.id, prod_irrigations.irrigationdate, prod_irrigations.remarks, prod_irrigations.ipaddress, prod_irrigations.createdby, prod_irrigations.createdon, prod_irrigations.lasteditedby, prod_irrigations.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigations->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$tanks= new IrrigationTanks();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$irrigationmixtures=new Irrigationmixtures();
	$where=" where id=$id ";
	$fields="prod_irrigationmixtures.id, prod_irrigationmixtures.irrigationid, prod_irrigationmixtures.tankid, prod_irrigationmixtures.water, prod_irrigationmixtures.ec, prod_irrigationmixtures.ph, prod_irrigationmixtures.remarks, prod_irrigationmixtures.ipaddress, prod_irrigationmixtures.createdby, prod_irrigationmixtures.createdon, prod_irrigationmixtures.lasteditedby, prod_irrigationmixtures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationmixtures->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$irrigationmixtures->fetchObject;

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
	
	
$page_title="Irrigationmixtures ";
include "addirrigationmixtures.php";
?>