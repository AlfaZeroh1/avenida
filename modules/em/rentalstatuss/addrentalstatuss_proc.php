<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rentalstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4149";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4147";//Add
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
	$rentalstatuss=new Rentalstatuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$rentalstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rentalstatuss=$rentalstatuss->setObject($obj);
		if($rentalstatuss->add($rentalstatuss)){
			$error=SUCCESS;
			redirect("addrentalstatuss_proc.php?id=".$rentalstatuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$rentalstatuss=new Rentalstatuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$rentalstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rentalstatuss=$rentalstatuss->setObject($obj);
		if($rentalstatuss->edit($rentalstatuss)){
			$error=UPDATESUCCESS;
			redirect("addrentalstatuss_proc.php?id=".$rentalstatuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$rentalstatuss=new Rentalstatuss();
	$where=" where id=$id ";
	$fields="em_rentalstatuss.id, em_rentalstatuss.name, em_rentalstatuss.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentalstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$rentalstatuss->fetchObject;

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
	
	
$page_title="Rentalstatuss ";
include "addrentalstatuss.php";
?>