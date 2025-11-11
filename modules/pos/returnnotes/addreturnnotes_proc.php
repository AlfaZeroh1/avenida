<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnnotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/suppliers/Suppliers_class.php");
require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4852";//Edit
}
else{
	$auth->roleid="4850";//Add
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
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_returnnotes"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->returnedon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$returnnotes=new Returnnotes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpreturnnotes=$_SESSION['shpreturnnotes'];
	$error=$returnnotes->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpreturnnotes)){
		$error="No items in the sale list!";
	}
	else{
		$returnnotes=$returnnotes->setObject($obj);
		if($returnnotes->add($returnnotes,$shpreturnnotes)){
			$error=SUCCESS;
			redirect("addreturnnotes_proc.php?id=".$returnnotes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returnnotes=new Returnnotes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returnnotes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returnnotes=$returnnotes->setObject($obj);
		$shpreturnnotes=$_SESSION['shpreturnnotes'];
		if($returnnotes->edit($returnnotes,$shpreturnnotes)){
			$error=UPDATESUCCESS;
			redirect("addreturnnotes_proc.php?id=".$returnnotes->id."&error=".$error);
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
	$shpreturnnotes=$_SESSION['shpreturnnotes'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shpreturnnotes[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity", 'costprice'=>"$obj->costprice", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'total'=>"$obj->total", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpreturnnotes']=$shpreturnnotes;

	$obj->itemname="";
 	$obj->itemid="";
 	$obj->total=0;
	$obj->quantity="";
 	$obj->costprice="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->total="";
 	$obj->remarks="";
 }

if(empty($obj->action)){

	$suppliers= new Suppliers();
	$fields="fn_suppliers.id, fn_suppliers.code, fn_suppliers.name, fn_suppliers.contact, fn_suppliers.physicaladdress, fn_suppliers.tel, fn_suppliers.fax, fn_suppliers.email, fn_suppliers.cellphone, fn_suppliers.status, fn_suppliers.createdby, fn_suppliers.createdon, fn_suppliers.lasteditedby, fn_suppliers.lasteditedon, fn_suppliers.suppliercategoryid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$purchasemodes= new Purchasemodes();
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$returnnotes=new Returnnotes();
	$where=" where id=$id ";
	$fields="inv_returnnotes.id, inv_returnnotes.supplierid, inv_returnnotes.documentno, inv_returnnotes.purchaseno, inv_returnnotes.purchasemodeid, inv_returnnotes.itemid, inv_returnnotes.quantity, inv_returnnotes.costprice, inv_returnnotes.tax, inv_returnnotes.discount, inv_returnnotes.total, inv_returnnotes.returnedon, inv_returnnotes.memo, inv_returnnotes.remarks, inv_returnnotes.createdby, inv_returnnotes.createdon, inv_returnnotes.lasteditedby, inv_returnnotes.lasteditedon, inv_returnnotes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnnotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returnnotes->fetchObject;

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
	
	
$page_title="Returnnotes ";
include "addreturnnotes.php";
?>