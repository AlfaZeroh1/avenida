<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/locations/Locations_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2178";//Edit
}
else{
	$auth->roleid="2176";//Add
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
	$projects=new Projects();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projects=$projects->setObject($obj);
		if($projects->add($projects)){
			$error=SUCCESS;
			redirect("addprojects_proc.php?id=".$projects->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projects=new Projects();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projects=$projects->setObject($obj);
		if($projects->edit($projects)){
			$error=UPDATESUCCESS;
			redirect("addprojects_proc.php?id=".$projects->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$locations= new Locations();
	$fields="pos_locations.id, pos_locations.name, pos_locations.description, pos_locations.createdby, pos_locations.createdon, pos_locations.lasteditedby, pos_locations.lasteditedon, pos_locations.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$locations->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projects=new Projects();
	$where=" where id=$id ";
	$fields="pos_projects.id, pos_projects.name, pos_projects.locationid, pos_projects.description, pos_projects.createdby, pos_projects.createdon, pos_projects.lasteditedby, pos_projects.lasteditedon, pos_projects.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projects->fetchObject;

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
	
	
$page_title="Projects ";
include "addprojects.php";
?>