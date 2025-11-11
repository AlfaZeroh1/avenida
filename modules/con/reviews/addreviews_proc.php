<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reviews_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8535";//Edit
}
else{
	$auth->roleid="8535";//Add
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
	$reviews=new Reviews();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$reviews->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$reviews=$reviews->setObject($obj);
		if($reviews->add($reviews)){
			$error=SUCCESS;
			redirect("addreviews_proc.php?id=".$reviews->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$reviews=new Reviews();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$reviews->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$reviews=$reviews->setObject($obj);
		if($reviews->edit($reviews)){
			$error=UPDATESUCCESS;
			redirect("addreviews_proc.php?id=".$reviews->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$reviews=new Reviews();
	$where=" where id=$id ";
	$fields="con_reviews.id, con_reviews.name, con_reviews.ipaddress, con_reviews.createdby, con_reviews.createdon, con_reviews.lasteditedby, con_reviews.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$reviews->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$reviews->fetchObject;

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
	
	
$page_title="Reviews ";
include "addreviews.php";
?>