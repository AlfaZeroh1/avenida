<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orders_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once "test.php";
require_once "testvat.php";

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../orderdetails/Orderdetails_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");
require_once("../../../Mobile_Detect.php");
$detect = new Mobile_Detect;

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8665";//Edit
}
else{
	$auth->roleid="8663";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);

$open=1;

//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->confirm)){
  $obj->confirm=$ob->confirm;
}

if(!empty($ob->orderno)){
  $obj->invoiceno=$ob->orderno;
  $obj->action="Filter";
  $obj->retrieve=1;
}
if(!empty($ob->copy)){
  $obj = $_SESSION['ob'];
  $obj->copy=1;
  //$obj->action="Save";
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
	

}

if($obj->action=="PRINT"){
  $obj->doc=$obj->orderno;
  if(checkSession()){
    printOrder($obj,1,true,true);
  }
}

if($obj->action=="PRINT VAT RECEIPT"){
  $obj->doc=$obj->orderno;
  if(checkSession()){
    printOrderVAT($obj,1,true);
  }
}
	
if($obj->action=="Save"){
	$orders=new Orders();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shporders=$_SESSION['shporders'];logging(serialize($shporders));
	$error="";//$orders->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shporders)){
		$error="No items in the sale list!";
	}
        
	else{
		$orders=$orders->setObject($obj);
		if($obj->documentno=$orders->add($orders,$shporders)){
// 			$error=SUCCESS;
			$saved="Yes";
			unset($_SESSION['shporders']);
			$obj->doc=$obj->documentno;
			
			logging("=======================".$obj->doc.":".$obj->documentno);
			
			if(checkSession()){
			  
			  $query="select distinct pos_orderdetails.brancheid2 from pos_orderdetails left join pos_orders on pos_orderdetails.orderid=pos_orders.id where pos_orders.orderno='$obj->doc'";//logging($query);
			  $res = mysql_query($query);
			  while($row=mysql_fetch_object($res)){
			    printOrder($obj,1,false,false,$row->brancheid2);
			  }
			}
			if(!empty($_SESSION['ismobile']))
			  redirect("../../auth/users/logout.php");
			else
			  redirect("orderss.php");
			
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update" or $obj->action=="CANCEL"){
	$orders=new Orders();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$orders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$orders=$orders->setObject($obj);
		$orders->action=$obj->action;
		$shporders=$_SESSION['shporders'];
		if($orders->edit($orders,"",$shporders)){
			$error=UPDATESUCCESS;
			
			unset($_SESSION['shporders']);
			
// 			$saved="Yes";
			redirect("addorders_proc.php?error=".$error);
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
	elseif(!checkQuantity($obj)){
	  $error="Not enough stock under the section";
	  echo "7|$error";
	}
	else{
	
	  $_SESSION['obj']=$obj;
	  if(empty($obj->iterator))
		  $it=0;
	  else
		  $it=$obj->iterator;
		  
// 	  logging("IT: ".$it);
	  $shporders=$_SESSION['shporders'];

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
	  
	  $find=0;
	  
// 	  logging(print_r($shporders));
	  
	  //check if item already in shop
	  $x = searchForId($obj->itemid,$shporders,"itemid", $obj->warmth);
	  if($x>-1){
	    
	    $shporders[$x]['quantity']+=$obj->quantity;
	    $find=1;
	    
	  }else{
	    
	    $shporders[$it]=array('id'=>"$ob->id",'itemid'=>"$obj->itemid",'sizeid'=>"$obj->sizeid",'sizename'=>"$sizes->name", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity",'price'=>"$items->retailprice", 'memo'=>"$obj->memo",'warmth'=>"$obj->warmth", 'brancheid2'=>"$obj->brancheid2");
	    
	  }//logging("BRANCH: ".$obj->brancheid2);
	  $it++;
		  $obj->iterator=$it;
	  $_SESSION['shporders']=$shporders;
// 	  logging(serialize($shporders));
	  if(empty($items->retailprice))
	    $items->retailprice=0;
	  
	  if($obj->warmth==1)
	    $items->warmth="Warm";
	  elseif($obj->warmth==2)
	    $items->warmth="Cold";
	  elseif($obj->warmth==3)
	    $items->warmth="WETFRY";
	  elseif($obj->warmth==4)
	    $items->warmth="DRYFRY";
	  elseif($obj->warmth==5)
	    $items->warmth="BOILED";
	  elseif($obj->warmth==6)
	    $items->warmth="CHOMA";
	    
	    
	  echo "$find|".$items->name."|".$obj->quantity."|".$items->retailprice."|".$items->id."|".$items->warmth."|".$obj->warmth;


	  $obj->itemid="";
	  $obj->sizeid="";
	  $obj->total=0;
	  $obj->quantity="";
	  $obj->memo="";
	  $obj->price="";
	  
// 	  logging(serialize($shporders));
 	
 }
 
}

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$orders = new Orders();
		$fields="pos_orderdetails.id, pos_orders.id orderid, pos_orders.orderno,pos_orders.tableno, crm_customers.id as customerid, pos_orderdetails.quantity, pos_orderdetails.price, pos_orderdetails.memo, inv_items.id itemid, inv_items.name itemname, pos_orders.orderedon, pos_orders.remarks, pos_orders.ipaddress, pos_orders.createdby, pos_orders.createdon, pos_orders.lasteditedby, pos_orders.lasteditedon, sys_branches.name branchename, pos_orders.brancheid, pos_orders.brancheid2 ";
		$join=" left join crm_customers on pos_orders.customerid=crm_customers.id left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join inv_items on inv_items.id=pos_orderdetails.itemid left join sys_branches on sys_branches.id=pos_orders.brancheid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_orders.orderno='$obj->invoiceno'";
		$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$orders->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$total = $ob->price*$ob->quantity;
			$shporders[$it]=array('id'=>"$ob->id",'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'sizeid'=>"$ob->sizeid", 'sizename'=>"$ob->sizename", 'quantity'=>"$ob->quantity" ,'price'=>"$ob->price", 'memo'=>"$ob->memo",'total'=>"$total");

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
		$auto->customerid=$auto->id;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		$obj->remarks = $ob->remarks;
		$obj->id=$ob->orderid;
		
		$obj->itemid="";
		$obj->sizeid="";
		$obj->total=0;
		$obj->quantity="";
		$obj->memo="";

		$obj->iterator=$it;
		
		$obj->action="Update";
		//$obj->retrieve='';
		
		$_SESSION['obj']=$obj;
		$_SESSION['shop']=$shporders;
	}
}

if($obj->action=="Confirm Order"){
  $shporders=$_SESSION['shporders'];
  $_SESSION['shpconfirmedorders']="";
  $num = count($shporders);
  $i=0;
  $j=0;
  
  $ob->orderno = $obj->orderno;
  $ob->tableno = $obj->tableno;
  $ob->orderedon=$obj->orderedon;
  $ob->remarks=$obj->remarks;
  $ob->customerid = $obj->customerid;
  $ob->customername = $obj->customername;
  $ob->requisitionno = $obj->documentno;
  
  
  while($i<$num){        
      
    if(isset($_POST[$shporders[$i]['id']])){
          $shpconfirmedorders[$j]=$shporders[$i];
          $j++;
    }
    $i++;
  }
  $ob->iterator=$j;
  $_SESSION['ob']=$ob;
  $_SESSION['shpconfirmedorders']=$shpconfirmedorders;
  $_SESSION['shporders']="";
  
  redirect("../confirmedorders/addconfirmedorders_proc.php?confirm=1");
}

if($obj->action=="Copy Order"){
  $shporders=$_SESSION['shporders'];
  $num = count($shporders);
  $i=0;
  $j=0;
 
   $def=mysql_fetch_object(mysql_query("select (max(orderno)+1) orderno from pos_orders"));
   if($def->orderno == null){
		$def->orderno=1;
	}
  
  $ob->orderno = $def->orderno;
  $ob->tableno = $def->tableno;
  $ob->orderedon=$obj->orderedon;
//   $ob->remarks=$obj->remarks;
  $ob->customerid = $obj->customerid;
  $ob->customername = $obj->customername;
//   $ob->requisitionno = $obj->documentno;
  
  
  while($i<$num){        
      
    if(isset($_POST[$shporders[$i]['id']])){
          $shporder[$j]=$shporders[$i];
          $j++;
    }
    $i++;
  }
  $ob->iterator=$j;
  $_SESSION['ob']=$ob;
  $_SESSION['shporders']=$shporder;
  
  redirect("addorders_proc.php?copy=1");
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
	$orders=new Orders();
	$where=" where id=$id ";
	$fields="pos_orders.id, pos_orders.orderno,pos_orders.tableno, pos_orders.customerid, pos_orders.orderedon, pos_orders.remarks, pos_orders.ipaddress, pos_orders.createdby, pos_orders.createdon, pos_orders.lasteditedby, pos_orders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$orders->fetchObject;

	//for autocompletes
	$customers = new Customers();
	$fields=" id, name ";
	$where=" where id='$obj->customerid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$customers->fetchObject;

	$obj->customername=$auto->name;
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
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
}

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2) and empty( $obj->copy)){
	$_SESSION['shporders']="";
			  
	$defs=mysql_fetch_object(mysql_query("select (max(orderno)+1) orderno from pos_orders"));
	if($defs->orderno == null){
		$defs->orderno=1;
	}
	$obj->orderno=$defs->orderno;

	$obj->orderedon=date("Y-m-d");
	
	unset($_SESSION['shop']);
	unset($_SESSION['shporders']);
	
	//get shiftid
	$query="select pos_teams.id, sys_branches.id brancheid, sys_branches.name branchename, pos_teamroles.type teamroletype from pos_teams left join pos_teamdetails on pos_teamdetails.teamid=pos_teams.id left join sys_branches on sys_branches.id=pos_teams.brancheid left join pos_teamroles on pos_teamroles.id=pos_teamdetails.teamroleid where (pos_teams.status=0 or pos_teams.status is null or pos_teams.status='') and pos_teamdetails.employeeid='".$_SESSION['employeeid']."'";
	$rs = mysql_query($query);
	if(mysql_affected_rows()>0){
	  $rw=mysql_fetch_object($rs);
	  $obj->shiftid=$rw->id;
	  $obj->brancheid=$rw->brancheid;
	  $obj->brancheid2=$rw->brancheid;
	  $obj->branchename=$rw->branchename;
	  $obj->teamroletype=$rw->teamroletype;
	  
	  $_SESSION['brancheid']=$obj->brancheid;
	}else{
	  $error="NO ACTIVE SHIFT for ".$_SESSION['employeename'];
	  $open=0;
	}
	 
	
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
if (!empty( $obj->copy)){
$obj->action="Save";
}

function checkSession(){
  $query="select * from sys_tracksessions";
 return true;
}

function checkQuantity($obj){
   
   $warmth="''";
   $qnt = $obj->quantity;
   
  $query="select * from inv_items where id='$obj->itemid'";
  $r = mysql_fetch_object(mysql_query($query)); 
  
  if($obj->brancheid2!=27 and $obj->brancheid2!=28)
    return true;

  //check if the product is one of the composites
  $query="select * from inv_compositeitems where itemid='$obj->itemid' or itemid2='$obj->itemid'";//logging($query);
  $res = mysql_query($query);
  
  $quantity=0;
  $quantity1=0;
  
  $shporders = $_SESSION['shporders']; 
  
  if(mysql_affected_rows()>0){
    while($row=mysql_fetch_object($res)){

      $it = searchForId3($row->itemid,$shporders,"itemid");
  
      $quantity1+=$shporders[$it]['quantity'];
      
      $it = searchForId3($row->itemid2,$shporders,"itemid");
  
      $quantity1+=$shporders[$it]['quantity']/$row->quantity;
      
      $query="select * from inv_branchstocks where brancheid='$obj->brancheid2' and itemid='$row->itemid'";
      $r1 = mysql_fetch_object(mysql_query($query));      
    
      $query="select * from inv_branchstocks where brancheid='$obj->brancheid2' and itemid='$row->itemid2'";
      $r2 = mysql_fetch_object(mysql_query($query));
      if(($row->itemid==$obj->itemid)){
	$quantity+=$r2->quantity/$row->quantity;
	$quantity+=$r1->quantity;
      }  
      if(($row->itemid2==$obj->itemid)){
	$quantity+=$r1->quantity;
	$quantity+=$r2->quantity/$row->quantity;
	
// 	$quantity1 = $quantity1*$row->quantity;
	$qnt = $qnt/$row->quantity;
	
      }
    }
    
  }else{
  
   $it = searchForId3($obj->itemid,$shporders,"itemid");
    $quantity1+=$shporders[$it]['quantity'];
  
    $query="select * from inv_branchstocks where brancheid='$obj->brancheid2' and itemid='$obj->itemid'";
    $r = mysql_fetch_object(mysql_query($query));
    $quantity=$r->quantity;
  
 }
//  logging("QNT: ITM1: $row->itemid = ITM2:$row->itemid2 = Consumed: ".$quantity1." == Available: ".$quantity." == qnt: ".$qnt);
  if(($quantity-$quantity1)<$qnt)
    return false;
  else
    return true;

}

$page_title="Orders ";
if(empty($obj->type))
  include "addorder.php";
?>