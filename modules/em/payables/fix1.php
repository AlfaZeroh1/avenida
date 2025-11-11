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
}
?>