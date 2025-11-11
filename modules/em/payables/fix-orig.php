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
require_once ("../../fn/exptransactions/Exptransactions_class.php");
require_once ("../../em/paymentterms/Paymentterms_class.php");
require_once ("../../sys/paymentmodes/Paymentmodes_class.php");
require_once ("../../em/plots/Plots_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once ("../../em/tenants/Tenants_class.php");
require_once ("../../fn/inctransactions/Inctransactions_class.php");
require_once("../../em/landlordpayables/Landlordpayables_class.php");
require_once("../../em/landlords/Landlords_class.php");
require_once("../../em/landlordpayments/Landlordpayments_class.php");
require_once("../../em/landlordpayables/LandlordpayablesDBO.php");

//connect to db
$db=new DB();

//get hold of landlord balances
echo "Dropping tmp\n";
mysql_query("drop table if exists tmp");
echo "Creating tmp\n";
mysql_query("create table tmp as select * from em_landlordpayables where remarks=''");
echo "Truncating Landlord Payables\n";
mysql_query("truncate em_landlordpayables");
echo "Truncating General Journals\n";
mysql_query("truncate fn_generaljournals");
//$query="insert into em_landlordpayables(documentno,landlordid,paymenttermid,plotid,month,year,invoicedon,quantity,amount,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress) 
//select documentno,landlordid,paymenttermid,plotid,month,year,invoicedon,quantity,amount,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress from tmp";
//mysql_query($query);

// echo "Adding New Fields\n";
// $sql="alter table tmp add receiptno int(11) after documentno, add paymentmodeid int(11) after paymenttermid, add bankid int(11) after paymentmodeid;";
// if(mysql_query($sql)){
//   mysql_query("alter table em_landlordpayables add receiptno int(11) after documentno, add paymentmodeid int(11) after paymenttermid, add bankid int(11) after paymentmodeid;");
//   echo "Updating Landlord Payables\n";
//   $ql="update tmp set paymentmodeid=3, bankid=8;";echo $ql;
//   if(mysql_query($ql))
//     echo "Updated Landlord Payables\n";
//   else
//     echo "Didnot\n";
// }
// else{
//   echo "Didnt Update Landlord Payables\n";
//   echo mysql_error();
// }

//handle landlord payables for balances
echo "Recreating Landlord Balances\n";
// $landlordpayables = new Landlordpayables();
// $fields="*";
// $where="";
// $join="";
// $having="";
// $groupby="";
// $orderby="";
// $landlordpayables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$it=0;
$query="select * from tmp";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  //Get transaction Identity
  echo "Landlord Balances: ".$row->documentno."\n";
  
  $obj=$row;
  
  $shplandlordpayables[$it]=array('paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'plotid'=>"$obj->plotid", 'plotname'=>"$plots->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");
  $payables = new Landlordpayables();
  $row->id="";
  $payables->setObject($row);
  $payables->add($payables,$shplandlordpayables);
  
}

mysql_query("drop table tmp;");
//handles all tenant invoices
$payables = new Payables();
$fields=" distinct documentno, sum(amount) amount, month, year, paymenttermid,tenantid, invoicedon ";
$where=" where documentno>0  ";
$join="";
$having="";
$groupby=" group by documentno ";
$orderby="";
$payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$it=0;

//Get transaction Identity
$transaction = new Transactions();
$fields="*";
$where=" where lower(replace(name,' ',''))='outgoinginvoice'";
$join="";
$having="";
$groupby="";
$orderby="";
$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$transaction=$transaction->fetchObject;
		
		
while($obj=mysql_fetch_object($payables->result)){
	$shpgeneraljournals=array();
	echo "Payables: ".$obj->documentno."\n";
	$it=0;
	$paymentterms = new Paymentterms();
	$fields="*";
	$where=" where id='$obj->paymenttermid' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentterms=$paymentterms->fetchObject;
	
	$obj->transactdate=$obj->invoicedon;
	
	$generaljournal2 = new Generaljournals();
	$ob->documentno=$obj->documentno;
	$ob->remarks="Invoice for ".getMonth($obj->month)." ".$obj->year;
	$ob->memo=$obj->remarks;
	$ob->accountid=$paymentterms->generaljournalaccountid;
	$ob->daccountid=$generaljournalaccounts2->id;
	$ob->transactionid=$transaction->id;
	$ob->mode=4;
	$ob->class="B";
	$ob->debit=0;
	$ob->credit=$obj->amount;
	
	$ob->did=$generaljournal->id;
	$generaljournal2->setObject($ob);
	//$generaljournal2->add($generaljournal2);

	$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$generaljournal2->transactdate",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'transactionid'=>"$generaljournal2->transactionid",'transactdate'=>"$generaljournal2->transactdate");
	$it++;
	
	//make payable journal entry here
	//retrieve account to debit to tenants A/C (subsidiary of Rent receivable A/C)
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$obj->tenantid' and acctypeid='32'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
	
	$generaljournal = new Generaljournals();
	$ob->tid=$payablesDBO->id;
	$ob->documentno="$obj->documentno";
	$ob->remarks="Invoice for ".getMonth($obj->month)." ".$obj->year;
	$ob->memo=$obj->remarks;
	$ob->accountid=$generaljournalaccounts->id;
	$ob->daccountid=$generaljournalaccounts2->id;
	$ob->transactionid=$transaction->id;
	$ob->mode=4;
	$ob->class="B";
	$ob->debit=$obj->amount;
	$ob->credit=0;
	$ob->transactdate=$obj->invoicedon;
	$generaljournal->setObject($ob);
	//$generaljournal->add($generaljournal);
	
	$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$generaljournal->transactdate",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'transactionid'=>"$generaljournal->transactionid",'transactdate'=>"$generaljournal->transactdate");
	
	$it++;		
	
	$gn = new Generaljournals();
	$gn->add($obj, $shpgeneraljournals);
}


$transaction = new Transactions();
$fields="*";
$where=" where lower(replace(name,' ',''))='tenantpayments'";
$join="";
$having="";
$groupby="";
$orderby="";
$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$transaction=$transaction->fetchObject;
		
$it=0;
//handles all tenant payments
$tenantpayments = new Tenantpayments();
$fields=" documentno,amount, month, year, tenantid, paymentmodeid, bankid, paidon, paymenttermid, houseid ";
//$where=" where houseid in(select id from em_houses where plotid not in(306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331)) ";
$where=" where documentno not in(select receiptno from em_landlordpayables) and paymenttermid in(select id from em_paymentterms where payabletolandlord='Yes') ";
//$where="";
$join="";
$having="";
$groupby="  ";
$orderby="";
$tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($obj = mysql_fetch_object($tenantpayments->result)){
$it=0;
$shpgeneraljournals=array();
echo "Tenant Payments: ".$obj->documentno."\n";
  //Make a journal entry
//debit client acc bank and credit account receivable

//mysql_query("delete from em_landlordpayables where receiptno='$obj->documentno' and paymenttermid='$obj->paymenttermid'");
//mysql_query("delete from fn_generaljournals where documentno='$obj->documentno' and transactionid=14");
			  //retrieve account to credit
	  $generaljournalaccounts = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$obj->tenantid' and acctypeid='32'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

	  $lp = new Landlordpayables();
	  $fields="(max(documentno)+1) documentno";
	  $where=" ";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $lp->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $lp=$lp->fetchObject;
	  if(empty($lp->documentno) or $lp->documentno=='NULL')
	    $lp->documentno=1;

	  if($obj->paymentmodeid==1){
		  $acctype=24;
		  $refid=1;
	  }
	  else{
		  $acctype=8;
		  $refid=$obj->bankid;
	  }
			  
	  $paymentmodes = new Paymentmodes();
	  $fields=" * ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where id='$obj->paymentmodeid'";
	  $join=" ";
	  $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $paymentmodes = $paymentmodes->fetchObject;
	  
	  if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
	    $obj->bankid=$obj->imprestaccountid;
	    
	  if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
		  $obj->bankid=1;
	  }
	  
			  //retrieve account to debit
	  $generaljournalaccounts2 = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$refid' and acctypeid='$acctype'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

	  $obj->transactdate = $obj->paidon;
	  
			  //make credit entry
	  $generaljournal = new Generaljournals();
	  $ob->tid=$obj->id;
	  $ob->documentno="$obj->documentno";
	  $ob->remarks="Payment for the month ".getMonth($obj->month)." ".$obj->year;
	  $ob->memo=$obj->remarks;
	  $ob->accountid=$generaljournalaccounts->id;
	  $ob->daccountid=$generaljournalaccounts2->id;
	  $ob->transactionid=$transaction->id;
	  $ob->mode=$obj->paymentmodeid;
	  $ob->class="B";
	  $ob->debit=0;
	  $ob->credit=$obj->amount;
	  $generaljournal->setObject($ob);
	  //$generaljournal->add($generaljournal);
	  
	  $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
	  
	  $it++;
	  
	  
	  $tenants = new Tenants();
	  $fields=" * ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where id='$obj->tenantid'";
	  $join=" ";
	  $tenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $tenants = $tenants->fetchObject;
	  
	  $obj->tenantname=$tenants->firstname." ".$tenants->middlename." ".$tenants->lastname;
	  
			  //make credit entry
	  $generaljournal2 = new Generaljournals();
	  $ob->tid=$obj->id;
	  $ob->documentno=$obj->documentno;
	  $ob->remarks="Receipt from ".$obj->tenantname;
	  $ob->memo=$obj->remarks;
	  $ob->daccountid=$generaljournalaccounts->id;
	  $ob->accountid=$generaljournalaccounts2->id;
	  $ob->transactionid=$transaction->id;
	  $ob->mode=$obj->paymentmodeid;
	  $ob->debit=$obj->amount;
	  $ob->credit=0;
	  $ob->class="B";
	  $ob->did=$generaljournal->id;
	  $generaljournal2->setObject($ob);
	  //$generaljournal2->add($generaljournal2);

	  $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
		  
	  $it++;
	  
	  $paymentterms = new Paymentterms();
	  $fields="*";
	  $where=" where id='$obj->paymenttermid' ";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $paymentterms=$paymentterms->fetchObject;
	  
	  $inc->amount=0;
	  
	  //if($paymentterms->payabletolandlord=="Yes"){
	      //record commission income transaction
	      if($paymentterms->chargemgtfee=="Yes"){
		      
		      //retrieve house landlord
		      $houses = new Houses();
		      $fields=" em_plots.id plotid, em_plots.landlordid,em_plots.commission,em_plots.commissiontype,em_plots.deductcommission ";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $where=" where em_houses.id='$obj->houseid'";
		      $join=" left join em_plots on em_plots.id=em_houses.plotid ";
		      $houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $houses = $houses->fetchObject;
		      
		      if($houses->deductcommission=="Yes"){
			      
			      //record income
			      $inctransaction = new Inctransactions();
			      $inc->incomeid=1;
			      if($houses->commissiontype==1)
				      $inc->amount=$obj->amount*$houses->commission/100;			
			      else
				      $inc->amount=$houses->commission;
				      
			      $inc->ref=$tenantpaymentsDBO->id;
			      $inc->paymentmodeid=5;
			      $inc->bankid=$houses->plotid;
			      $inc->documentno=$obj->documentno;
			      $inc->incomedate=$obj->paidon;
			      $inc->remarks="Management Fee";
			      $inc->remarks="Mgt Fee on $obj->houseid for ".getMonth($obj->month)." $obj->year";
			      $inc = $inctransaction->setObject($inc);
			      
			      if($inc->amount!=0){
				      $inctransactionDBO = new InctransactionsDBO();
				      $inctransactionDBO->persist($inc);
				      $generaljournal0 = new Generaljournals();
				      $ob->tid=$tenantpayments->id;
				      $ob->documentno="$obj->documentno";
				      $ob->remarks="Management Fee ";
				      $ob->memo=$tenantpayments->remarks;
				      $ob->accountid=8;
				      $ob->transactionid=$transaction->id;
				      $ob->mode=$obj->paymentmodeid;
				      $ob->class="B";
				      $ob->debit=0;
				      $ob->credit=$inc->amount;
				      $generaljournal0->setObject($ob);
				      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid");

				      $it++;
			      }
		      }
		      
		      //make a journal entry for it
		      //debit landlord account as an expense
		      
		      //credit mgt fee income account
	      }
	      
	      if($paymentterms->payabletolandlord=="Yes"){
		//retrieve Landlord and credit
		$plots = new Plots();
		$fields="em_plots.landlordid, em_plots.id";
		$join=" left join em_houses on em_houses.plotid=em_plots.id";
		$where=" where em_houses.id='$obj->houseid' ";
		$having="";
		$groupby="";
		$orderby="";
		$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$plots = $plots->fetchObject;
		
		
		//add a landlord payable transaction
		$landlordpayables = new Landlordpayables();
		$landlordpayables->documentno=$lp->documentno;
		$landlordpayables->receiptno=$obj->documentno;
		$landlordpayables->landlordid=$plots->landlordid;
		$landlordpayables->plotid=$plots->id;
		$landlordpayables->paymenttermid=$obj->paymenttermid;
		$landlordpayables->invoicedon=$obj->paidon;
		$landlordpayables->month=$obj->month;
		$landlordpayables->year=$obj->year;
		$landlordpayables->quantity=1;
		$landlordpayables->amount=$obj->amount-$inc->amount;
		$landlordpayables->remarks="Payment from ".$obj->tenantname;
		$landlordpayables->createdby=$_SESSION['userid'];
		$landlordpayables->createdon=date("Y-m-d H:i:s");
		$landlordpayables->lasteditedby=$_SESSION['userid'];
		$landlordpayables->lasteditedon=date("Y-m-d H:i:s");
		$lp = $landlordpayables->setObject($landlordpayables);
		
		$landlordpayablesDBO = new LandlordpayablesDBO();
		$landlordpayablesDBO->persist($lp);
		
			    //retrieve account to debit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$plots->landlordid' and acctypeid='33'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }
	      else{
		$generaljournalaccounts2->id=$paymentterms->generaljournalaccountid;
	      }
	      
	      $generaljournal0 = new Generaljournals();
	      $ob->tid=$tenantpayments->id;
	      $ob->documentno="$obj->documentno";
	      $ob->remarks=" Payment from ".$obj->tenantname;
	      $ob->memo=$tenantpayments->remarks;
	      $ob->accountid=$generaljournalaccounts2->id;
	      $ob->transactionid=$transaction->id;
	      $ob->mode=$obj->paymentmodeid;
	      $ob->class="B";
	      $ob->debit=0;
	      $ob->credit=$obj->amount-$inc->amount;
	      $generaljournal0->setObject($ob);
	      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid");

	      $it++;
	      
	      //debit receivable account
	      $generaljournal0 = new Generaljournals();
	      $ob->tid=$tenantpayments->id;
	      $ob->documentno="$obj->documentno";
	      $ob->remarks="Tenant Payment ";
	      $ob->memo=$tenantpayments->remarks;
	      $ob->accountid=$paymentterms->generaljournalaccountid;
	      $ob->transactionid=$transaction->id;
	      $ob->mode=$obj->paymentmodeid;
	      $ob->class="B";
	      $ob->debit=$obj->amount;
	      $ob->credit=0;
	      $generaljournal0->setObject($ob);
	      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid");

	      $it++;
	      
	      $gn = new Generaljournals();
	      $gn->add($obj, $shpgeneraljournals);
	      
	      
}


//handles landlord payments
$landlordpayments = new Landlordpayments();
$fields="distinct documentno,plotid,month, year, sum(amount) amount, paymentmodeid, bankid, remarks, paymenttermid, paidon ";
$where=" where documentno>0  ";
$join="";
$having="";
$groupby=" group by documentno ";
$orderby="";
$landlordpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $landlordpayments->sql;
$it=0;

//Get transaction Identity
$transaction = new Transactions();
$fields="*";
$where=" where lower(replace(name,' ',''))='landlordpayments'";
$join="";
$having="";
$groupby="";
$orderby="";
$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$transaction=$transaction->fetchObject;
		
		
while($obj=mysql_fetch_object($landlordpayments->result)){
	$shpgeneraljournals=array();
	echo "Landlord Payments: ".$obj->documentno."\n";
	$it=0;
	$paymentterms = new Paymentterms();
	$fields="*";
	$where=" where id='$obj->paymenttermid' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentterms=$paymentterms->fetchObject;
	
	$obj->transactdate=$obj->paidon;
	
	//retrieve Landlord and credit
	$plots = new Plots();
	$fields="em_plots.landlordid, em_plots.id, concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname)) name, em_landlords.llcode ";
	$join=" left join em_landlords on em_landlords.id=em_plots.landlordid ";
	$where=" where em_plots.id='$obj->plotid' ";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$plots = $plots->fetchObject;
	
	//credit entry to payment mode
	$paymentmodes = new Paymentmodes();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$obj->paymentmodeid' ";
	$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentmodes=$paymentmodes->fetchObject;
	
	if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
	  $obj->bankid=$obj->imprestaccountid;
	  
	if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
		$obj->bankid=1;
	}
	
	
	//retrieve account to credit
	$generaljournalaccounts2 = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;	
	
	//make credit entry
	$generaljournal2 = new Generaljournals();
	//$ob->tid=$tenantpayments->id;
	$ob->documentno=$obj->documentno;
	$ob->remarks="Landlord Payments to ".$plots->code." ".$plots->name." for ".getMonth($obj->month)." $obj->year ";
	$ob->memo=$obj->remarks;
	$ob->daccountid=$generaljournalaccounts->id;
	$ob->accountid=$generaljournalaccounts2->id;
	$ob->transactionid=$transaction->id;
	$ob->mode=$obj->paymentmodeid;
	$ob->debit=0;
	$ob->class="B";
	$ob->credit=$obj->amount;
	$ob->did=$generaljournal->id;
	$generaljournal2->setObject($ob);
	//$generaljournal2->add($generaljournal2);
	
	$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name",  'documentno'=>"$generaljournal2->documentno", 'class'=>"B", 'remarks'=>"$generaljournal2->remarks", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal2->transactionid");
	$it++;
	
		
	//make landlordpayment journal entry here
	    //retrieve account to debit
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$plots->landlordid' and acctypeid='33'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
	
	$generaljournal = new Generaljournals();
	$ob->tid=$payablesDBO->id;
	$ob->documentno="$obj->documentno";
	$ob->remarks="Landlord Payments ".getMonth($obj->month)." ".$obj->year;
	$ob->memo=$obj->remarks;
	$ob->accountid=$generaljournalaccounts->id;
	$ob->daccountid=$generaljournalaccounts2->id;
	$ob->transactionid=$transaction->id;
	$ob->mode=4;
	$ob->class="B";
	$ob->debit=$obj->amount;
	$ob->credit=0;
	$ob->transactdate=$obj->invoicedon;
	$generaljournal->setObject($ob);
	//$generaljournal->add($generaljournal);
	
	$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$generaljournal->transactdate",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'transactionid'=>"$generaljournal->transactionid",'transactdate'=>"$generaljournal->transactdate");
	
	$it++;		
	
	$gn = new Generaljournals();
	$gn->add($obj, $shpgeneraljournals);
}

