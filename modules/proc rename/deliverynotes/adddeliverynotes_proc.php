<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deliverynotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../deliverynotedetails/Deliverynotedetails_class.php");
require_once("../../proc/deliverynotes/Deliverynotes_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8061";//Edit
}
else{
	$auth->roleid="8059";//Add
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
	$deliverynotes=new Deliverynotes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpdeliverynotes=$_SESSION['shpdeliverynotes'];
	$error=$deliverynotes->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpdeliverynotes)){
		$error="No items in the sale list!";
	}
	else{
		$deliverynotes=$deliverynotes->setObject($obj);
		$deliverynotes->transaction="Delivery";
		if($deliverynotes->add($deliverynotes,$shpdeliverynotes)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$deliverynotes=new Deliverynotes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$deliverynotes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deliverynotes=$deliverynotes->setObject($obj);
		$deliverynotes->transaction="Update";
		$shpdeliverynotes=$_SESSION['shpdeliverynotes'];
		if($deliverynotes->edit($deliverynotes,"",$shpdeliverynotes)){
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
	$shpdeliverynotes=$_SESSION['shpdeliverynotes'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shpdeliverynotes[$it]=array('remarks'=>"$obj->remarks", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'costprice'=>"$obj->costprice", 'quantity'=>"$obj->quantity", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpdeliverynotes']=$shpdeliverynotes;

	$obj->remarks="";
 	$obj->itemid="";
 	$obj->itemname="";
 	$obj->quantity="";
 	$obj->costprice="";
 	$obj->total="";
 }
}

if(empty($obj->action)){

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
	$deliverynotes=new Deliverynotes();
	$where=" where id=$id ";
	$fields="proc_deliverynotes.id, proc_deliverynotes.documentno, proc_deliverynotes.lpono, proc_deliverynotes.projectid, proc_deliverynotes.supplierid, proc_deliverynotes.deliveredon, proc_deliverynotes.remarks, proc_deliverynotes.file, proc_deliverynotes.ipaddress, proc_deliverynotes.createdby, proc_deliverynotes.createdon, proc_deliverynotes.lasteditedby, proc_deliverynotes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$deliverynotes->fetchObject;

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

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$deliverynotes = new Deliverynotes();
		$fields="proc_deliverynotes.id, con_projects.id as projectid, proc_deliverynotes.documentno, inv_items.id as itemid,inv_items.name itemname,  proc_deliverynotedetails.quantity, proc_deliverynotedetails.costprice, proc_deliverynotedetails.total, proc_deliverynotedetails.memo, proc_deliverynotes.documentno, proc_suppliers.id as supplierid, proc_deliverynotes.remarks, proc_deliverynotes.deliveredon, proc_deliverynotes.file, proc_deliverynotes.createdby, proc_deliverynotes.createdon, proc_deliverynotes.lasteditedby, proc_deliverynotes.lasteditedon, proc_deliverynotes.ipaddress";
		$join=" left join proc_deliverynotedetails on proc_deliverynotedetails.deliverynoteid=proc_deliverynotes.id left join inv_items on inv_items.id=proc_deliverynotedetails.itemid left join con_projects on proc_deliverynotes.projectid=con_projects.id  left join proc_suppliers on proc_deliverynotes.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_deliverynotes.documentno='$obj->invoiceno'";
		$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$deliverynotes->result;
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
			$shpdeliverynotes[$it]=array('quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name", 'code'=>"$row->code", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

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
		$_SESSION['shpdeliverynotes']=$shpdeliverynotes;
	}
}

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2)){
      
	if(empty($_GET['raise']))
	  $_SESSION['shpdeliverynotes']="";
	else{
	  
	  $obj=$_SESSION['ob'];
	  $obj->iterator=count($_SESSION['shpdeliverynotes']);
	}
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from proc_deliverynotes"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->deliveredon=date("Y-m-d");	
	
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
	
	
$page_title="Deliverynotes ";
include "adddeliverynotes.php";
?>