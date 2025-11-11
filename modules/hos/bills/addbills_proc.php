<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bills_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$bills=new Bills();
	$where=" where id=$id ";
	$fields="hos_bills.id, hos_bills.name, hos_bills.amount, hos_bills.createdby, hos_bills.createdon, hos_bills.lasteditedby, hos_bills.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$bills->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$bills->fetchObject;
}
	
if($obj->action=="Save"){
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bills=new Bills();
		$bills=setObject($obj);
		if($bills->add($bills)){
			$error=SUCCESS;
			redirect("addbills_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bills=new Bills();
		$bills=setObject($obj);
		if($bills->edit($bills)){
			$obj="";
			$error=UPDATESUCCESS;
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->name)){
		$error="name should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$bills= new Bills();
		$bills->id=str_replace(',','',$obj->id);
		$bills->name=str_replace(',','',$obj->name);
		$bills->amount=str_replace(',','',$obj->amount);
		$bills->createdby=str_replace(',','',$obj->createdby);
		$bills->createdon=str_replace(',','',$obj->createdon);
		$bills->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$bills->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $bills;
	
}
$page_title="Bills";
include "addbills.php";
?>