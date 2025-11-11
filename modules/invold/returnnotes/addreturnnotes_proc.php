<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnnotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../returnnotedetails/Returnnotedetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/returnnotes/Returnnotes_class.php");
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
			$saved="Yes";
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

	$obj->itemid="";
 	$obj->quantity="";
 	$obj->costprice="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->total="";
 	$obj->remarks="";
 }
 
 if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$returnnotes = new Returnnotes();
		$fields="inv_returnnotedetails.id, inv_returnnotedetails.returnnoteid,  inv_returnnotes.documentno, inv_items.id as itemid,inv_items.name itemname, inv_returnnotedetails.quantity, inv_returnnotedetails.costprice, inv_returnnotedetails.total, inv_returnnotes.memo, inv_returnnotes.returnedon, inv_returnnotes.remarks, inv_returnnotes.ipaddress, inv_returnnotes.createdby, inv_returnnotes.createdon, inv_returnnotes.lasteditedby, inv_returnnotes.lasteditedon";
		$join=" left join inv_returnnotedetails on inv_returnnotedetails.returnnoteid=inv_returnnotes.id left join inv_items on inv_returnnotedetails.itemid=inv_items.id   ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where inv_returnnotes.documentno='$obj->invoiceno'";
		$returnnotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$returnnotes->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
							
			$ob=$row;
			$row->total=$row->quantity*$row->costprice;
			$shpreturnnotes[$it]=array('itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname", 'quantity'=>"$ob->quantity", 'costprice'=>"$ob->costprice", 'tax'=>"$ob->tax", 'discount'=>"$ob->discount", 'total'=>"$ob->total", 'remarks'=>"$ob->remarks", 'total'=>"$ob->total");

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
		

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);	
		
		$obj->remarks="";
		$obj->itemid="";
		$obj->itemname="";
		$obj->costprice="";
		$obj->quantity="";
		$obj->requiredon="";
		 
		 
		$obj->iterator=$it;
		
		$obj->action="Update";
		$_SESSION['shpreturnnotes']="";
		$_SESSION['obj']=$obj;
		$_SESSION['shpreturnnotes']=$shpreturnnotes;
	}
}

if(empty($obj->action)){

	$purchasemodes= new Purchasemodes();
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="";
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
	$returnnotes=new Returnnotes();
	$where=" where id=$id ";
	$fields="inv_returnnotes.id, inv_returnnotes.supplierid, inv_returnnotes.documentno, inv_returnnotes.purchaseno, inv_returnnotes.purchasemodeid, inv_returnnotes.returnedon, inv_returnnotes.memo, inv_returnnotes.remarks, inv_returnnotes.createdby, inv_returnnotes.createdon, inv_returnnotes.lasteditedby, inv_returnnotes.lasteditedon, inv_returnnotes.ipaddress, inv_returnnotes.projectid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnnotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returnnotes->fetchObject;

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