<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Packinglistreturns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/customerprices/Customerprices_class.php");
require_once("../../crm/customerseasons/Customerseasons_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/fleets/Fleets_class.php");
require_once("../packinglistdtreturns/Packinglistdtreturns_class.php");
require_once("../../pos/packinglistreturns/Packinglistreturns_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/itemstocks/Itemstocks_class.php");
require_once("../../prod/sizes/Sizes_class.php");
require_once("../../sys/ipaddress/Ipaddress_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8673";//Edit
}
else{
	$auth->roleid="8671";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->returns)){
  $obj->returns=$ob->returns;
}

if(!empty($obj->box)){
	$obj->boxno=$obj->box;
}
if(!empty($ob->next)){
  $obj->boxno=$ob->next;
	$obj->documentno=$ob->packing;
}

if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_packinglistreturns"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->packedon=date("Y-m-d");

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
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_packinglistreturns"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->packedon=date("Y-m-d");

}

if(!empty($ob->packingno)){
  $obj->invoiceno=$ob->packingno;
  $obj->box=$ob->box;
  $obj->action="Filter";
  $obj->retrieve=1;
}
	
if($obj->action=="Save Returns"){
	$packinglistreturns=new Packinglistreturns();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shppackinglistreturns=$_SESSION['shppackinglistreturns'];
	$error=$packinglistreturns->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppackinglistreturns)){
		$error="No items in the sale list!";
	}
	else{
		$packinglistreturns=$packinglistreturns->setObject($obj);
		if($packinglistreturns->add($packinglistreturns,$shppackinglistreturns)){
			$error=SUCCESS;
			
			$next=$obj->boxno+1;
			$packing=$obj->documentno;
			
			if($obj->action=="Save & Move to Next Box"){
			  $_SESSION['shppackinglistreturns']="";
			  $obj->boxno+=1;
			  $saved="No";
			  $obj->iterator=0;
			}
			else{
			  $saved="Yes";
			}
		}
		else{
			$error=FAILURE;
		}
	}
	
	
	
	$obj->action="Save & Move to Next Box";
        $obj->action3="Save & Move to Next Customer";
}
	
if($obj->action=="Update"){
	$packinglistreturns=new Packinglistreturns();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$packinglistreturns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$packinglistreturns=$packinglistreturns->setObject($obj);
		$shppackinglistreturns=$_SESSION['shppackinglistreturns'];
		if($packinglistreturns->edit($packinglistreturns,"",$shppackinglistreturns)){
			$error=UPDATESUCCESS;
			redirect("addpackinglistreturns_proc.php?id=".$packinglistreturns->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->itemid)){
		$error=" Item must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" Quantity must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppackinglistreturns=$_SESSION['shppackinglistreturns'];

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
	
	$shppackinglistreturns[$it]=array('remarks'=>"$obj->remarks", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name",'sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'quantity'=>"$obj->quantity", 'boxno'=>"$obj->boxno", 'memo'=>"$obj->memo");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppackinglistreturns']=$shppackinglistreturns;

	$obj->remarks="";
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


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$fleets= new Fleets();
	$fields="assets_fleets.id, assets_fleets.assetid, assets_fleets.fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleets.fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleets.fleetfueltypeid, assets_fleets.fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, assets_fleets.employeeid, assets_fleets.departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

// if(empty($id) and empty($obj->action) and empty($obj->action2)){
//         if(empty($_GET['edit'])){
//                 $obj->action="Save & Move to Next Box";
// 		$obj->action3="Save & Move to Next Customer";
// 
//                 $obj->boxno=1;
// 
//         }
//         else{
//                 $obj=$_SESSION['obj'];
//         }
//         if(empty($obj->action2) and empty($_GET['edit']))
//                 $_SESSION['shppackinglistreturns']="";
// }
// elseif(!empty($id) and empty($obj->action)){
//         $obj->action="Update";
// }
// elseif(!empty($obj->retrieve) and !empty($obj->action2)){
//   $obj->action="Update";
// }


if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$packinglistreturns = new Packinglistreturns();
		$fields="pos_packinglistdtreturns.id, pos_packinglistreturns.boxno, pos_packinglistreturns.orderno, pos_packinglistreturns.customerid, pos_packinglistreturns.documentno, pos_items.id as itemid,pos_items.name itemname, pos_sizes.id sizeid, pos_sizes.name sizename, pos_packinglistdtreturns.quantity, pos_packinglistreturns.boxno, pos_packinglistdtreturns.memo, pos_packinglistreturns.packedon, pos_packinglistreturns.ipaddress, pos_packinglistreturns.createdby, pos_packinglistreturns.createdon, pos_packinglistreturns.lasteditedby, pos_packinglistreturns.lasteditedon";
		$join=" left join pos_packinglistdtreturns on pos_packinglistdtreturns.packinglistreturnid=pos_packinglistreturns.id left join pos_items on pos_packinglistdtreturns.itemid=pos_items.id left join pos_sizes on pos_sizes.id=pos_packinglistdtreturns.sizeid  ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_packinglistreturns.documentno='$obj->invoiceno'";
		if(!empty($obj->box))
		  $where.=" and pos_packinglistreturns.boxno='$obj->box' ";
		$packinglistreturns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$packinglistreturns->result;
		if($packinglistreturns->affectedRows==0){
			$obj->action="Save & Move to Next Box";
			$obj->action3="Save & Move to Next Customer";
			$packinglistreturns = new Packinglistreturns();
			$fields=" pos_packinglistreturns.customerid, pos_packinglistreturns.documentno, pos_packinglistreturns.packedon, pos_packinglistreturns.ipaddress, pos_packinglistreturns.createdby, pos_packinglistreturns.createdon, pos_packinglistreturns.lasteditedby, pos_packinglistreturns.lasteditedon";
			$join="   ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where pos_packinglistreturns.documentno='$obj->invoiceno'";
			$packinglistreturns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$ob = $packinglistreturns->fetchObject;
		}
		else{
		      if($obj->returns==1)
			$obj->action="Save Returns";
		      else
			$obj->action="Update";
		
		}
		$it=0;
		$shppackinglistreturns=array();
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$row->total=$row->quantity*$row->costprice;
			$shppackinglistreturns[$it]=array('remarks'=>"$ob->remarks", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'sizeid'=>"$ob->sizeid", 'sizename'=>"$ob->sizename", 'quantity'=>"$ob->quantity",'boxno'=>"$ob->boxno", 'memo'=>"$ob->memo");

			$it++;
		}

		//for autocompletes
		$customers = new Customers();
		$fields=" * ";
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
		
		
		$_SESSION['shppackinglistreturns']=$shppackinglistreturns;
	}
}

