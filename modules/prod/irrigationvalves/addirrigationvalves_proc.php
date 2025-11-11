<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationvalves_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/irrigations/Irrigations_class.php");
require_once("../../prod/valves/Valves_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9225";//Edit
}
else{
	$auth->roleid="9225";//Add
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
	$irrigationvalves=new Irrigationvalves();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$irrigationvalves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationvalves=$irrigationvalves->setObject($obj);
		if($irrigationvalves->add($irrigationvalves)){
			$error=SUCCESS;
			redirect("addirrigationvalves_proc.php?id=".$irrigationvalves->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$irrigationvalves=new Irrigationvalves();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$irrigationvalves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$irrigationvalves=$irrigationvalves->setObject($obj);
		if($irrigationvalves->edit($irrigationvalves)){
			$error=UPDATESUCCESS;
			redirect("addirrigationvalves_proc.php?id=".$irrigationvalves->id."&error=".$error);
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


	$valves= new Valves();
	$fields="prod_valves.id, prod_valves.name, prod_valves.greenhouseid, prod_valves.remarks, prod_valves.ipaddress, prod_valves.createdby, prod_valves.createdon, prod_valves.lasteditedby, prod_valves.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$valves->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$irrigationvalves=new Irrigationvalves();
	$where=" where id=$id ";
	$fields="prod_irrigationvalves.id, prod_irrigationvalves.irrigationid, prod_irrigationvalves.valveid, prod_irrigationvalves.quantity, prod_irrigationvalves.remarks, prod_irrigationvalves.ipaddress, prod_irrigationvalves.createdby, prod_irrigationvalves.createdon, prod_irrigationvalves.lasteditedby, prod_irrigationvalves.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationvalves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$irrigationvalves->fetchObject;

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
	
	
$page_title="Irrigationvalves ";
include "addirrigationvalves.php";
?>