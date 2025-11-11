<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnoutwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/suppliers/Suppliers_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2198";//Edit
}
else{
	$auth->roleid="2196";//Add
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
	$obj->returnedon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$returnoutwards=new Returnoutwards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpreturnoutwards=$_SESSION['shpreturnoutwards'];
	$error=$returnoutwards->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpreturnoutwards)){
		$error="No items in the sale list!";
	}
	else{
		$returnoutwards=$returnoutwards->setObject($obj);
		if($returnoutwards->add($returnoutwards,$shpreturnoutwards)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returnoutwards=new Returnoutwards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returnoutwards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returnoutwards=$returnoutwards->setObject($obj);
		$shpreturnoutwards=$_SESSION['shpreturnoutwards'];
		if($returnoutwards->edit($returnoutwards,$shpreturnoutwards)){

			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->supplierid' and acctypeid='30'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='28'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
			$error=UPDATESUCCESS;
			redirect("addreturnoutwards_proc.php?id=".$returnoutwards->id."&error=".$error);
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
	$shpreturnoutwards=$_SESSION['shpreturnoutwards'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shpreturnoutwards[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'costprice'=>"$obj->costprice", 'tradeprice'=>"$obj->tradeprice", 'quantity'=>"$obj->quantity", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpreturnoutwards']=$shpreturnoutwards;

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
	$returnoutwards=new Returnoutwards();
	$where=" where id=$id ";
	$fields="pos_returnoutwards.id, pos_returnoutwards.supplierid, pos_returnoutwards.documentno, pos_returnoutwards.creditnoteno, pos_returnoutwards.mode, pos_returnoutwards.itemid, pos_returnoutwards.quantity, pos_returnoutwards.costprice, pos_returnoutwards.tradeprice, pos_returnoutwards.tax, pos_returnoutwards.discount, pos_returnoutwards.total, pos_returnoutwards.returnedon, pos_returnoutwards.memo, pos_returnoutwards.createdby, pos_returnoutwards.createdon, pos_returnoutwards.lasteditedby, pos_returnoutwards.lasteditedon, pos_returnoutwards.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnoutwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returnoutwards->fetchObject;

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
	
	
$page_title="Returnoutwards ";
include "addreturnoutwards.php";
?>