if(!empty($id)){
	$packinglistreturns=new Packinglistreturns();
	$where=" where id=$id ";
	$fields="pos_packinglistreturns.id, pos_packinglistreturns.documentno, pos_packinglistreturns.orderno, pos_packinglistreturns.boxno, pos_packinglistreturns.customerid, pos_packinglistreturns.packedon, pos_packinglistreturns.fleetid, pos_packinglistreturns.employeeid, pos_packinglistreturns.remarks, pos_packinglistreturns.ipaddress, pos_packinglistreturns.createdby, pos_packinglistreturns.createdon, pos_packinglistreturns.lasteditedby, pos_packinglistreturns.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$packinglistreturns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$packinglistreturns->fetchObject;

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
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
	$fleets = new Fleets();
	$fields=" * ";
	$where=" where id='$obj->fleetid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$fleets->fetchObject;

	$obj->fleetname=$auto->name;
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
	
if($obj->action=="Raise Invoice"){
  $shppackinglistreturns=$_SESSION['shppackinglistreturns'];
  
  $num = count($shppackinglistreturns);
  $i=0;
  while($i<$num){
  
      $ob->customerid = $obj->customerid;
      $ob->customername = $obj->customername;
      $ob->address = $obj->address;
      $ob->tel = $obj->tel;
      $ob->remarks = $obj->remarks;
      $ob->packingno=$obj->documentno;
      $_SESSION['ob']=$ob;
      
      //$shppackinglistreturns[$i]['boxno']=$obj->boxno;
      
   // if(isset($_POST[$shppackinglistreturns[$i]['id']])){
      $items = new Items();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglistreturns[$i]['itemid']."'";
      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $items=$items->fetchObject;
      $shppackinglistreturns[$i]['tax']=$items->tax;
      
      //get Season
      $customerseasons = new Customerseasons();
      $customerseasons = $customerseasons->getCustomerSeason($obj->customerid,$obj->packedon);
      
      //get customer prices for the season
      $customerprices = new Customerprices();
      $price = $customerprices->getPrices($obj->customerid, $shppackinglistreturns[$i]['itemid'],$shppackinglistreturns[$i]['sizeid'],$customerseasons->seasonid);
      $shppackinglistreturns[$i]['price']=$price->price;
      $shppackinglistreturns[$i]['total']=$price->price*$shppackinglistreturns[$i]['quantity'];
      
      $shpinvoices[$i]=$shppackinglistreturns[$i];
   // }
    $i++;
  }
  
  
  $_SESSION['shpinvoices']=$shpinvoices;
  $_SESSION['shppackinglistreturns']="";
  
  redirect("../invoices/addinvoices_proc.php?invoice=1");
}

if(!empty($ob->orderno)){
  $obj->orderno=$ob->orderno;
  $packinglistreturns = new Packinglistreturns();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where orderno='$obj->orderno'";
  $packinglistreturns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  if($packinglistreturns->affectedRows>0){
    $packinglistreturns = $packinglistreturns->fetchObject;
    $obj->documentno=$packinglistreturns->documentno;
    $obj->boxno=$packinglistreturns->boxno+1;    
    
  }
  
  $customers = new Customers();
  $fields=" * ";
  $where=" where id='$ob->customerid'";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $customers = $customers->fetchObject;
  
  $obj->customerid=$customers->id;
  $obj->customername=$customers->name;
  $obj->tel=$customers->tel;
  $obj->remarks=$customers->remarks;
  $obj->address=$customers->address;
  
  $obj->boxno=$ob->boxno;
  
}
if(empty($obj->iterator))
{
  $obj->iterator=0;
}


if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2)){
	if(empty($obj->confirm) and empty($ob->pck))
	  $_SESSION['shppackinglistreturns']="";
	else{
	  $obj=$_SESSION['ob'];
	  $obj->packingno=$obj->documentno;
	  $obj->documentno=$defs->documentno;
	  $shppackinglistreturns=$_SESSION['shppackinglistreturns'];
	  $obj->iterator=count($shppackinglistreturns);
	   $obj->retrieve="";
	}
	$obj->confirmedon=date("Y-m-d");	
  
      }
      $obj->action="Save Returns";
  } 
  else{
    $obj=$_SESSION['obj'];
   
  }
  
}
else{
if(empty($obj->returns))
  $obj->action="Update";
}



$page_title="Packinglistreturns ";
include "addpackinglistreturns.php";
?>

