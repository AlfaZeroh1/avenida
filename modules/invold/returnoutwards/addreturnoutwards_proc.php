<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnoutwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../inv/stores/Stores_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../returnoutwarddetails/Returnoutwarddetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../inv/returnoutwards/Returnoutwards_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="721";//Edit
}
else{
	$auth->roleid="719";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$types=$_GET['types'];
if(!empty($types)){
	$obj->types=$types;
}

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
			unset($_SESSION['shpreturnoutwards']);
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
			$error=UPDATESUCCESS;
			redirect("addreturnoutwards_proc.php?id=".$returnoutwards->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	$_SESSION['obj']=$obj;
	$num=count($_SESSION['shpreturnoutwards']);
	if($num==0)
		$it=0;
	else
		$it=$num;
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
	$shpreturnoutwards[$it]=array('quantity'=>"$ob->quantity", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'assetid'=>"$ob->assetid", 'assetname'=>"$ob->assetname", 'code'=>"$ob->code", 'vatclasseid'=>"$ob->vatclasseid", 'tax'=>"$ob->tax", 'costprice'=>"$ob->costprice", 'tradeprice'=>"$ob->tradeprice", 'discount'=>"$ob->discount", 'remarks'=>"$ob->remarks",'vatamount'=>"$ob->vatamount", 'total'=>"$total",'ttotal'=>"$ob->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpreturnoutwards']=$shpreturnoutwards;//print_r($_SESSION['shpreturnoutwards']);

	$obj->itemid="";
 	$obj->quantity="";
 	$obj->costprice="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->total="";
 	$obj->remarks="";
 }

if(empty($obj->action)){

	$purchasemodes= new Purchasemodes();
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$stores= new Stores();
	$fields="inv_stores.id, inv_stores.name, inv_stores.remarks, inv_stores.ipaddress, inv_stores.createdby, inv_stores.createdon, inv_stores.lasteditedby, inv_stores.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$stores->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$returnoutwards=new Returnoutwards();
	$where=" where id=$id ";
	$fields="inv_returnoutwards.id, inv_returnoutwards.supplierid, inv_returnoutwards.storeid, inv_returnoutwards.documentno, inv_returnoutwards.purchaseno, inv_returnoutwards.purchasemodeid, inv_returnoutwards.returnedon, inv_returnoutwards.memo, inv_returnoutwards.remarks, inv_returnoutwards.createdby, inv_returnoutwards.createdon, inv_returnoutwards.lasteditedby, inv_returnoutwards.lasteditedon, inv_returnoutwards.ipaddress, inv_returnoutwards.projectid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnoutwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returnoutwards->fetchObject;

	//for autocompletes
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
	$projects = new Projects();
	$fields=" * ";
	$where=" where id='$obj->projectid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$projects->fetchObject;

	$obj->projectname=$auto->name;
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
	        $defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_returnoutwards"));
		  if($defs->documentno == null){
			  $defs->documentno=1;
		  }
		  $obj->documentno=$defs->documentno;
		  $obj->returnedon=date('Y-m-d');
		  $obj=$_SESSION['ob'];//print_r($obj);
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