<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktrack_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$stocktrack=new Stocktrack();
	$where=" where id=$id ";
	$fields="hos_stocktrack.id, hos_stocktrack.itemid, hos_stocktrack.tid, hos_stocktrack.batchno, hos_stocktrack.quantity, hos_stocktrack.costprice, hos_stocktrack.value, hos_stocktrack.discount, hos_stocktrack.tradeprice, hos_stocktrack.retailprice, hos_stocktrack.applicabletax, hos_stocktrack.expirydate, hos_stocktrack.recorddate, hos_stocktrack.status, hos_stocktrack.remain, hos_stocktrack.transaction, hos_stocktrack.ipaddress, hos_stocktrack.createdby, hos_stocktrack.createdon, hos_stocktrack.lasteditedby, hos_stocktrack.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$stocktrack->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$stocktrack->fetchObject;
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
		$stocktrack=new Stocktrack();
		$stocktrack=setObject($obj);
		if($stocktrack->add($stocktrack)){
			$error=SUCCESS;
			redirect("addstocktrack_proc.php?error=".$error);
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
		$stocktrack=new Stocktrack();
		$stocktrack=setObject($obj);
		if($stocktrack->edit($stocktrack)){
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
	if(empty($obj->itemid)){
		$error="itemid should be provided";
	}
	else if(empty($obj->quantity)){
		$error="quantity should be provided";
	}
	else if(empty($obj->remain)){
		$error="remain should be provided";
	}
	else if(empty($obj->ipaddress)){
		$error="ipaddress should be provided";
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
		$stocktrack= new Stocktrack();
		$stocktrack->id=str_replace(',','',$obj->id);
		$stocktrack->itemid=str_replace(',','',$obj->itemid);
		$stocktrack->tid=str_replace(',','',$obj->tid);
		$stocktrack->batchno=str_replace(',','',$obj->batchno);
		$stocktrack->quantity=str_replace(',','',$obj->quantity);
		$stocktrack->costprice=str_replace(',','',$obj->costprice);
		$stocktrack->value=str_replace(',','',$obj->value);
		$stocktrack->discount=str_replace(',','',$obj->discount);
		$stocktrack->tradeprice=str_replace(',','',$obj->tradeprice);
		$stocktrack->retailprice=str_replace(',','',$obj->retailprice);
		$stocktrack->applicabletax=str_replace(',','',$obj->applicabletax);
		$stocktrack->expirydate=str_replace(',','',$obj->expirydate);
		$stocktrack->recorddate=str_replace(',','',$obj->recorddate);
		$stocktrack->status=str_replace(',','',$obj->status);
		$stocktrack->remain=str_replace(',','',$obj->remain);
		$stocktrack->transaction=str_replace(',','',$obj->transaction);
		$stocktrack->ipaddress=str_replace(',','',$obj->ipaddress);
		$stocktrack->createdby=str_replace(',','',$obj->createdby);
		$stocktrack->createdon=str_replace(',','',$obj->createdon);
		$stocktrack->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$stocktrack->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $stocktrack;
	
}
$page_title="Stocktrack";
include "addstocktrack.php";
?>