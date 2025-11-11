<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../inwarddetails/Inwarddetails_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/projectstocks/Projectstocks_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8065";//Edit
}
else{
	$auth->roleid="8063";//Add
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
	$inwards=new Inwards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpinwards=$_SESSION['shpinwards'];
	$error=$inwards->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpinwards)){
		$error="No items in the sale list!";
	}
	else{
		$inwards=$inwards->setObject($obj);
		if($inwards->add($inwards,$shpinwards)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$inwards=new Inwards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$inwards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inwards=$inwards->setObject($obj);
		$shpinwards=$_SESSION['shpinwards'];
		if($inwards->edit($inwards,"",$shpinwards)){

			
			$error=UPDATESUCCESS;
			$saved="Yes";
			
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->itemid)){
		$error=" must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpinwards=$_SESSION['shpinwards'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shpinwards[$it]=array('memo'=>"$obj->memo", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'costprice'=>"$obj->costprice", 'quantity'=>"$obj->quantity", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpinwards']=$shpinwards;

	$obj->remarks="";
 	$obj->itemid="";
 	$obj->quantity="";
 }
}

if(empty($obj->action)){

	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$inwards=new Inwards();
	$where=" where id=$id ";
	$fields="proc_inwards.id, proc_inwards.documentno, proc_inwards.deliverynoteno, proc_inwards.projectid, proc_inwards.supplierid, proc_inwards.inwarddate, proc_inwards.remarks, proc_inwards.file, proc_inwards.ipaddress, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$inwards->fetchObject;

	//for autocompletes
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

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$inwards = new Inwards();
		$fields="proc_inwards.id, con_projects.id as projectid, proc_inwards.documentno, inv_items.id as itemid,inv_items.name itemname,  proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.memo, proc_inwards.documentno, proc_suppliers.id as supplierid, proc_inwards.remarks, proc_inwards.inwarddate, proc_inwards.file, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon, proc_inwards.ipaddress";
		$join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join inv_items on inv_items.id=proc_inwarddetails.itemid left join con_projects on proc_inwards.projectid=con_projects.id  left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_inwards.documentno='$obj->invoiceno'";
		$inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$inwards->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$items = new Items();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='$row->itemid'";
			$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$items=$items->fetchObject;
	  
			$ob=$row;
			$row->total=$row->quantity*$row->costprice;
			$shpinwards[$it]=array('quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name", 'code'=>"$row->code", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

			$it++;
		}

		//for autocompletes
		$suppliers = new Suppliers();
		$fields=" * ";
		$where=" where id='$ob->supplierid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$suppliers->fetchObject;
		$auto->suppliername=$auto->name;
		
		$projects = new Projects();
		$fields=" * ";
		$where=" where id='$ob->projectid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto2=$projects->fetchObject;
		$auto2->projectname=$auto2->name;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);	
		$obj = (object) array_merge((array) $obj, (array) $auto2);

		$obj->iterator=$it;
		$obj->remarks="";
		$obj->itemid="";
		$obj->itemname="";
		$obj->quantity="";
		$obj->costprice="";
		$obj->total="";
		
		$obj->action="Update";
		
		$_SESSION['obj']=$obj;
		$_SESSION['shpinwards']=$shpinwards;
	}
}
if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
  
      if(empty($obj->action) and empty($obj->action2)){
      
	if(empty($_GET['raise']))
	  $_SESSION['shpinwards']="";
	else{
	  
	  $obj=$_SESSION['ob'];
	  $obj->iterator=count($_SESSION['shpinwards']);
	}
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from proc_inwards"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->inwarddate=date("Y-m-d");	
	
      }
      $obj->action="Save";
  } 
  else{
    $obj=$_SESSION['obj'];
  }
  
}
else{  
    $obj->action="Update";
}
	
if($obj->action3=="New Inward"){
  $grns = $_SESSION['shppurchaseorder'];
  $num = count($grns);
  $i=0;
  $it=0;
  $shpinwards=array();
  $docs="";
  while($i<$num){
    $purchaseorders = new Purchaseorders();
    $fields="proc_purchaseorders.id, proc_purchaseorderdetails.id purchaseorderdetailid, proc_purchaseorders.documentno, inv_items.id as itemid,inv_items.name itemname,  proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.total, proc_purchaseorderdetails.memo, proc_purchaseorders.documentno, proc_suppliers.id as supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
    $join=" left join proc_purchaseorderdetails on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid left join con_projects on proc_purchaseorders.projectid=con_projects.id  left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where proc_purchaseorders.documentno='$grns[$i]'";
    $purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    $res=$purchaseorders->result;
    
    while($row=mysql_fetch_object($res)){
		
	    $docs.=$row->documentno.",";
	    $items = new Items();
	    $fields=" * ";
	    $join="";
	    $groupby="";
	    $having="";
	    $where=" where id='$row->itemid'";
	    $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	    $items=$items->fetchObject;

	    $ob=$row;
	    $row->total=$row->quantity*$row->costprice;
	    $shpinwards[$it]=array('purchaseorderdetailid'=>"$row->purchaseorderdetailid",'quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name", 'code'=>"$row->code", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

	    $it++;
    }
    $i++;
  }
  
  $docs = substr($docs, 0, -1);
  $obj->deliverynoteno=$docs;
  //for autocompletes
  $suppliers = new Suppliers();
  $fields=" * ";
  $where=" where id='$ob->supplierid'";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $auto=$suppliers->fetchObject;
  $auto->suppliername=$auto->name;
  
  $obj->iterator=$it;
  $obj->purchasemodeid=2;
  
  $_SESSION['shpinwards']=$shpinwards;

  $obj = (object) array_merge((array) $obj, (array) $ob);
  $obj = (object) array_merge((array) $obj, (array) $auto);	
}

$page_title="Inwards ";
include "addinwards.php";
?>