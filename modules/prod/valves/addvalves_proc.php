<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Valves_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/irrigationsystems/Irrigationsystems_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9235";//Edit
}
else{
	$auth->roleid="9233";//Add
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
	$valves=new Valves();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$valves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$valves=$valves->setObject($obj);
		if($valves->add($valves)){
			$error=SUCCESS;
			redirect("addvalves_proc.php?id=".$valves->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$valves=new Valves();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$valves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$valves=$valves->setObject($obj);
		if($valves->edit($valves)){
			$error=UPDATESUCCESS;
			redirect("addvalves_proc.php?id=".$valves->id."&error=".$error);
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


	$greenhouses= new Greenhouses();
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$valves=new Valves();
	$where=" where id=$id ";
	$fields="prod_valves.id, prod_valves.name, prod_valves.systemid, prod_valves.greenhouseid, prod_valves.remarks, prod_valves.ipaddress, prod_valves.createdby, prod_valves.createdon, prod_valves.lasteditedby, prod_valves.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$valves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$valves->fetchObject;

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
	
	
$page_title="Valves ";
include "addvalves.php";
?>