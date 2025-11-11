<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subdivides_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/items/Items_class.php");
require_once("../../pos/items2/Items2_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2218";//Edit
}
else{
	$auth->roleid="2216";//Add
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
	$subdivides=new Subdivides();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$subdivides->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$subdivides=$subdivides->setObject($obj);
		if($subdivides->add($subdivides)){
			$error=SUCCESS;
			redirect("addsubdivides_proc.php?id=".$subdivides->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$subdivides=new Subdivides();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$subdivides->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$subdivides=$subdivides->setObject($obj);
		if($subdivides->edit($subdivides)){
			$error=UPDATESUCCESS;
			redirect("addsubdivides_proc.php?id=".$subdivides->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items2= new Items2();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items2->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$subdivides=new Subdivides();
	$where=" where id=$id ";
	$fields="pos_subdivides.id, pos_subdivides.itemid, pos_subdivides.newitemid, pos_subdivides.subdividedon, pos_subdivides.remarks, pos_subdivides.memo, pos_subdivides.createdby, pos_subdivides.createdon, pos_subdivides.lasteditedby, pos_subdivides.lasteditedon, pos_subdivides.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subdivides->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$subdivides->fetchObject;

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
	
	
$page_title="Subdivides ";
include "addsubdivides.php";
?>