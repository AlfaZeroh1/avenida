<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sales_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/agents/Agents_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/customerprices/Customerprices_class.php");
require_once("../saledetails/Saledetails_class.php");
require_once("../../pos/sales/Sales_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2206";//Edit
}
else{
	$auth->roleid="2204";//Add
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
	$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from pos_sales where mode='$obj->mode'"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->soldon=date('Y-m-d');

}

if(!empty($ob->action3)){
  
  $it=0;
  $shpsales = array();
  
  $orders = new Orders();
  $fields="pos_orderdetails.id, pos_orders.orderno, crm_customers.id as customerid, pos_orderdetails.quantity, pos_orderdetails.price, pos_orderdetails.memo, inv_items.id itemid, inv_items.name itemname, pos_orderdetails.sizeid sizeid, pos_sizes.name sizename, pos_orders.orderedon, pos_orders.remarks, pos_orders.ipaddress, pos_orders.createdby, pos_orders.createdon, pos_orders.lasteditedby, pos_orders.lasteditedon";
  $join=" left join crm_customers on pos_orders.customerid=crm_customers.id left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join inv_items on inv_items.id=pos_orderdetails.itemid left join pos_sizes on pos_sizes.id=pos_orderdetails.sizeid ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where pos_orders.orderno='$ob->orderno'";
  $orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $res=$orders->result;
  $it=0;
  while($row=mysql_fetch_object($res)){
		  
	  $ob=$row;
	  $total = $ob->price*$ob->quantity;
	  $shpsales[$it]=array('id'=>"$ob->id",'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'sizeid'=>"$ob->sizeid", 'sizename'=>"$ob->sizename", 'quantity'=>"$ob->quantity" ,'retailprice'=>"$ob->price", 'memo'=>"$ob->memo", 'total'=>"$total");

	  $it++;
  }
  
  $ob->action3=1;
  $obj->iterator=$it;
  $_SESSION['shpsales']=$shpsales;
}

if($obj->action=="Save"){
	$sales=new Sales();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpsales=$_SESSION['shpsales'];
	$error=$sales->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpsales)){
		$error="No items in the sale list!";
	}
	else{
		$sales=$sales->setObject($obj);
		if($sales->add($sales,$shpsales)){
			$error=SUCCESS;
			unset($_SESSION['shpsales']);
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sales=new Sales();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sales->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sales=$sales->setObject($obj);
		$shpsales=$_SESSION['shpsales'];
		if($sales->edit($sales,$where="",$shpsales)){
		        $error=SUCCESS;
                        unset($_SESSION['shpsales']);
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	if(empty($obj->memo)){
		$error="Customer must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpsales=$_SESSION['shpsales'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shpsales[$it]=array('quantity'=>"$obj->quantity", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code",'memo'=>"$obj->memo", 'stock'=>"$obj->stock", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'retailprice'=>"$obj->retailprice", 'tradeprice'=>"$obj->tradeprice", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpsales']=$shpsales;

	$obj->quantity="";
 	$obj->itemid="";
 	$obj->itemname="";
 	$obj->retailprice="";
 	$obj->tradeprice="";
 	$obj->total="";
 	$obj->memo="";
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


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$shpsales=array();
		$sales = new Sales();
		$fields="pos_sales.id, pos_sales.documentno, pos_sales.customerid, inv_items.id itemid, inv_items.name itemname, pos_sales.agentid, pos_sales.employeeid, pos_saledetails.quantity, pos_saledetails.retailprice, pos_saledetails.tradeprice, pos_saledetails.total, pos_sales.remarks, pos_sales.mode, pos_sales.soldon, pos_sales.expirydate, pos_saledetails.memo, pos_sales.createdby, pos_sales.createdon, pos_sales.lasteditedby, pos_sales.lasteditedon, pos_sales.ipaddress";
		$join=" left join pos_saledetails on pos_saledetails.saleid=pos_sales.id left join inv_items on inv_items.id=pos_saledetails.itemid  ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_sales.documentno='$obj->invoiceno'";
		$sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$sales->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpsales[$it]=array('quantity'=>"$ob->quantity", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname", 'code'=>"$ob->code", 'stock'=>"$ob->stock", 'tax'=>"$ob->tax", 'discount'=>"$ob->discount", 'retailprice'=>"$ob->retailprice", 'tradeprice'=>"$ob->tradeprice", 'total'=>"$ob->total",'memo'=>"$ob->memo");

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
		$obj->soldon=$ob->soldon;
		
		$currencys = new Currencys();
		$fields="*";
		$join=" ";
		$where=" where id='5' ";
		$having="";
		$groupby="";
		$orderby="";
		$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $currencys->sql;
		$currencys=$currencys->fetchObject;
		$obj->currencyid=$currencys->id;
		$obj->currencyname=$currencys->name;
		$obj->exchangerate=$currencys->rate;
		$obj->exchangerate2=$currencys->eurorate;
		

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);

		$obj->iterator=$it;
		$obj->action="Update";
		
		$_SESSION['shpsales']=$shpsales;
	}
}

if(!empty($id)){
	$sales=new Sales();
	$where=" where id=$id ";
	$fields="pos_sales.id, pos_sales.documentno, pos_sales.customerid, pos_sales.agentid, pos_sales.employeeid, pos_sales.remarks, pos_sales.mode, pos_sales.soldon, pos_sales.expirydate, pos_sales.memo, pos_sales.createdby, pos_sales.createdon, pos_sales.lasteditedby, pos_sales.lasteditedon, pos_sales.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sales->fetchObject;

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
	$agents = new Agents();
	$fields=" * ";
	$where=" where id='$obj->agentid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$agents->fetchObject;

	$obj->agentname=$auto->name;
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
// if(empty($id) and empty($obj->action)){
// 	if(empty($_GET['edit'])){
// 		$ob=$_SESSION['ob'];
// 		$_SESSION['ob']="";
// 		$obj = (object) array_merge((array) $obj, (array) $ob);
// 		$obj->action="Save";
// 		$obj->iterator = count($_SESSION['shpsales']);
// 	}
// 	else{
// 		$obj=$_SESSION['obj'];
// 	}
// }	
// elseif(!empty($id) and empty($obj->action)){
// 	$obj->action="Update";
// }


if(empty($obj->retrieve) and empty($ob->action3)){
  if(empty($_GET['edit'])){
        $currencys = new Currencys();
	$fields="*";
	$join=" ";
	$where=" where id='5' ";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $currencys->sql;
	$currencys=$currencys->fetchObject;
	$obj->currencyid=$currencys->id;
	$obj->currencyname=$currencys->name;
	$obj->exchangerate=$currencys->rate;
	$obj->exchangerate2=$currencys->eurorate;
	
      if(empty($obj->action) and empty($obj->action2)){
      
	if(empty($_GET['raise']))
	  $_SESSION['shpsales']="";
	else{
	  
	  $obj=$_SESSION['ob'];
	  $obj->iterator=count($_SESSION['shpsales']);
	}
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_sales"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->orderedon=date("Y-m-d");	
	
      }
      $obj->action="Save";
      
  } 
  else{
    $obj=$_SESSION['obj'];
    $obj->edit=$_GET['edit'];
  }
  
}
else{  
    if(empty($ob->action3))
      $obj->action="Update";
    else
      $obj->action="Save";
}
		
$page_title="Sales ";
include "addsales.php";
?>