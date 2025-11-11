<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchases_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/suppliers/Suppliers_class.php");
require_once("../../pos/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2186";//Edit
}
else{
	$auth->roleid="2184";//Add
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
	$obj->boughton=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$purchases=new Purchases();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shppurchases=$_SESSION['shppurchases'];
	$error=$purchases->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppurchases)){
		$error="No items in the sale list!";
	}
	else{
		$purchases=$purchases->setObject($obj);
		if($purchases->add($purchases,$shppurchases)){
			$error=SUCCESS;
			redirect("addpurchases_proc.php?id=".$purchases->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchases=new Purchases();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchases->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchases=$purchases->setObject($obj);
		$shppurchases=$_SESSION['shppurchases'];
		if($purchases->edit($purchases,$shppurchases)){
			$error=UPDATESUCCESS;
			redirect("addpurchases_proc.php?id=".$purchases->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->itemid)){
		$error="Item must be provided";
	}
	elseif(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppurchases=$_SESSION['shppurchases'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shppurchases[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'costprice'=>"$obj->costprice", 'tradeprice'=>"$obj->tradeprice", 'quantity'=>"$obj->quantity", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppurchases']=$shppurchases;

	$obj->itemname="";
 	$obj->itemid="";
 	$obj->code="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->costprice="";
 	$obj->tradeprice="";
 	$obj->total=0;
	$obj->quantity="";
 }
}

if(empty($obj->action)){

	$suppliers= new Suppliers();
	$fields="pos_suppliers.id, pos_suppliers.code, pos_suppliers.name, pos_suppliers.contact, pos_suppliers.address, pos_suppliers.telephone, pos_suppliers.fax, pos_suppliers.email, pos_suppliers.mobile, pos_suppliers.status, pos_suppliers.createdby, pos_suppliers.createdon, pos_suppliers.lasteditedby, pos_suppliers.lasteditedon, pos_suppliers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$purchases=new Purchases();
	$where=" where id=$id ";
	$fields="pos_purchases.id, pos_purchases.itemid, pos_purchases.documentno, pos_purchases.supplierid, pos_purchases.description, pos_purchases.quantity, pos_purchases.costprice, pos_purchases.tradeprice, pos_purchases.discount, pos_purchases.tax, pos_purchases.bonus, pos_purchases.total, pos_purchases.mode, pos_purchases.boughton, pos_purchases.memo, pos_purchases.createdby, pos_purchases.createdon, pos_purchases.lasteditedby, pos_purchases.lasteditedon, pos_purchases.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchases->fetchObject;

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
	
	
$page_title="Purchases ";
include "addpurchases.php";
?>