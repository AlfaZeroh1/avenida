<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Invoices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/agents/Agents_class.php");
require_once("../invoicedetails/Invoicedetails_class.php");
require_once("../invoiceconsumables/Invoiceconsumables_class.php");
require_once("../../pos/invoices/Invoices_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../sys/currencyrates/Currencyrates_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");
require_once("../../pos/saletypes/Saletypes_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8657";//Edit
}
else{
	$auth->roleid="8655";//Add
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
	$obj->parent=$_GET['parent'];
}

if(!empty($ob->documentno)){
  $obj->invoicenos=$ob->documentno;
  $obj->action="Filter";
}
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_invoices"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->soldon=date("Y-m-d");

}
	
if($obj->action=="Save"){echo "Here";
	$invoices=new Invoices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpinvoices=$_SESSION['shpinvoices'];
	$shpconsumables=$_SESSION['shpconsumables'];
	$error=$invoices->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpinvoices)){
		$error="No items in the sale list!";
	}
	else{
		$invoices=$invoices->setObject($obj);
		if($invoices->add($obj,$shpinvoices,$shpconsumables)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$invoices=new Invoices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$invoices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$invoices=$invoices->setObject($obj);
		$shpinvoices=$_SESSION['shpinvoices'];
		$shpconsumables=$_SESSION['shpconsumables'];
		if($invoices->edit($obj,$shpinvoices,$shpconsumables)){
			$error=UPDATESUCCESS;
			$saved="Yes";
			//redirect("addinvoices_proc.php?id=".$invoices->id."&error=".$error);
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
	$shpinvoices=$_SESSION['shpinvoices'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	
	$sizes = new Sizes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$sizes=$sizes->fetchObject;

	
	$shpinvoices[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name",'sizeid'=>"$obj->sizeid",'sizename'=>"$sizes->name", 'quantity'=>"$obj->quantity", 'price'=>"$obj->price", 'discount'=>"$obj->discount", 'bonus'=>"$obj->bonus", 'total'=>"$obj->total",'boxno'=>"$obj->boxno",'departmentid'=>"$obj->departmentid");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpinvoices']=$shpinvoices;

	$obj->itemid="";
	$obj->sizeid="";
 	$obj->quantity="";
 	$obj->price="";
 	$obj->discount="";
 	$obj->bonus="";
 }
}

if($obj->action4=="Add"){

	$shpinvoices=$_SESSION['shpinvoices'];
	$_SESSION['shpinvoices']=$shpinvoices;

	if(empty($obj->itemid)){
		$error=" must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterators))
		$it=0;
	else
		$it=$obj->iterators;
	$shpconsumables=$_SESSION['shpconsumables'];

	$items = mysql_fetch_object(mysql_query("select * from inv_items where id='$obj->itemid'"));
	$uoms = mysql_fetch_object(mysql_query("select * from inv_unitofmeasures where id='$items->unitofmeasureid'"));
	$shpconsumables[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name",'unitofmeasureid'=>"$obj->unitofmeasureid",'unitofmeasurename'=>"$uoms->name", 'quantity'=>"$obj->quantity", 'price'=>"$obj->price", 'total'=>"$obj->total",'boxno'=>"$obj->boxno");

 	$it++;
		$obj->iterators=$it;
 	$_SESSION['shpconsumables']=$shpconsumables;
 	
 	$save="Yes";

	$obj->itemid="";
	$obj->itemname="";
	$obj->unitofmeasureid="";
	$obj->unitofmeasurename="";
 	$obj->quantity="";
 	$obj->price="";
 	$obj->total="";
 }
}

if(empty($obj->action)){

	$agents= new Agents();
	$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_agents.statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon, crm_agents.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);	
	

}

if(!empty($id)){
	$invoices=new Invoices();
	$where=" where id=$id ";
	$fields="pos_invoices.id, pos_invoices.documentno, pos_invoices.packingno, pos_invoices.customerid, pos_invoices.agentid, pos_invoices.remarks, pos_invoices.soldon, pos_invoices.memo, pos_invoices.createdby, pos_invoices.createdon, pos_invoices.lasteditedby, pos_invoices.lasteditedon, pos_invoices.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$invoices->fetchObject;

	//for autocompletes
	$customers = new Customers();
	$fields=" * ";
	$where=" where id='$obj->customerid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$customers->fetchObject;

	$obj->customername=$auto->name;
}

if($obj->action=="Filter"){
	if(empty($obj->parent) and empty($obj->invoicenos)){
	  $error="Must supply invoice number to retrieve";
	}
	elseif(!empty($obj->parent) and empty($obj->customerid2)){
	    $error="Must Select Parent Customer to retrieve";
	  }
	elseif(!empty($obj->parent) and empty($obj->invoicedate)){
	  $error="Must give Date of Invoice";
	}
	else{
		
		$invoicedetails = new Invoicedetails();
		$fields="pos_invoices.*, pos_invoicedetails.*";
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($obj->parent))
		  $where=" where pos_invoices.customerid in(select id from crm_customers where customerid='$obj->customerid2' and soldon='$obj->invoicedate')";
		else
		  $where=" where pos_invoices.documentno='$obj->invoicenos'";
		$invoicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$invoicedetails->result;
		
		$obj->action="Update";
		
		$it=0;
		$shpinvoices=array();
		while($row=mysql_fetch_object($res)){
				
		    $items = new Items();
		    $fields=" * ";
		    $join="";
		    $groupby="";
		    $having="";
		    $where=" where id='$row->itemid'";
		    $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $items=$items->fetchObject;
		    
		    $item->name="";
		    
		    if($obj->mixedbox=="Yes"){
		      $item = new Items();
		      $fields=" * ";
		      $join="";
		      $groupby="";
		      $having="";
		      $where=" where id='$row->itemid'";
		      $item->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $item=$item->fetchObject;
		    }
			
			$row->total=$row->quantity*$row->price*(100+$row->vat)/100;
			$ob=$row;
			$shpinvoices[$it]=array('id'=>"$ob->id",'itemid'=>"$ob->itemid", 'itemname'=>"$items->name",'itemnam'=>"$item->name",'item'=>"$item->id", 'quantity'=>"$ob->quantity", 'price'=>"$ob->price",'vat'=>"$obj->vat", 'exportprice'=>"$ob->exportprice", 'discount'=>"$ob->discount", 'bonus'=>"$ob->bonus", 'total'=>"$ob->total",'exporttotal'=>"$ob->exportprice*$ob->quantity",'boxno'=>"$obj->boxno");

			$it++;
		}
		
		$shpconsumables = array();
		$invoiceconsumables=new Invoiceconsumables();
		$where=" where pos_invoiceconsumables.invoiceid=$ob->invoiceid ";
		$fields="pos_invoiceconsumables.id, pos_invoiceconsumables.itemid, inv_items.name itemname, inv_unitofmeasures.name unitofmeasurename, pos_invoiceconsumables.unitofmeasureid, pos_invoiceconsumables.quantity, pos_invoiceconsumables.price, pos_invoiceconsumables.total, pos_invoiceconsumables.remarks, pos_invoiceconsumables.ipaddress, pos_invoiceconsumables.createdby, pos_invoiceconsumables.createdon, pos_invoiceconsumables.lasteditedby, pos_invoiceconsumables.lasteditedon";
		$join=" left join inv_items on inv_items.id=pos_invoiceconsumables.itemid left join inv_unitofmeasures on inv_unitofmeasures.id=pos_invoiceconsumables.unitofmeasureid";
		$having="";
		$groupby="";
		$orderby="";
		$invoiceconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$its=0;
		
		while($consumables = mysql_fetch_object($invoiceconsumables->result)){
		  $shpconsumables[$its]=array('id'=>"$ob->id",'itemid'=>"$consumables->itemid", 'itemname'=>"$consumables->itemname",'unitofmeasureid'=>"$consumables->unitofmeasureid",'unitofmeasurename'=>"$consumables->unitofmeasurename", 'quantity'=>"$consumables->quantity", 'price'=>"$consumables->price", 'total'=>"$consumables->total",'boxno'=>"$consumables->boxno");
		  $its++;
		}	
	}
	//for autocompletes
		$customers = new Customers();
		$fields=" * ";
		if(!empty($obj->parent))
		  $where=" where id='$obj->customerid2'";
		else
		  $where=" where id='$ob->customerid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$customers->fetchObject;
		$ob->customername=$auto->name;
		$ob->customerid=$auto->id;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		
		$obj->iterator=$it;
		$obj->iterators=$its;
		
		$_SESSION['shpconsumables']=$shpconsumables;
		$_SESSION['shpinvoices']=$shpinvoices;
}

if($obj->action=="Raise Credit Note"){
  $shpinvoices=$_SESSION['shpinvoices'];
  
  $num = count($shpinvoices);
  $i=0;
  $k=0;
  while($i<$num){
  
      $ob->customerid = $obj->customerid;
      $ob->customername = $obj->customername;
      $ob->invoiceno = $obj->documentno;
      $ob->address = $obj->address;
      $ob->mobile = $obj->mobile;
      $ob->remarks = $obj->remarks;
      $ob->packingno=$obj->packingno;
      $ob->saletypeid=$obj->saletypeid;
      $ob->currencyid=$obj->currencyid;
      $_SESSION['ob']=$ob;
      
    if(isset($_POST[$shpinvoices[$i]['id']])){
      $shpreturninwards[$k]=$shpinvoices[$i];
      $k++;
    }
    $i++;
  }
//   print_r($shpreturninwards);
  $_SESSION['shpreturninwards']=$shpreturninwards;
  $_SESSION['shpinvoices']="";
  
  redirect("../returninwards/addreturninwards_proc.php?raise=1");
}

// if(empty($id) and empty($obj->action)){
// 	if(empty($_GET['edit'])){
// 		$ob=$_SESSION['ob'];
// 		$_SESSION['ob']="";
// 		$obj = (object) array_merge((array) $obj, (array) $ob);
// 		$obj->action="Save";
// 		$obj->iterator = count($_SESSION['shpinvoices']);
// 	}
// 	else{
// 		$obj=$_SESSION['obj'];
// 	}
// }	
// elseif(!empty($id) and empty($obj->action)){
// 	$obj->action="Update";
// }

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2) and empty($obj->action4)){
	if(empty($_GET['invoice'])){
	  $_SESSION['shpinvoices']="";
	   $_SESSION['shpconsumables']="";
	 
	}else{
	  $obj=$_SESSION['ob'];
	  $shpinvoices=$_SESSION['shpinvoices'];
	  $obj->iterator=count($shpinvoices);
	   $obj->retrieve="";
	   
	   $customers= new Customers();
	    $fields="* ";
	    $join=" ";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $where=" where crm_customers.id='$obj->customerid' ";
	    $customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $customers = $customers->fetchObject;
	   
	   if(!empty($obj->customerid)){
	    $date=date("Y-m-d");
	    
	    $save="Yes";
	    
	    $error="";
	    if(empty($customers->currencyid)){
	      $error="Customer Currency not set";
	     
	      $save="No";
	    }else{
	      $currencys = new Currencyrates();
	      $fields="* ";
	      $join=" ";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $where=" where currencyid='$customers->currencyid' and fromcurrencydate<='$date' and tocurrencydate>='$date' ";
	      $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      if($currencys->affectedRows<1){
		$error="Currency Exchange Rate not set for date ".formatDate($date);
		$save="No";
	      }
	    }	    
	    
	    $currencys = $currencys->fetchObject;
	    $obj->currencyid=$customers->currencyid;
	    $obj->vatable=$customers->vatable;
	    if($obj->vatable=="Yes")
	      $obj->vat=16;
	    else
	      $obj->vat=0;
	    $obj->exchangerate=$currencys->eurorate;
	    $obj->exchangerate2=$currencys->rate;
	  }
	   
	}
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_invoices"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;
	
	$invoices = new Invoices();
	$fields="max(invoiceno) invoiceno";
	$join=" ";
	$where=" where pos_invoices.customerid='$obj->customerid'";
	$having="";
	$groupby="  ";
	$orderby="";
	$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$invs = $invoices->fetchObject;
	
	$obj->invoiceno=$invs->invoiceno+1;

	$obj->soldon=date("Y-m-d");
      }
  } 
  else{
    $obj=$_SESSION['obj'];
  }
  
  $obj->action="Save";
}
else{
  $obj->action="Update";
}
	
	
$page_title="Invoices ";
include "addinvoices.php";
?>