//Get transaction Identity
$transaction = new Transactions();
$fields="*";
$where=" where lower(replace(name,' ',''))='plotexpenses'";
$join="";
$having="";
$groupby="";
$orderby="";
$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$transaction=$transaction->fetchObject;
				
$it=0;
$exptransactions = new Exptransactions();
$fields="distinct voucherno documentno,plotid,month, year, sum(total) ttotal, paymentmodeid, bankid, imprestaccountid, remarks, expenseid, expensedate ";
$where="  ";
$join="";
$having="";
$groupby=" group by voucherno ";
$orderby="";
$exptransactions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($obj = mysql_fetch_object($exptransactions->result)){
  $it=0;
  $shpgeneraljournals=array();
echo "PLot Expenses: ".$obj->documentno."\n";
  //Get transaction Identity
    $transaction = new Transactions();
    $fields="*";
    $where=" where lower(replace(name,' ',''))='plotexpenses'";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $transaction=$transaction->fetchObject;
    
    $ob->transactdate=$obj->expensedate;
    
    if(!empty($obj->plotid)){
	$plots = new Plots();
	$fields="*";
	$where=" where id='$obj->plotid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$plots=$plots->fetchObject;
	
	//retrieve account to debit
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$plots->landlordid' and acctypeid='33'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
    }
    else{
      //retrieve account to debit
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$obj->expenseid' and acctypeid='4'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
    }
    
    $obj->transactdate = $obj->expensedate;
    
    //make credit entry
    $generaljournal = new Generaljournals();
    $ob->tid=$tenantpayments->id;
    $ob->documentno="$obj->documentno";
    $ob->remarks="Payment for ".$obj->month." ".$obj->year;
    $ob->memo=$obj->remarks;
    $ob->accountid=$generaljournalaccounts->id;
    $ob->daccountid=$generaljournalaccounts2->id;
    $ob->transactionid=$transaction->id;
    $ob->mode=$obj->paymentmodeid;
    $ob->debit=$obj->ttotal;
    $ob->credit=0;
    
    $ob->class="B";
    $generaljournal->setObject($ob);
    //$generaljournal->add($generaljournal);
    
    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'class'=>"B", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal->transactionid");
    
    $it++;
    
    $paymentmodes = new Paymentmodes();
    $fields="*";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where id='$obj->paymentmodeid' ";
    $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $paymentmodes=$paymentmodes->fetchObject;
    
    
    if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
      $obj->bankid=$obj->imprestaccountid;
      
    if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
	    $obj->bankid=1;
    }
    
    if($obj->paymentmodeid==1)
      $obj->bankid=1;
    
    //retrieve account to credit
    $generaljournalaccounts2 = new Generaljournalaccounts();
    $fields="*";
    $where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
    
    $expenses=new Expenses();
    $where="  ";
    $fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where id='$obj->expenseid' ";
    $expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    $expenses = $expenses->fetchObject;
    
    //make credit entry
    $generaljournal2 = new Generaljournals();
    $ob->tid=$tenantpayments->id;
    $ob->documentno=$obj->documentno;
    $ob->remarks="Payment for $expenses->name on behalf of $obj->plotname";
    $ob->memo=$obj->remarks;
    $ob->daccountid=$generaljournalaccounts->id;
    $ob->accountid=$generaljournalaccounts2->id;
    $ob->transactionid=$transaction->id;
    $ob->mode=$obj->paymentmodeid;
    $ob->debit=0;
    $ob->class="B";
    $ob->credit=$obj->ttotal;
    $ob->did=$generaljournal->id;
    $generaljournal2->setObject($ob);
    //$generaljournal2->add($generaljournal2);
    
    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name",  'documentno'=>"$generaljournal2->documentno", 'class'=>"B", 'remarks'=>"$generaljournal2->remarks", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal2->transactionid");
	    
    $gn = new Generaljournals();
    $gn->add($obj, $shpgeneraljournals);
//}
?>
