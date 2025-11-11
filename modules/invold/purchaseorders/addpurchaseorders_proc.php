<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="709";//Edit
}
else{
	$auth->roleid="707";//Add
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
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_purchaseorders"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->orderedon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$purchaseorders=new Purchaseorders();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shppurchaseorders=$_SESSION['shppurchaseorders'];
	$error=$purchaseorders->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppurchaseorders)){
		$error="No items in the sale list!";
	}
	else{
		$purchaseorders=$purchaseorders->setObject($obj);
		if($purchaseorders->add($purchaseorders,$shppurchaseorders)){
			$error=SUCCESS;
			redirect("addpurchaseorders_proc.php?id=".$purchaseorders->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchaseorders=new Purchaseorders();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchaseorders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchaseorders=$purchaseorders->setObject($obj);
		$shppurchaseorders=$_SESSION['shppurchaseorders'];
		if($purchaseorders->edit($purchaseorders,$shppurchaseorders)){
			$error=UPDATESUCCESS;
			redirect("addpurchaseorders_proc.php?id=".$purchaseorders->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	elseif(empty($obj->itemid)){
		$error="Item must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppurchaseorders=$_SESSION['shppurchaseorders'];


	;
	$shppurchaseorders[$it]=array('quantity'=>"$obj->quantity", 'itemid'=>"$obj->itemid", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppurchaseorders']=$shppurchaseorders;

	$obj->quantity="";
 	$obj->itemid="";
 	$obj->code="";
 	$obj->tax="";
 	$obj->costprice="";
 	$obj->tradeprice="";
 	$obj->total=0;
	$obj->remarks="";
 }
}

if(empty($obj->action)){
}

if(!empty($id)){
	$purchaseorders=new Purchaseorders();
	$where=" where id=$id ";
	$fields="inv_purchaseorders.id, inv_purchaseorders.itemid, inv_purchaseorders.documentno, inv_purchaseorders.requisionno, inv_purchaseorders.supplierid, inv_purchaseorders.remarks, inv_purchaseorders.quantity, inv_purchaseorders.costprice, inv_purchaseorders.tradeprice, inv_purchaseorders.tax, inv_purchaseorders.total, inv_purchaseorders.memo, inv_purchaseorders.orderedon, inv_purchaseorders.createdby, inv_purchaseorders.createdon, inv_purchaseorders.lasteditedby, inv_purchaseorders.lasteditedon, inv_purchaseorders.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchaseorders->fetchObject;

	//for autocompletes
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
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
	
	
$page_title="Purchaseorders ";
include "addpurchaseorders.php";
?>