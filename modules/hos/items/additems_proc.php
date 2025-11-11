<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Items_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$items=new Items();
	$where=" where id=$id ";
	$fields="hos_items.id, hos_items.code, hos_items.name, hos_items.manufacturer, hos_items.strength, hos_items.costprice, hos_items.discount, hos_items.tradeprice, hos_items.retailprice, hos_items.applicabletax, hos_items.reorderlevel, hos_items.quantity, hos_items.status, hos_items.expirydate, hos_items.createdby, hos_items.createdon, hos_items.lasteditedby, hos_items.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$items->fetchObject;
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
		$items=new Items();
		$items=setObject($obj);
		if($items->add($items)){
			$error=SUCCESS;
			redirect("additems_proc.php?error=".$error);
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
		$items=new Items();
		$items=setObject($obj);
		if($items->edit($items)){
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
	if(empty($obj->strength)){
		$error="strength should be provided";
	}
	else if(empty($obj->costprice)){
		$error="costprice should be provided";
	}
	else if(empty($obj->discount)){
		$error="discount should be provided";
	}
	else if(empty($obj->tradeprice)){
		$error="tradeprice should be provided";
	}
	else if(empty($obj->retailprice)){
		$error="retailprice should be provided";
	}
	else if(empty($obj->applicabletax)){
		$error="applicabletax should be provided";
	}
	else if(empty($obj->reorderlevel)){
		$error="reorderlevel should be provided";
	}
	else if(empty($obj->quantity)){
		$error="quantity should be provided";
	}
	else if(empty($obj->createdby)){
		$error="createdby should be provided";
	}
	else if(empty($obj->lasteditedby)){
		$error="lasteditedby should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$items= new Items();
		$items->id=str_replace(',','',$obj->id);
		$items->code=str_replace(',','',$obj->code);
		$items->name=str_replace(',','',$obj->name);
		$items->manufacturer=str_replace(',','',$obj->manufacturer);
		$items->strength=str_replace(',','',$obj->strength);
		$items->costprice=str_replace(',','',$obj->costprice);
		$items->discount=str_replace(',','',$obj->discount);
		$items->tradeprice=str_replace(',','',$obj->tradeprice);
		$items->retailprice=str_replace(',','',$obj->retailprice);
		$items->applicabletax=str_replace(',','',$obj->applicabletax);
		$items->reorderlevel=str_replace(',','',$obj->reorderlevel);
		$items->quantity=str_replace(',','',$obj->quantity);
		$items->status=str_replace(',','',$obj->status);
		$items->expirydate=str_replace(',','',$obj->expirydate);
		$items->createdby=str_replace(',','',$obj->createdby);
		$items->createdon=str_replace(',','',$obj->createdon);
		$items->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$items->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $items;
	
}
$page_title="Items";
include "additems.php";
?>