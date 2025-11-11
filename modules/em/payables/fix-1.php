<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../em/housetenants/Housetenants_class.php");
require_once("../../em/rentaltypes/Rentaltypes_class.php");
require_once("../../em/plotutilitys/Plotutilitys_class.php");
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../sys/transactions/Transactions_class.php';
require_once '../../em/houseutilitys/Houseutilitys_class.php';
require_once '../../em/houses/Houses_class.php';
require_once '../../sys/config/Config_class.php';
require_once '../../em/tenantpayments/Tenantpayments_class.php';
require_once '../../em/tenantdeposits/Tenantdeposits_class.php';
require_once ("../../fn/exptransactions/Exptransactions_class.php");
require_once ("../../em/paymentterms/Paymentterms_class.php");
require_once ("../../sys/paymentmodes/Paymentmodes_class.php");
require_once ("../../em/plots/Plots_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once ("../../em/tenants/Tenants_class.php");
require_once ("../../fn/inctransactions/Inctransactions_class.php");
require_once ("../../fn/payments/Payments_class.php");
require_once ("../../crm/customers/Customers_class.php");
require_once ("../../fn/loans/Loans_class.php");
require_once("../../em/landlordpayables/Landlordpayables_class.php");
require_once("../../em/landlords/Landlords_class.php");
require_once("../../em/houserentings/Houserentings_class.php");
require_once("../../em/landlordpayments/Landlordpayments_class.php");
require_once("../../em/landlordpayables/LandlordpayablesDBO.php");
require_once("../../fn/incomes/Incomes_class.php");
require_once("../../fn/vats/Vats_class.php");

//connect to db
$db=new DB();

// //get hold of landlord balances
// echo "Dropping tmp\n";
// mysql_query("drop table if exists tmp");
// echo "Creating tmp\n";
// mysql_query("create table tmp as select * from em_landlordpayables where remarks=''");
// echo "Truncating Landlord Payables\n";
// mysql_query("truncate em_landlordpayables");
// echo "Truncating General Journals\n";
// mysql_query("truncate fn_generaljournals");
// 
// mysql_query("insert into fn_generaljournalaccounts(refid,name,acctypeid) select id,concat(em_tenants.code,' ',concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname))) name,32 from em_tenants where id not in(select refid from fn_generaljournalaccounts where acctypeid=32)");
// mysql_query("insert into fn_generaljournalaccounts(refid,name,acctypeid) select id,concat(em_landlords.code,' ',concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname))) name,33 from em_landlords where id not in(select refid from fn_generaljournalaccounts where acctypeid=33)");
// mysql_query("insert into fn_generaljournalaccounts(refid,name,acctypeid) select id,name,1 from fn_incomes where id not in(select refid from fn_generaljournalaccounts where acctypeid=1)");
// mysql_query("update em_tenantpayments set imprestaccountid=2 where paymentmodeid=7 and imprestaccountid is null");
// mysql_query("update em_landlordpayments set imprestaccountid=2 where paymentmodeid=7 and imprestaccountid is null");
// 
// //handle landlord payables for balances
// echo "Recreating Landlord Balances\n";
// 
// $query="select distinct documentno from tmp order by documentno";
// $res=mysql_query($query);
// while($row=mysql_fetch_object($res)){
//   //Get transaction Identity
//   echo " Landlord Balances: ".$row->documentno."\n";
//   $sql = "select * from tmp where documentno='$row->documentno'";
//   $rs=mysql_query($sql);
//   $it=0;
//   while($rw = mysql_fetch_object($rs)){   
//     $obj = $rw;
//     $shplandlordpayables[$it]=array('paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'plotid'=>"$obj->plotid", 'plotname'=>"$plots->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");
//     $it++;
//   }
//   $obj->iterator=$it-1;
//   $lpayables = new Landlordpayables();
//   $obj->id="";
//   $lpayables->setObject($obj);
//   $lpayables->add($lpayables,$shplandlordpayables);
//   
// }
// 
// mysql_query("drop table tmp;");
// 
// //handles all tenant invoices
// $payables = new Payables();
// $fields=" distinct documentno ";
// $where="  ";
// $join="";
// $having="";$shpinctransactions[$it]=array('incomeid'=>"$obj->incomeid", 'incomename'=>"$incomes->name",'paymentid'=>"$obj->paymentid",'paymentname'=>"$payments->name",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$obj->quantity", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo", 'total'=>"$obj->total",'month'=>"$obj->month",'year'=>"$obj->year");

 	//$it++;
// $groupby=" ";
// $orderby=" order by documentno ";
// $payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	
// while($rw=mysql_fetch_object($payables->result)){
//       echo "Tenant Invoices $rw->documentno\n";
// 	$payable = new Payables();
// 	$fields=" * ";
// 	$where=" where documentno='$rw->documentno' ";
// 	$join="";
// 	$having="";
// 	$groupby="  ";
// 	$orderby="";
// 	$payable->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	$it=0;
// 	while($row = mysql_fetch_object($payable->result)){
// 
// 	  $shppayables[$it]=array('vatclasseid'=>"$row->vatclasseid", 'mgtfee'=>"$row->mgtfee", 'mgtfeevatclasseid'=>"$row->mgtfeevatclasseid", 'houseid'=>"$row->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$row->mgtfeeamount", 'vatamount'=>"$row->vatamount", 'mgtfeevatamount'=>"$row->mgtfeevatamount", 'paymenttermid'=>"$row->paymenttermid", 'paymenttermname'=>"$row->paymenttermname", 'quantity'=>"$row->quantity", 'amount'=>"$row->amount", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$ob->createdby",'createdon'=>"$ob->createdon");
// 	  $it++;
// 	  $obj = $row;
// 	}
// 	
// 	$obj->transactdate=$obj->invoicedon;
// 	$obj->iterator=$it-1;
// 	$obj->id="";
// 	$pay = new Payables();
// 	$pay = $pay->setObject($obj);
// 	$pay->add($pay,$shppayables,false);
// }

mysql_query("drop table if exists tmps;");
mysql_query("create table tmps as select * from fn_inctransactions where ipaddress!=''");
mysql_query("truncate fn_inctransactions");

$query="select distinct documentno from tmps";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $sql="select * from tmps where documentno='$row->documentno'";
  $rs=mysql_query($sql);
  $it=0;
  $shpinctransactions=array();
  while($rw=mysql_fetch_object($rs)){
    echo "Incomes ".$row->documentno;
    $obj = $rw;
    $shpinctransactions[$it]=array('incomeid'=>"$obj->incomeid", 'incomename'=>"$incomes->name",'paymentid'=>"$obj->paymentid",'paymentname'=>"$payments->name",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$obj->quantity", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo", 'total'=>"$obj->total",'month'=>"$obj->month",'year'=>"$obj->year");

 	$it++;
  }
  $obj->iterator=$it-1;
  $obj->id="";
  $inc = new Inctransactions();
  $inc = $inc->setObject($obj);
  $inc->add($inc,$shpinctransactions);
}
	
	
$it=0;
//handles all tenant payments
$tenantpayments = new Tenantpayments();
$fields=" distinct documentno ";
$where=" ";
$join="";
$having="";
$groupby="  ";
$orderby=" order by documentno ";
$tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby); 
while($rw = mysql_fetch_object($tenantpayments->result)){
$it=0;

echo "Tenant Payments: ".$rw->documentno."\n";
  
	  $tenantpayment = new Tenantpayments();
	  $fields=" * ";
	  $where=" where documentno='$rw->documentno' ";
	  $join="";
	  $having="";
	  $groupby="  ";
	  $orderby="";
	  $tenantpayment->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  
	  $shptenantpayments=array();
	  while($row=mysql_fetch_object($tenantpayment->result)){
	    
	    $obj = $row;
	    $houses = new Houses();
	    $fields=" * ";
	    $join="";
	    $groupby="";
	    $having="";
	    $where=" where id='$obj->houseid'";
	    $houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	    $houses=$houses->fetchObject;
	    
	    $paymentterms = new Paymentterms();
	    $fields=" * ";
	    $join="";
	    $groupby="";
	    $having="";
	    $where=" where id='$obj->paymenttermid'";
	    $paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	    $paymentterms=$paymentterms->fetchObject;
	  
	    $shptenantpayments[$it]=array('paymenttermid'=>"$obj->paymenttermid",'houseid'=>"$obj->houseid", 'housename'=>"$houses->name", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks", 'month'=>"$obj->month", 'year'=>"$obj->year", 'total'=>"$obj->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");
	    
	    $it++;
	  }
	  
	  $obj->transactdate=$obj->paidon;
	  $obj->iterator=$it-1;
	  $obj->id="";
	  
	  $tn = new Tenantpayments();
	  $tn = $tn->setObject($obj);
	  $tn->retrieve=1;
	  if(count($shptenantpayments)>0)
	  $tn->add($tn,$shptenantpayments,false);
	      
}

/*
//handles landlord payments
$landlordpayments = new Landlordpayments();
$fields="distinct documentno ";
$where="   ";
$join="";
$having="";
$groupby="  ";
$orderby=" order by documentno ";
$landlordpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
while($rw=mysql_fetch_object($landlordpayments->result)){

	echo "Landlord Payments: ".$rw->documentno."\n";

	$landlordpayment = new Landlordpayments();
	$fields="* ";
	$where=" where documentno='$rw->documentno'  ";
	$join="";
	$having="";
	$groupby="  ";
	$orderby="";
	$landlordpayment->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	
	$it=0;
	while($row = mysql_fetch$it=0;_object($landlordpayment->result)){
	
	  $obj = $row;
	  
	  $paymentterms = new Paymentterms();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$obj->paymenttermid'";
	  $paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $paymentterms=$paymentterms->fetchObject;
	  
	  $plots = new Plots();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$obj->plotid'";
	  $plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $plots=$plots->fetchObject;

	  $shplandlordpayments[$it]=array('paymenttermid'=>"$obj->paymenttermid",'landlordname'=>"$obj->landlordname", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'plotid'=>"$obj->plotid", 'plotname'=>"$plots->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

	  $it++;
	}
	
	$obj->transactdate=$obj->paidon;
	$obj->iterator=$it-1;
	$obj->id="";
	$ln = new Landlordpayments();
	$ln = $ln->setObject($obj);
	$ln->add($ln, $shplandlordpayments,"",false);
}
	
mysql_query("update fn_exptransactions set purchasemodeid=1");
mysql_query("update fn_exptransactions set imprestaccountid=2 where paymentmodeid=7 and imprestaccountid is null");
mysql_query("insert into fn_generaljournalaccounts(refid,name,acctypeid) select id,name,4 from fn_expenses where id not in(select refid from fn_generaljournalaccounts where acctypeid=4)");
$it=0;
$exptransactions = new Exptransactions();
$fields="distinct voucherno documentno";
$where=" where voucherno>0 ";
$join="";
$having="";
$groupby="  ";
$orderby=" order by voucherno ";
$exptransactions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($rw = mysql_fetch_object($exptransactions->result)){
  $it=0;
    
  $exptransaction = new Exptransactions();
  $fields="*";
  $where=" where voucherno='$rw->documentno' ";
  $join="";
  $having="";
  $groupby=" ";
  $orderby="";
  $exptransaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  echo "PLot Expenses: ".$rw->documentno."\n";
  
  while($row=mysql_fetch_object($exptransaction->result)){
  
    $obj = $row;
    
    $expenses = new Expenses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->expenseid'";
	$expenses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$expenses=$expenses->fetchObject;
	
	$plots = new Plots();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->plotid'";
	$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$plots=$plots->fetchObject;
	
	$paymentterms = new Paymentterms();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->paymenttermid'";
	$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentterms=$paymentterms->fetchObject;
	
	$payments = new Payments();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->paymentid'";
	$payments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$payments=$payments->fetchObject;
	
	$tenants = new Tenants();
	$fields=" concat(firstname,' ',concat(middlename,' ',lastname)) name";
	$where=" where id='$obj->tenantid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$tenants=$tenants->fetchObject;
	
	$customers = new Customers();
	$fields=" concat(firstname,' ',concat(middlename,' ',lastname)) name";
	$where=" where id='$obj->customerid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$customers=$customers->fetchObject;
	
	$shpexptransactions[$it]=array('expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name", 'paymentid'=>"$payments->id", 'paymentname'=>"$payments->name",'plotid'=>"$obj->plotid",'plotname'=>"$plots->name", 'tenantid'=>"$obj->tenantid",'tenantname'=>"$tenants->name", 'customerid'=>"$obj->customerid", 'customername'=>"$obj->customername",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$obj->quantity", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo", 'total'=>"$obj->total",'month'=>"$obj->month",'year'=>"$obj->year");

 	$it++;
  }
  
  $obj->transactdate=$obj->expensedate;
  $obj->iterator=$it-1;
  $obj->id="";
  $exp = new Exptransactions();
  $exp = $exp->setObject($obj);
  $exp->add($exp,$shpexptransactions,"",false);
  
}*/
?>
