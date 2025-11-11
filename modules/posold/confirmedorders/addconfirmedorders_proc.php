<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Confirmedorders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/confirmedorderdetails/Confirmedorderdetails_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8705";//Edit
}
else{
	$auth->roleid="8703";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;


if(!empty($ob->orderno)){
  $obj->invoiceno=$ob->orderno;
  $obj->action="Filter";
  $obj->retrieve=1;
}

if(!empty($ob->confirm)){
  $obj = $_SESSION['ob'];
  $obj->confirm=1;
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
	
	
if($obj->action=="Save"){
	$confirmedorders=new Confirmedorders();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpconfirmedorders=$_SESSION['shpconfirmedorders'];
	$error=$confirmedorders->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpconfirmedorders)){
		$error="No items in the sale list!";
	}
	else{
		$confirmedorders=$confirmedorders->setObject($obj);
		if($confirmedorders->add($confirmedorders,$shpconfirmedorders)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$confirmedorders=new Confirmedorders();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$confirmedorders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$confirmedorders=$confirmedorders->setObject($obj);
		$shpconfirmedorders=$_SESSION['shpconfirmedorders'];
		if($confirmedorders->edit($confirmedorders,"",$shpconfirmedorders)){
			$error=UPDATESUCCESS;
			$saved="Yes";
			//redirect("addconfirmedorders_proc.php?id=".$confirmedorders->id."&error=".$error);
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
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpconfirmedorders=$_SESSION['shpconfirmedorders'];

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
	$where=" where id='$obj->sizeid'";
	$sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$sizes=$sizes->fetchObject;
	
	
	$shpconfirmedorders[$it]=array('itemid'=>"$obj->itemid", 'sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity", 'packrate'=>"$obj->packrate", 'memo'=>"$obj->memo");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpconfirmedorders']=$shpconfirmedorders;

	$obj->itemid="";
 	$obj->quantity="";
 	$obj->memo="";
 }
}

if(empty($obj->action)){

	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$confirmedorders=new Confirmedorders();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$confirmedorders->fetchObject;

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
	if(!empty($obj->invoiceno)){
		$shpconfirmedorders=array();
		$confirmedorders = new Confirmedorders();
		$fields="pos_confirmedorderdetails.id, pos_confirmedorders.orderno, pos_sizes.id sizeid, pos_sizes.name sizename, pos_confirmedorders.remarks, crm_customers.id as customerid, pos_confirmedorderdetails.quantity, pos_confirmedorderdetails.packrate, pos_confirmedorderdetails.memo, pos_items.id itemid, pos_items.name itemname, pos_confirmedorders.orderedon, pos_confirmedorders.remarks, pos_confirmedorders.ipaddress, pos_confirmedorders.createdby, pos_confirmedorders.createdon, pos_confirmedorders.lasteditedby, pos_confirmedorders.lasteditedon";
		$join=" left join crm_customers on pos_confirmedorders.customerid=crm_customers.id left join pos_confirmedorderdetails on pos_confirmedorderdetails.confirmedorderid=pos_confirmedorders.id left join pos_items on pos_items.id=pos_confirmedorderdetails.itemid left join pos_sizes on pos_sizes.id=pos_confirmedorderdetails.sizeid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_confirmedorders.orderno='$obj->invoiceno'";
		$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$confirmedorders->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpconfirmedorders[$it]=array('id'=>"$ob->id",'itemid'=>"$ob->itemid", 'sizeid'=>"$ob->sizeid",'sizename'=>"$ob->sizename", 'itemname'=>"$ob->itemname", 'quantity'=>"$ob->quantity", 'packrate'=>"$ob->packrate", 'memo'=>"$ob->memo");

			$it++;
		}

		//for autocompletes
		$customers = new Customers();
		$fields=" id, name ";
		$where=" where id='$ob->customerid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$customers->fetchObject;
		$auto->customername=$auto->name;		

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);

		$obj->iterator=$it;
		$obj->action="Update";
		
		$_SESSION['shpconfirmedorders']=$shpconfirmedorders;
	}
}

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2)){
	if(empty($obj->confirm))
	  $_SESSION['shpconfirmedorders']="";
	$obj->confirmedon=date("Y-m-d");
	
	$obj->action="Save";
  
      }
      else{
	 $obj->action="Update";
      }
  } 
  else{
    $obj=$_SESSION['obj'];
   
  }
  
}
else{
  $obj->action="Update";
}
	
	
$page_title="Confirmedorders ";
include "addconfirmedorders.php";
?>