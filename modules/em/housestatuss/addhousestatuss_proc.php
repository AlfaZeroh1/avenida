<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housestatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4113";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4111";//Add
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
	$housestatuss=new Housestatuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$housestatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housestatuss=$housestatuss->setObject($obj);
		if($housestatuss->add($housestatuss)){
			$error=SUCCESS;
			redirect("addhousestatuss_proc.php?id=".$housestatuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$housestatuss=new Housestatuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$housestatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housestatuss=$housestatuss->setObject($obj);
		if($housestatuss->edit($housestatuss)){
			$error=UPDATESUCCESS;
			redirect("addhousestatuss_proc.php?id=".$housestatuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$housestatuss=new Housestatuss();
	$where=" where id=$id ";
	$fields="em_housestatuss.id, em_housestatuss.name, em_housestatuss.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$housestatuss->fetchObject;

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
	
	
$page_title="Housestatuss ";
include "addhousestatuss.php";
?>