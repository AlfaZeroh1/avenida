<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returninwards_class.php");
require_once("../../auth/rules/Rules_class.php");

// print_r($_SESSION['shpconsumables']);
if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/agents/Agents_class.php");
require_once("../returninwarddetails/Returninwarddetails_class.php");
require_once("../returninwardconsumables/Returninwardconsumables_class.php");
require_once("../../pos/returninwards/Returninwards_class.php");
require_once("../../inv/items/Items_class.php");
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

$types=$_GET['types'];
if(!empty($types)){
	$obj->types=$types;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
	$obj->parent=$_GET['parent'];
}

if(!empty($ob->documentno)){
  $obj->returninwardnos=$ob->documentno;
  $obj->types=$ob->types;
  $obj->action="Filter";
}
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_returninwards where types='$obj->types'"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->soldon=date("Y-m-d");

}
	
if($obj->action=="Save"){
	$returninwards=new Returninwards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpreturninwards=$_SESSION['shpreturninwards'];
	$shpconsumables=$_SESSION['shpconsumables'];
	$error=$returninwards->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
// 	elseif(empty($shpreturninwards)){
// 		$error="No items in the sale list!";
// 	}
	else{
		$returninwards=$returninwards->setObject($obj);
		if($returninwards->add($obj,$shpreturninwards,$shpconsumables)){
			$error=SUCCESS;
			unset($_SESSION['shpreturninwards']);
			unset($_SESSION['shpconsumables']);
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returninwards=new Returninwards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returninwards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returninwards=$returninwards->setObject($obj);
		$shpreturninwards=$_SESSION['shpreturninwards'];
		$shpconsumables=$_SESSION['shpconsumables'];
		if($returninwards->edit($obj,$shpreturninwards,$shpconsumables)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpreturninwards']);
			unset($_SESSION['shpconsumables']);
			$saved="Yes";
			//redirect("addreturninwards_proc.php?id=".$returninwards->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action=="Un Do"){
	$returninwards=new Returninwards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returninwards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returninwards=$returninwards->setObject($obj);
		$shpreturninwards=$_SESSION['shpreturninwards'];
		$shpconsumables=$_SESSION['shpconsumables'];
		if($returninwards->delete($obj,$shpreturninwards,$shpconsumables)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpreturninwards']);
			unset($_SESSION['shpconsumables']);
			$saved="Yes";
			//redirect("addreturninwards_proc.php?id=".$returninwards->id."&error=".$error);
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
	$shpreturninwards=$_SESSION['shpreturninwards'];

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

	
	$shpreturninwards[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name",'sizeid'=>"$obj->sizeid",'sizename'=>"$sizes->name", 'quantity'=>"$obj->quantity", 'price'=>"$obj->price", 'discount'=>"$obj->discount", 'bonus'=>"$obj->bonus",'remarks'=>"$obj->remarks", 'total'=>"$obj->total",'boxno'=>"$obj->boxno",'departmentid'=>"$obj->departmentid");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpreturninwards']=$shpreturninwards;

	$obj->itemid="";
	$obj->sizeid="";
 	$obj->quantity="";
 	$obj->price="";
 	$obj->discount="";
 	$obj->bonus="";
 }
}

if($obj->action4=="Add"){

	$shpreturninwards=$_SESSION['shpreturninwards'];
	$_SESSION['shpreturninwards']=$shpreturninwards;

	if(empty($obj->itemid)){
		$error=" must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" must be provided";
	}
	else{
	$_SESSION['obj']=$obj;$types=$_GET['types'];
if(!empty($types)){
	$obj->types=$types;
}
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
	$returninwards=new Returninwards();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returninwards->fetchObject;

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
	if(empty($obj->parent) and empty($obj->returninwardnos)){
	  $error="Must supply returninward number to retrieve";
	}
	else{
		
		$returninwarddetails = new Returninwarddetails();
		$fields="pos_returninwards.*, pos_returninwarddetails.*, pos_items.name itemname";
		$join=" left join pos_returninwards on pos_returninwards.id=pos_returninwarddetails.returninwardid left join pos_items on pos_items.id=pos_returninwarddetails.itemid ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($obj->parent))
		  $where=" where pos_returninwards.customerid in(select id from crm_customers where customerid='$obj->customerid2' and returnedon='$obj->returnedon') and pos_returninwards.type='$obj->type'";
		else
		  $where=" where pos_returninwards.creditnotenos='$obj->returninwardnos' and pos_returninwards.types='$obj->types'";
		$returninwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $returninwarddetails->sql;
		$res=$returninwarddetails->result;
		
		$obj->action="Update";
		
		$it=0;
		$shpreturninwards=array();
		while($row=mysql_fetch_object($res)){
			
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
			$shpreturninwards[$it]=array('id'=>"$ob->id",'itemid'=>"$ob->itemid", 'itemname'=>"$row->itemname",'itemnam'=>"$item->name",'item'=>"$item->id", 'quantity'=>"$ob->quantity", 'price'=>"$ob->price",'vat'=>"$obj->vat",'type'=>"$obj->type", 'exportprice'=>"$ob->exportprice", 'discount'=>"$ob->discount", 'bonus'=>"$ob->bonus", 'total'=>"$ob->total",'exporttotal'=>"$ob->exportprice*$ob->quantity",'boxno'=>"$obj->boxno");

			$it++;
		}
		
		$shpconsumables = array();
		$returninwardconsumables=new Returninwardconsumables();
		$where=" where pos_returninwardconsumables.returninwardid=(select id from pos_returninwards where pos_returninwards.creditnotenos='$obj->returninwardnos' and pos_returninwards.types='$obj->types') ";
		$fields="pos_returninwards.*, pos_returninwardconsumables.itemid, inv_items.name itemname, inv_unitofmeasures.name unitofmeasurename, pos_returninwardconsumables.unitofmeasureid, pos_returninwardconsumables.quantity, pos_returninwardconsumables.price, pos_returninwardconsumables.total, pos_returninwardconsumables.remarks, pos_returninwardconsumables.ipaddress, pos_returninwardconsumables.createdby, pos_returninwardconsumables.createdon, pos_returninwardconsumables.lasteditedby, pos_returninwardconsumables.lasteditedon";
		$join=" left join inv_items on inv_items.id=pos_returninwardconsumables.itemid left join inv_unitofmeasures on inv_unitofmeasures.id=pos_returninwardconsumables.unitofmeasureid left join pos_returninwards on pos_returninwardconsumables.returninwardid=pos_returninwards.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returninwardconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $returninwardconsumables->sql;
		$its=0;
		
		
		
		while($consumables = mysql_fetch_object($returninwardconsumables->result)){
		    $consumables->price=round($consumables->price,2);
		    $consumables->total=round($consumables->total,2);
		   
		   if(empty($ob->id)){
		   $ob=$consumables;
		   }
		   
		  $shpconsumables[$its]=array('id'=>"$ob->id",'itemid'=>"$consumables->itemid", 'itemname'=>"$consumables->itemname",'unitofmeasureid'=>"$consumables->unitofmeasureid",'unitofmeasurename'=>"$consumables->unitofmeasurename", 'quantity'=>"$consumables->quantity", 'price'=>"$consumables->price", 'total'=>"$consumables->total",'boxno'=>"$consumables->boxno");
		  $its++;
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
		$auto->customername=$auto->name;
		$auto->customerid=$auto->id;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		
		$obj->iterator=$it;
		$obj->iterators=$its;
		
		$_SESSION['shpconsumables']=$shpconsumables;
		$_SESSION['shpreturninwards']=$shpreturninwards;
		
		$obj->itemid="";
		$obj->itemname="";
		$obj->unitofmeasureid="";
		$obj->unitofmeasurename="";
		$obj->quantity="";
		$obj->price="";
		$obj->total="";
	}
}

if($obj->action=="Raise Credit Note"){
  $shpreturninwards=$_SESSION['shpreturninwards'];
  
  $num = count($shpreturninwards);
  $i=0;
  $k=0;
  while($i<$num){
  
      $ob->customerid = $obj->customerid;
      $ob->customername = $obj->customername;
      $ob->documentno = $obj->documentno;
      $ob->address = $obj->address;
      $ob->mobile = $obj->mobile;
      $ob->remarks = $obj->remarks;
      $_SESSION['ob']=$ob;
      
    if(isset($_POST[$shpreturninwards[$i]['id']])){
      $shpreturninwards[$k]=$shpreturninwards[$i];
      $k++;
    }
    $i++;
  }
//   print_r($shpreturninwards);
  $_SESSION['shpreturninwards']=$shpreturninwards;
  $_SESSION['shpreturninwards']="";
    
  redirect("../returninwards/addreturninwards_proc.php?raise=1&type=".$type);
}

// if(empty($id) and empty($obj->action)){
// 	if(empty($_GET['edit'])){
// 		$ob=$_SESSION['ob'];
// 		$_SESSION['ob']="";
// 		$obj = (object) array_merge((array) $obj, (array) $ob);
// 		$obj->action="Save";
// 		$obj->iterator = count($_SESSION['shpreturninwards']);
// 	}
// 	else{
// 		$obj=$_SESSION['obj'];
// 	}
// }	
// elseif(!empty($id) and empty($obj->action)){
// 	$obj->action="Update";
// }
echo $obj->retrieve;
if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2) and empty($obj->action4)){
	if(empty($_GET['raise'])){
	  unset($_SESSION['shpreturninwards']);
	  unset($_SESSION['shpconsumables']);
	  }
	else{
	  $obj=$_SESSION['ob'];
	  
	  if(!empty($ob->types)){
	    $obj->types=$ob->types;
	  }

	  $shpreturninwards=$_SESSION['shpreturninwards'];
	  $obj->iterator=count($shpreturninwards);
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
	    $obj->exchangerate=$currencys->rate;
	    $obj->exchangerate2=$currencys->eurorate;
	  }
	   
	}
			  
	$q="select (max(documentno)+1) documentno from pos_returninwards where types='$obj->types'"; 
	$defs=mysql_fetch_object(mysql_query($q));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;
	
	$returninwards = new Returninwards();
	$fields="max(creditnoteno) creditnoteno";
	$join=" ";
	$where=" where pos_returninwards.customerid='$obj->customerid'";
	$having="";
	$groupby="  ";
	$orderby="";
	$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$invs = $returninwards->fetchObject;
	
	$obj->creditnoteno=$invs->creditnoteno+1;
	
	if($obj->types=="credit")
	  $obj->creditnotenos="CN".$customers->code.$obj->creditnoteno;
	else
	  $obj->creditnotenos="DN".$customers->code.$obj->creditnoteno;

	$obj->returnedon=date("Y-m-d");
	}
	$obj->action="Save";
  } 
  else{ //print_r($_SESSION['shpreturninwards']);        
	$ob = str_replace("'","\"",$_GET['obj']);
	$ob = str_replace("\\","",$ob);
	$ob = unserialize($ob);
	$obj = (object) array_merge((array) $obj, (array) $ob);
	$obj->iterator=count($_SESSION['shpreturninwards']);
        $obj->iterators=count($_SESSION['shpconsumables']);
	$obj->action="Update";
  }  
}
else{
  $obj->action="Update";
}
	
	
$page_title="Returninwards ";
include "addreturninwards.php";
?>
