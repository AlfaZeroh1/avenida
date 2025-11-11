<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Packinglists_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/customerprices/Customerprices_class.php");
require_once("../../crm/customerseasons/Customerseasons_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/fleets/Fleets_class.php");
require_once("../packinglistdetails/Packinglistdetails_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/itemstocks/Itemstocks_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../sys/ipaddress/Ipaddress_class.php");
require_once("../../pos/invoices/Invoices_class.php");
require_once("../../post/barcodes/Barcodes_class.php");

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

if(!empty($ob->boxno)){
  $obj->boxno=$ob->boxno;
}

if(!empty($ob->orderno)){
  $obj->orderno=$ob->orderno;
}

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
// $error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
if(empty($obj->action) and empty($obj->action2)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_packinglists"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->packedon=date("Y-m-d");

}

if(!empty($ob->packingno)){
  $obj->invoiceno=$ob->packingno;
  $obj->invoice=$ob->packingno;
  $obj->boxno=$ob->box;
  if(empty($ob->boxing)){
    $obj->action="Filter";
    $obj->retrieve=1;
  }
}

if(!empty($ob->boxno)){
  $obj->boxno=$ob->boxno;
}
	
if($obj->action=="Save" or $obj->action=="Save & Move to Next Box" or $obj->action3=="Save & Move to Next Customer" or $obj->action=="Save Returns"){
	$packinglists=new Packinglists();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shppackinglists=$_SESSION['shppackinglists'];//print_r($shppackinglists);
	$error=$packinglists->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppackinglists)){
		$error="No items in the sale list!";
	}
	else{
		$packinglists=$packinglists->setObject($obj);
		$packinglists->invoiceno=$obj->invoiceno;
		$packinglists->invoice=$obj->invoice;
		if($packinglists->add($packinglists,$shppackinglists)){
			$error=SUCCESS;
			
			$next=$obj->boxno+1;
			$packing=$obj->documentno;
			
			$obj->invoice=$obj->documentno;
						
			if($obj->action=="Save & Move to Next Box"){
			  $_SESSION['shppackinglists']="";
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

if($obj->action=="Update Memo"){
    $packinglists=new Packinglists();
    $obj->lasteditedby=$_SESSION['userid'];
    $obj->lasteditedon=date("Y-m-d H:i:s");

    $error=$packinglists->validate($obj);
    if(!empty($error)){
            $error=$error;
    }
    else{
            $packinglists=$packinglists->setObject($obj);
            $packinglists->invoiceno=$obj->invoiceno;
            $packinglists->invoice=$obj->invoice;
            $shppackinglists=$_SESSION['shppackinglists'];
            if($packinglists->edit($packinglists,"",$shppackinglists,true)){
            }
    }
}
	
if($obj->action=="Update"){
	$packinglists=new Packinglists();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$packinglists->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$packinglists=$packinglists->setObject($obj);
		$packinglists->invoiceno=$obj->invoiceno;
		$packinglists->invoice=$obj->invoice;
		$shppackinglists=$_SESSION['shppackinglists'];
		if($packinglists->edit($packinglists,"",$shppackinglists)){
			$error=UPDATESUCCESS;
			//redirect("addpackinglists_proc.php?id=".$packinglists->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

// 	$barcodes = new Barcodes();
// 	$obj->barcodes = $obj->barcode;
// // 	$obj->barcode =substr($obj->barcode,0,-1);
//         $shppackinglist=$_SESSION['shppackinglists'];
// 	$errors = $barcodes->checkBarCodes($obj,'outs',$shppackinglist);
// 	
// 	$error="";
// 	
// 	$err = explode("|",$errors);
	
	if(empty($obj->itemid)){
		$error=" Item must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" Quantity must be provided";
	}
	elseif(empty($obj->barcode2)){
		$error=" Employee barcode must be Scanned!";
	}
// 	elseif($err[0]=="1"){
// 	  $error=$err[1];
// 	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppackinglists=$_SESSION['shppackinglists'];
// print_r($shppackinglists);


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
	
	$employees = new Employees();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->employeeids'";
	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employees=$employees->fetchObject;
	
	$shppackinglists[$it]=array('remarks'=>"$obj->remarks", 'memo'=>"$obj->memo",'itemid'=>"$obj->itemid", 'itemname'=>"$items->name",'sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'quantity'=>"$obj->quantity", 'boxno'=>"$obj->boxno", 'memo'=>"$obj->memo",'employeeid'=>"$obj->employeeids", 'datecode'=>"$obj->datecode", 'employeename'=>"$employees->name",'downsize'=>"$obj->downsize",'barcode'=>"$obj->barcode=$obj->barcode2");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppackinglists']=$shppackinglists;

 	
	$obj->remarks="";
 	$obj->itemid="";
 	$obj->quantity="";
 	$obj->memo="";
 }
//  logging($error);
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
//                 $_SESSION['shppackinglists']="";
// }
// elseif(!empty($id) and empty($obj->action)){
//         $obj->action="Update";
// }
// elseif(!empty($obj->retrieve) and !empty($obj->action2)){
//   $obj->action="Update";
// }


if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$packinglists = new Packinglists();
		$fields="pos_packinglistdetails.id, pos_packinglists.boxno,pos_packinglists.memo, pos_packinglists.mixedbox, pos_packinglists.status, pos_item.name itemnam, pos_item.id item, pos_packinglists.orderno, pos_packinglists.customerid, pos_packinglists.documentno, pos_items.id as itemid,pos_items.name itemname, pos_sizes.id sizeid, pos_sizes.name sizename, pos_packinglistdetails.quantity, pos_packinglists.boxno, pos_packinglistdetails.memo, pos_packinglists.packedon, pos_packinglists.ipaddress, pos_packinglists.createdby, pos_packinglists.createdon, pos_packinglists.lasteditedby, pos_packinglists.lasteditedon, pos_packinglistdetails.datecode, pos_packinglistdetails.barcode";
		$join=" left join pos_packinglistdetails on pos_packinglistdetails.packinglistid=pos_packinglists.id left join pos_items on pos_packinglistdetails.itemid=pos_items.id left join pos_sizes on pos_sizes.id=pos_packinglistdetails.sizeid left join pos_items pos_item on pos_item.id=pos_packinglists.item ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_packinglists.documentno='$obj->invoiceno' and pos_packinglists.returns!='1'";
		if(!empty($obj->box))
		  $where.=" and pos_packinglists.boxno='$obj->box' ";
		$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$packinglists->result;
		if($packinglists->affectedRows==0){
			$obj->action="Save & Move to Next Box";
			$obj->action3="Save & Move to Next Customer";
			$packinglists = new Packinglists();
			$fields=" pos_packinglists.customerid, pos_packinglists.documentno, pos_packinglists.packedon, pos_packinglists.ipaddress, pos_packinglists.createdby, pos_packinglists.createdon, pos_packinglists.lasteditedby, pos_packinglists.lasteditedon";
			$join="   ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where pos_packinglists.documentno='$obj->invoiceno'";
			$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$ob = $packinglists->fetchObject;
		}
		else{
		      if($obj->returns==1)
			$obj->action="Save Returns";
		      else
			$obj->action="Update Memo";
		
		}
		$it=0;
		$shppackinglists=array();
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$row->total=$row->quantity*$row->costprice;
			
			$shppackinglists[$it]=array('remarks'=>"$ob->remarks", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'itemnam'=>"$ob->itemnam", 'item'=>"$ob->item",'mixedbox'=>"$ob->mixedbox", 'sizeid'=>"$ob->sizeid", 'sizename'=>"$ob->sizename", 'quantity'=>"$ob->quantity",'boxno'=>"$ob->boxno", 'memo'=>"$ob->memo", 'datecode'=>"$ob->datecode", 'barcode'=>"$ob->barcode");

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
		$auto->code=$auto->code;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		
		$obj->iterator=$it;
		
		
		$_SESSION['shppackinglists']=$shppackinglists;
	}
}

if(!empty($id)){
	$packinglists=new Packinglists();
	$where=" where id=$id ";
	$fields="pos_packinglists.id, pos_packinglists.documentno,pos_packinglists.memo,  pos_packinglists.orderno, pos_packinglists.boxno, pos_packinglists.status, pos_packinglists.customerid, pos_packinglists.packedon, pos_packinglists.fleetid, pos_packinglists.employeeid, pos_packinglists.remarks, pos_packinglists.ipaddress, pos_packinglists.createdby, pos_packinglists.createdon, pos_packinglists.lasteditedby, pos_packinglists.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$packinglists->fetchObject;

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

if($obj->action=="Returns"){
  $shppackinglistreturns = $_SESSION['shppackinglists'];
  $_SESSION['shppackinglistreturns']=$shppackinglistreturns;
  
  $_SESSION['ob']=$obj;
  
  redirect("../packinglistreturns/addpackinglistreturns_proc.php?pck=1");
}
	
if($obj->action=="Raise Invoice"){
  $shppackinglists=$_SESSION['shppackinglists'];
  
  $num = count($shppackinglists);
  $i=0;
  while($i<$num){
  
      $ob->customerid = $obj->customerid;
      $ob->code = $obj->code;
      $ob->customername = $obj->customername;
      $ob->address = $obj->address;
      $ob->tel = $obj->tel;
      $ob->remarks = $obj->remarks;
      $ob->packingno=$obj->documentno;
      $_SESSION['ob']=$ob;
      
      //$shppackinglists[$i]['boxno']=$obj->boxno;
      
   // if(isset($_POST[$shppackinglists[$i]['id']])){
      $items = new Items();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglists[$i]['itemid']."'";
      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $items=$items->fetchObject;
      
      $sizes = new Sizes();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglists[$i]['sizeid']."'";
      $sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $sizes=$sizes->fetchObject;
      $shppackinglists[$i]['sizename']=$sizes->name;
      
      $shppackinglists[$i]['tax']=$items->tax;
      
      $item = new Items();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglists[$i]['itemid']."'";
      $item->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $item=$item->fetchObject;
      
      //get Season
      $customerseasons = new Customerseasons();
      $customerseasons = $customerseasons->getCustomerSeason($obj->customerid,$obj->packedon);
      
      //get customer prices for the season
      $customerprices = new Customerprices();
      if($shppackinglists[$i]['mixedbox']=="Yes"){
	$itemid=$shppackinglists[$i]['item'];
      }else{
	$itemid=$shppackinglists[$i]['itemid'];
	$shppackinglists[$i]['itemnam']=$item->name;
      }
      $price = $customerprices->getPrices($obj->customerid, $itemid,$shppackinglists[$i]['sizeid'],$customerseasons->seasonid);
      $shppackinglists[$i]['price']=$price->price;
      $shppackinglists[$i]['section']=1;
      $shppackinglists[$i]['total']=$price->price*$shppackinglists[$i]['quantity'];
      
      $shpinvoices[$i]=$shppackinglists[$i];
   // }
    $i++;
  }
  
  
  $_SESSION['shpinvoices']=$shpinvoices;
  unset($_SESSION['shppackinglists']);
  unset($_SESSION['shpconsumables']);
  
  redirect("../invoices/addinvoices_proc.php?invoice=1");
}

if($obj->action=="Update Invoice"){
  $shppackinglists=$_SESSION['shppackinglists'];
  
  $num = count($shppackinglists);
  $i=0;
  while($i<$num){
  
      $invoices = new Invoices();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where packingno='$obj->documentno'";
      $invoices->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $invoices=$invoices->fetchObject;
      
      $ob->customerid = $obj->customerid;
      $ob->customername = $obj->customername;
      $ob->address = $obj->address;
      $ob->tel = $obj->tel;
      $ob->remarks = $obj->remarks;
      $ob->packingno=$obj->documentno;
      $ob->documentno=$invoices->documentno;
      $ob->action="Update";
      $_SESSION['ob']=$ob;
      
      //$shppackinglists[$i]['boxno']=$obj->boxno;
      
   // if(isset($_POST[$shppackinglists[$i]['id']])){
      $items = new Items();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglists[$i]['itemid']."'";
      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $items=$items->fetchObject;
      
      $sizes = new Sizes();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglists[$i]['sizeid']."'";
      $sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $sizes=$sizes->fetchObject;
      $shppackinglists[$i]['sizename']=$sizes->name;
      
      $shppackinglists[$i]['tax']=$items->tax;
      
      $item = new Items();
      $fields=" * ";
      $join="  ";
      $groupby="";
      $having="";
      $where=" where id='".$shppackinglists[$i]['itemid']."'";
      $item->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $item=$item->fetchObject;
      
      //get Season
      $customerseasons = new Customerseasons();
      $customerseasons = $customerseasons->getCustomerSeason($obj->customerid,$obj->packedon);
      
      //get customer prices for the season
      $customerprices = new Customerprices();
      if($shppackinglists[$i]['mixedbox']=="Yes"){
	$itemid=$shppackinglists[$i]['item'];
      }else{
	$itemid=$shppackinglists[$i]['itemid'];
	$shppackinglists[$i]['itemnam']=$item->name;
      }
      $price = $customerprices->getPrices($obj->customerid, $itemid,$shppackinglists[$i]['sizeid'],$customerseasons->seasonid);
      $shppackinglists[$i]['price']=$price->price;
      $shppackinglists[$i]['section']=1;
      $shppackinglists[$i]['total']=$price->price*$shppackinglists[$i]['quantity'];
      
      $shpinvoices[$i]=$shppackinglists[$i];
   // }
    $i++;
  }
  
  
  $_SESSION['shpinvoices']=$shpinvoices;
  $_SESSION['shppackinglists']="";
  
  redirect("../invoices/addinvoices_proc.php?invoice=2");
}

if(!empty($ob->orderno)){
  $obj->orderno=$ob->orderno;
  $packinglists = new Packinglists();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where orderno='$obj->orderno'";
  $packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  if($packinglists->affectedRows>0){
    $packinglists = $packinglists->fetchObject;
    $obj->documentno=$packinglists->documentno;
    $obj->boxno=$packinglists->boxno+1;    
    
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
	if(empty($obj->confirm)){
	  $_SESSION['shppackinglists']="";
	  unset($_SESSION['shppackinglists']);
	}
	$obj->confirmedon=date("Y-m-d");	
  
      }
      $obj->action="Save & Move to Next Box";
  } 
  else{
    $obj=$_SESSION['obj'];
   
  }
  
}
else{
if(empty($obj->returns))
  $obj->action="Update Memo";
}

$page_title="Packinglists ";
if($obj->type==2 or !empty($ob->ajax))
  echo $error;
else
  include "addpackinglists.php";
?>

