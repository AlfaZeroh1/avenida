<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchases_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../inv/stores/Stores_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../purchasedetails/Purchasedetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/returnoutwarddetails/Returnoutwarddetails_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once("../../proc/config/Config_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="717";//Edit
}
else{
	$auth->roleid="715";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->purchasemodeid))
  $obj->purchasemodeid=$ob->purchasemodeid;
  
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
			$saved="Yes";
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
		if($purchases->edit($purchases,$where="",$shppurchases)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->quantity)){
		$error=" must be provided";
	}
	elseif(empty($obj->itemid)){
		$error=" must be provided";
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
	$shppurchases[$it]=array('inwarddetailid'=>"$row->inwarddetailid",'quantity'=>"$obj->quantity", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code", 'vatclasseid'=>"$obj->vatclasseid", 'tax'=>"$obj->tax", 'costprice'=>"$obj->costprice", 'tradeprice'=>"$obj->tradeprice", 'discount'=>"$obj->discount", 'remarks'=>"$obj->remarks",'vatamount'=>"$obj->vatamount", 'total'=>"$obj->total-$obj->vatamount",'ttotal'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppurchases']=$shppurchases;

	$obj->quantity="";
 	$obj->itemid="";
 	$obj->itemname="";
 	$obj->remarks="";
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

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
	  $purchases=new Purchases();
	  $where=" where receiptno='$obj->invoiceno' ";
	  $fields="inv_purchasedetails.id,inv_purchases.supplierid, inv_purchasedetails.quantity,inv_purchasedetails.itemid, inv_items.name itemname, inv_assets.id as assetid, inv_assets.name assetname, inv_items.code, inv_purchasedetails.vatclasseid, inv_purchasedetails.tax, inv_purchasedetails.costprice,  inv_purchasedetails.discount, inv_purchasedetails.memo,inv_purchases.receiptno,inv_purchases.lpono,  inv_purchasedetails.vatamount, inv_purchasedetails.total, inv_purchasedetails.discount, inv_purchasedetails.discountamount, inv_purchases.documentno, inv_purchases.remarks, inv_purchases.purchasemodeid, inv_purchases.boughton, inv_purchases.currencyid, inv_purchases.createdby, inv_purchases.createdon, inv_purchases.lasteditedby, inv_purchases.lasteditedon, inv_purchases.ipaddress ";
	  $join=" left join inv_purchasedetails on inv_purchasedetails.purchaseid=inv_purchases.id left join inv_items on inv_items.id=inv_purchasedetails.itemid left join inv_assets on inv_assets.id=inv_purchasedetails.assetid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $purchases->sql;
	  $it=0;
	  while($row = mysql_fetch_object($purchases->result)){
	      $returnoutwarddetails=new Returnoutwarddetails();
	      if(!empty($row->itemid))
	              $where=" where purchaseno='$row->receiptno' and inv_returnoutwarddetails.itemid='$row->itemid' ";
	      else 
	              $where=" where purchaseno='$row->receiptno' and inv_returnoutwarddetails.assetid='$row->assetid' ";
	              
	      $fields=" inv_returnoutwarddetails.quantity,inv_returnoutwarddetails.vatamount,inv_returnoutwarddetails.total ";
	      $join=" left join inv_returnoutwards on inv_returnoutwarddetails.returnoutwardid=inv_returnoutwards.id ";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $returnoutwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $returnoutwarddetails->sql;
	      $returnoutwarddetails=$returnoutwarddetails->fetchObject;
	  
	      $ob=$row;
	      
	      $ob->exctotal=$ob->total-$ob->vatamount;
	      
// 	      $quantity=$ob->quantity-$returnoutwarddetails->quantity;echo $quantity;
// 	      $vatamount=$ob->vatamount-$returnoutwarddetails->vatamount;
// 	      $total=$ob->total-$returnoutwarddetails->total;
              if(!empty($obj->itemid) and $obj->itemid!=NULL and $obj->itemid!='NULL'){
              $items = new Items();
	      $fields="*";
	      $where=" where id='$obj->itemid'";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $items=$items->fetchObject;
				
              $generaljournalaccounts2 = new Generaljournalaccounts();
	      $fields="*";
	      $where=" where refid = '$items->categoryid' and acctypeid='34' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }elseif(!empty($obj->assetid) and $obj->assetid!=NULL and $obj->assetid!='NULL'){
	      $assets = new Assets();
	      $fields="*";
	      $where=" where id='$obj->assetid' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $assets->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $assets=$assets->fetchObject;
				  
	      $generaljournalaccounts2 = new Generaljournalaccounts();
	      $fields="*";
	      $where=" where refid='$assets->categoryid' and acctypeid='7' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }		
	      
	      $shppurchases[$it]=array('id'=>"$ob->id",'quantity'=>"$ob->quantity",'accountid'=>"$generaljournalaccounts2->id", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'assetid'=>"$ob->assetid", 'assetname'=>"$ob->assetname", 'code'=>"$ob->code", 'vatclasseid'=>"$ob->vatclasseid", 'tax'=>"$ob->tax", 'costprice'=>"$ob->costprice", 'discount'=>"$ob->discount", 'discountamount'=>"$ob->discountamount", 'tradeprice'=>"$ob->tradeprice", 'discount'=>"$ob->discount", 'remarks'=>"$ob->remarks",'vatamount'=>"$ob->vatamount", 'total'=>"$ob->exctotal",'ttotal'=>"$ob->total");
	      
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
	  $suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $suppliers->sql;
	  $auto=$suppliers->fetchObject;
	  $ob->suppliername=$auto->name;
	  $ob->supplierid=$auto->id;
	  
	  //for autocompletes
	  $currencys = new Currencys();
	  $fields=" * ";
	  $where=" where id='$ob->currencyid'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $currencys=$currencys->fetchObject;
	  $ob->currencyid=$currencys->id;
	  $ob->exchangerate=$currencys->rate;
	  $ob->exchangerate2=$currencys->eurorate;
	  
	  $obj = (object) array_merge((array) $obj, (array) $ob);
	  $obj = (object) array_merge((array) $obj, (array) $auto);
	  
	  //get jvno
	  $query="select distinct jvno from fn_generaljournals where documentno='$obj->documentno' and transactionid=23";
	  $jvs = mysql_fetch_object(mysql_query($query));
	  $obj->jvno = $jvs->jvno;
	  
	      $obj->quantity="";
	      $obj->itemid="";
	      $obj->itemname="";
	      $obj->remarks="";
	      
	      $obj->iterator=$it; 	
		
		$obj->action="Update";
		$_SESSION['shppurchases']="";
		$_SESSION['obj']=$obj;
		$_SESSION['shppurchases']=$shppurchases;
      }
}

if(!empty($id)){
	$purchases=new Purchases();
	$where=" where id=$id ";
	$fields="inv_purchases.id, inv_purchases.documentno, inv_purchases.lpono, inv_purchases.storeid, inv_purchases.supplierid, inv_purchases.batchno, inv_purchases.remarks, inv_purchases.purchasemodeid, inv_purchases.boughton, inv_purchases.createdby, inv_purchases.createdon, inv_purchases.lasteditedby, inv_purchases.lasteditedon, inv_purchases.ipaddress, inv_purchases.projectid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchases->fetchObject;

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



if($obj->action=="Raise Credit Note" or $obj->action=="Raise Debit Note"){
  $shppurchases=$_SESSION['shppurchases']; 
  
  $num = count($shppurchases);
  $i=0;
  $k=0;
  $ob->purchaseno=$obj->documentno;
  $ob->purchasemodeid=$obj->purchasemodeid;
  $ob->supplierid = $obj->supplierid;
  $ob->suppliername = $obj->suppliername;
  $ob->documentno = $obj->documentno;
  $ob->address = $obj->address;
  $ob->mobile = $obj->mobile;
  $ob->remarks = $obj->remarks;
  $ob->currencyid=$obj->currencyid;
  $ob->exchangerate=$obj->exchangerate;
  $ob->exchangerate2=$obj->exchangerate2;
  $_SESSION['ob']=$ob;
  $shpreturnoutwards=array();
  //$query="create temporary table tmp_shpreturninwards(";
  while($i<$num){     
      
    if(isset($_POST[$shppurchases[$i]['id']])){
      
      $bool=false;
      
      if($k==0){
	$shpreturnoutwards[$k]=$shppurchases[$i];
	$k++;
      }
      else{
      $x=0;
	foreach($shpreturnoutwards as $key => $value){
	
	  if($value['itemid']==$shppurchases[$i]['itemid'] and $value['sizeid']==$shppurchases[$i]['sizeid'] and $value['price']==$shppurchases[$i]['price']){
	    $shpreturnoutwards[$x]['quantity']+=$shppurchases[$i]['quantity'];
	    $shpreturnoutwards[$x]['total']+=($shppurchases[$i]['quantity']*$value['price']);
	    
	    $bool=true;
	    break;
	  }
	  $x++;
	}
	if(!$bool and $k>0){
	  $shpreturnoutwards[$k]=$shppurchases[$i];
	  $k++;
	}
      }
      
    }
    $i++;
  }
   
  $_SESSION['shpreturnoutwards']=$shpreturnoutwards;
  unset($_SESSION['shppurchases']);
  
  if($obj->action=="Raise Credit Note")
    $type="credit";
  else
    $type="debit";
  
  redirect("../returnoutwards/addreturnoutwards_proc.php?raise=1&types=".$type);
}

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
  
      if(empty($obj->action) and empty($obj->action2)){
      
	if(empty($_GET['raise']))
	  $_SESSION['shppurchases']="";
	else{
	  
	  $obj=$_SESSION['ob'];
	  $obj->iterator=count($_SESSION['shppurchases']);
	}
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_purchases"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->boughton=date("Y-m-d");	
	
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

if($obj->action3=="New Invoice"){
  $grns = $_SESSION['shpinward'];
  $num = count($grns);
  $i=0;
  $it=0;
  $shppurchases=array();
  while($i<$num){
    $inwards = new Inwards();
    $fields="proc_inwards.id, proc_inwarddetails.id inwarddetailid, con_projects.id as projectid, proc_inwards.documentno, inv_items.id as itemid,inv_items.name itemname,  proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.vatclasseid, proc_inwarddetails.tax, proc_inwarddetails.memo, proc_inwarddetails.discount, proc_inwarddetails.discountamount, proc_inwards.documentno, proc_suppliers.id as supplierid, proc_inwards.remarks, proc_inwards.inwarddate, proc_inwards.file, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon, proc_inwards.ipaddress";
    $join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join inv_items on inv_items.id=proc_inwarddetails.itemid left join con_projects on proc_inwards.projectid=con_projects.id  left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id  ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where proc_inwards.documentno='$grns[$i]'";
    $inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo "X";//echo $inwards->sql;
    $res=$inwards->result;
    while($row=mysql_fetch_object($res)){
		   
	      $ob=$row;
	    
	      if(!empty($ob->itemid) and $ob->itemid!=NULL and $ob->itemid!='NULL'){
              $items = new Items();
	      $fields="*";
	      $where=" where id='$ob->itemid'";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $items=$items->fetchObject;
				
              $generaljournalaccounts2 = new Generaljournalaccounts();
	      $fields="*";
	      $where=" where refid = '$items->categoryid' and acctypeid='34' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }elseif(!empty($ob->assetid) and $ob->assetid!=NULL and $ob->assetid!='NULL'){
	      $assets = new Assets();
	      $fields="*";
	      $where=" where id='$ob->assetid' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $assets->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $assets=$assets->fetchObject;
				  
	      $generaljournalaccounts2 = new Generaljournalaccounts();
	      $fields="*";
	      $where=" where refid='$assets->categoryid' and acctypeid='7' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }		
	    
	    
	    $row->total=(($row->quantity*$row->costprice)-($row->discount*$row->quantity*$row->costprice/100));
	    $vatamount=$row->total*$row->tax/100;
	    $row->ttotal=$row->total+$vatamount;
	    
	    $shppurchases[$it]=array('inwarddetailid'=>"$row->inwarddetailid",'accountid'=>"$generaljournalaccounts2->id",'quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name",'assetid'=>"$ob->assetid", 'discount'=>"$ob->discount",'discountamount'=>"$ob->discountamount",'assetname'=>"$ob->assetname", 'code'=>"$row->code", 'vatclasseid'=>"$row->vatclasseid", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks",'vatamount'=>"$vatamount", 'total'=>"$row->total",'ttotal'=>"$row->ttotal",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

	    $it++;
    }
    $i++;
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
  
  $currencys = new Currencys();
  $fields="* ";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='$auto->currencyid' ";
  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $currencys = $currencys->fetchObject;
  $obj->exchangerate=$currencys->rate;
  $obj->exchangerate2=$currencys->eurorate;
  
  $obj->iterator=$it;
  $obj->purchasemodeid=2;
  
  $_SESSION['shppurchases']=$shppurchases;

  $obj = (object) array_merge((array) $obj, (array) $ob);
  $obj = (object) array_merge((array) $obj, (array) $auto);	
}
	
$page_title="Purchases ";
include "addpurchases.php";
?>