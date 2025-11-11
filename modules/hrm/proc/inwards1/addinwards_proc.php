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
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../proc/config/Config_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../assets/assets/Assets_class.php");

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

if(!empty($ob->documentno))
  $obj->invoiceno=$ob->documentno;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
	$obj->action="Filter";
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
		if($inwards->add($inwards,$shpinwards,false)){
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
		if($inwards->edit($inwards,"",$shpinwards,true)){			
			$error=UPDATESUCCESS;
			$saved="Yes";		
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action=="Effect Journals"){
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
		$inwards->effectjournals=1;
		if($inwards->add($inwards,$shpinwards)){		
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
	$fields=" *, inv_categorys.name category ";
	$join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $items->sql;
	$items=$items->fetchObject;
	
	$assets = new Assets();
	$fields=" *, inv_categorys.name category ";
	$join=" left join inv_categorys on inv_categorys.id=inv_assets.categoryid ";
	$groupby="";
	$having="";
	$where=" where id='$obj->assetid'";
	$assets->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $assets->sql;
	$assets=$assets->fetchObject;

	;
	$shpinwards[$it]=array('id'=>"$obj->id",'memo'=>"$obj->memo", 'itemid'=>"$obj->itemid", 'itemname'=>"$obj->itemname",'assetid'=>"$obj->assetid", 'itemname'=>"$obj->itemname", 'costprice'=>"$obj->costprice", 'quantity'=>"$obj->quantity", 'total'=>"$obj->total",'categoryid'=>"$items->categoryid",'categoryname'=>"$assets->category");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpinwards']=$shpinwards;

 	$obj->remarks="";
	$obj->itemid="";
	$obj->assetid="";
	$obj->assetname="";
	$obj->itemname="";
	$obj->quantity="";
	$obj->costprice="";
	$obj->total="";
	$obj->id="";
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
		$fields="proc_inwards.id,proc_inwards.currencyid,proc_inwards.lpono,proc_inwards.rate,proc_inwards.eurorate,  proc_inwards.documentno, inv_items.id as itemid,inv_items.name itemname, assets_categorys.id assetid, assets_categorys.name assetname,  proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.memo, proc_inwards.documentno, proc_suppliers.id as supplierid, proc_inwards.remarks, proc_inwards.journals, inv_items.categoryid, proc_inwards.inwarddate, proc_inwards.file, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon, proc_inwards.ipaddress, inv_categorys.name categoryname, proc_inwarddetails.vatclasseid, proc_inwarddetails.tax, proc_inwarddetails.discount, proc_inwarddetails.discountamount ";
		$join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join inv_items on inv_items.id=proc_inwarddetails.itemid left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id left join inv_categorys on inv_categorys.id=inv_items.categoryid left join assets_categorys on assets_categorys.id=proc_inwarddetails.categoryid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_inwards.documentno='$obj->invoiceno'";
		$inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inwards->result;
		$it=0;
		$docss="";
		while($row=mysql_fetch_object($res)){
				
// 			$items = new Items();
// 			$fields=" * ";
// 			$join="";
// 			$groupby="";
// 			$having="";
// 			$where=" where id='$row->itemid'";
// 			$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 			$items=$items->fetchObject;
	  
			$ob=$row;
			$row->vatamount=(($row->quantity*$row->costprice)-($row->quantity*$row->costprice*$row->discount/100))*($row->tax/100);
			$shpinwards[$it]=array('id'=>"$row->id",'quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$ob->itemname", 'assetid'=>"$row->assetid", 'assetname'=>"$ob->assetname", 'code'=>"$row->code", 'discount'=>"$row->discount", 'discountamount'=>"$row->discountamount", 'vatclasseid'=>"$row->vatclasseid", 'tax'=>"$row->tax", 'vatamount'=>"$row->vatamount", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon",'categoryid'=>"$row->categoryid", 'categoryname'=>"$row->categoryname");

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
		$obj->assetid="";
		$obj->assetname="";
		$obj->itemname="";
		$obj->quantity="";
		$obj->costprice="";
		$obj->total="";
		$obj->id="";
		
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
    $fields="proc_purchaseorders.id, proc_purchaseorderdetails.id purchaseorderdetailid, proc_purchaseorders.currencyid, proc_purchaseorders.rate, proc_purchaseorders.eurorate, proc_purchaseorders.documentno, inv_items.id as itemid,inv_items.name itemname, 
    assets_categorys.id as assetid, assets_categorys.name assetname, proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.discount, proc_purchaseorderdetails.discountamount, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.total, proc_purchaseorderdetails.vatclasseid, proc_purchaseorderdetails.tax, proc_purchaseorderdetails.memo, proc_purchaseorders.documentno, proc_suppliers.id as supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
    $join=" left join proc_purchaseorderdetails on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid left join con_projects on proc_purchaseorders.projectid=con_projects.id  left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id left join assets_categorys on assets_categorys.id=proc_purchaseorderdetails.categoryid  ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where proc_purchaseorders.documentno='$grns[$i]'";
    $purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $purchaseorders->sql;
    $res=$purchaseorders->result;
    
    $docs.=$grns[$i].",";
    
    
    
    while($row=mysql_fetch_object($res)){
		
	    
	    $items = new Items();
	    $fields=" inv_items.*, inv_categorys.name as category ";
	    $join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
	    $groupby="";
	    $having="";
	    $where=" where inv_items.id='$row->itemid'";
	    $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $items->sql;
	    $items=$items->fetchObject;
	    
	    //get already received inwards
	    $inwards = new Inwards();
	    $fields=" sum(proc_inwarddetails.quantity) quantity ";
	    $join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id ";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $where=" where find_in_set('$grns[$i]',lpono) and proc_inwarddetails.itemid='$row->itemid'";
	    $inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $inwards = $inwards->fetchObject;

	    $ob=$row;
	    $quantity = $row->quantity-$inwards->quantity;
	    if($quantity<=0)
	      $checked=false;
	    else
	      $checked=true;
	    $row->total=($quantity*$row->costprice*(100-$row->discount)/100)*(100+$row->tax)/100;
	    $vatamount=($quantity*$row->costprice*(100-$row->discount)/100)*($row->tax)/100;
	    
	    if(!empty($row->assetid)){
		$x=0;
		while($x<$quantity){
		  $row->total=(1*$row->costprice*(100-$row->discount))/100*(100+$row->tax)/100;
		  $vatamount=(1*$row->costprice*(100-$row->discount)/100)*($row->tax)/100;
		  $shpinwards[$it]=array('id'=>false,'checked'=>$checked,'purchaseorderdetailid'=>"$row->purchaseorderdetailid",'quantity'=>"1",'quantitys'=>"1", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name",'assetid'=>"$row->assetid", 'assetname'=>"$row->assetname", 'categoryid'=>"$items->categoryid", 'categoryname'=>"$items->category", 'code'=>"$row->code",'discount'=>"$row->discount", 'discountamount'=>"$row->discountamount", 'tax'=>"$row->tax", 'vatclasseid'=>"$row->vatclasseid", 'vatamount'=>"$vatamount", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

		  $it++;
		  $x++;
		}
	    }else{
	      
		$shpinwards[$it]=array('id'=>false,'checked'=>$checked,'purchaseorderdetailid'=>"$row->purchaseorderdetailid",'quantity'=>"$quantity",'quantitys'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name",'assetid'=>"$row->assetid", 'assetname'=>"$row->assetname", 'categoryid'=>"$items->categoryid", 'categoryname'=>"$items->category", 'code'=>"$row->code",'discount'=>"$row->discount", 'discountamount'=>"$row->discountamount", 'tax'=>"$row->tax", 'vatclasseid'=>"$row->vatclasseid", 'vatamount'=>"$vatamount", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

		$it++;
	    }
    }
    $i++;
  }
  
  $docs = substr($docs, 0, -1);
  $obj->lpono=$docs;
  //for autocompletes
  $suppliers = new Suppliers();
  $fields=" * ";
  $where=" where id='$ob->supplierid'";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $suppliers=$suppliers->fetchObject;
  $auto->suppliername=$suppliers->name;
  
  $obj->iterator=$it;
  $obj->purchasemodeid=2;
  
  $_SESSION['shpinwards']=$shpinwards;
  
  
  $obj = (object) array_merge((array) $obj, (array) $ob);
  
  $defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from proc_inwards"));
  if($defs->documentno == null){
	  $defs->documentno=1;
  }
  $obj->documentno=$defs->documentno;

  $obj->inwarddate=date("Y-m-d");	

  $obj = (object) array_merge((array) $obj, (array) $auto);	
}

$page_title="Inwards ";
include "addinwards.php";
?>