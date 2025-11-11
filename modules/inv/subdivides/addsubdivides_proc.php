<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subdivides_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4856";//Edit
}
else{
	$auth->roleid="4854";//Add
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
	$shpsubdivides=$_SESSION['shpsubdivides'];
	$error=$subdivides->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpsubdivides)){
		$error="No items in the sale list!";
	}
	else{
		$subdivides=$subdivides->setObject($obj);
		if($subdivides->add($subdivides,$shpsubdivides)){
			$error=SUCCESS;
			$saved="Yes";
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
		$shpsubdivides=$_SESSION['shpsubdivides'];
		if($subdivides->edit($subdivides,$shpsubdivides)){
			$error=UPDATESUCCESS;
			redirect("addsubdivides_proc.php?id=".$subdivides->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpsubdivides=$_SESSION['shpsubdivides'];


	;
	$shpsubdivides[$it]=array('total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpsubdivides']=$shpsubdivides;

}

if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
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
	$fields="inv_subdivides.id, inv_subdivides.documentno, inv_subdivides.itemid, inv_subdivides.newitemid, inv_subdivides.subdividedon, inv_subdivides.type, inv_subdivides.remarks, inv_subdivides.memo, inv_subdivides.createdby, inv_subdivides.createdon, inv_subdivides.lasteditedby, inv_subdivides.lasteditedon, inv_subdivides.ipaddress";
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