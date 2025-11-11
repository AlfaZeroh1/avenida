<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/rules/Rules_class.php");

$saved="";

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/transactions/TransactionsDBO.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../fn/exptransactions/Exptransactions_class.php");
require_once("../../fn/incomes/Incomes_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../pos/invoices/Invoices_class.php");
require_once("../../pos/invoicedetails/Invoicedetails_class.php");
require_once("../../pos/invoiceconsumables/Invoiceconsumables_class.php");
// require_once("../../pos/items/Items_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../proc/inwarddetails/Inwarddetails_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/purchases/Purchases_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
require_once("../../fn/supplierpayments/Supplierpayments_class.php");

echo "Balance\n";
$generaljournals = new Generaljournals();
$fields=" accountid,sum(debit) debit,sum(credit) credit ";
// $where=" where sys_acctypes.accounttype='Cumulative' and transactdate<='2015-06-30' and transactdate!='0000-00-00' ";
$where=" where fn_accounttypes.id in(3,4,5) and transactdate<='2015-06-30' and transactdate!='0000-00-00' ";
$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join fn_subaccountypes on fn_subaccountypes.id=sys_acctypes.subaccountypeid left join fn_accounttypes on fn_accounttypes.id=fn_subaccountypes.accounttypeid ";
$having="";
$groupby=" group by accountid ";
$orderby=" order by accountid asc ";
$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rows=mysql_fetch_object($generaljournals->result)){
$it=0;
$shpgeneraljournals=array();
$obj=$rows;
if($rows->debit>$rows->credit){  
$amount=$rows->debit-$rows->credit;

$shpgeneraljournals[$it]=array('accountid'=>"5762",  'memo'=>"closing balance", 'debit'=>"$amount", 'credit'=>"0", 'total'=>"$amount",'jvno'=>"",'transactdate'=>"0000-00-00");

$it++;

$shpgeneraljournals[$it]=array('accountid'=>"$rows->accountid",  'memo'=>"closing balance", 'debit'=>"0", 'credit'=>"$amount", 'total'=>"$amount",'jvno'=>"",'transactdate'=>"0000-00-00");

$it++;


}elseif($rows->debit<$rows->credit){
$amount=$rows->credit-$rows->debit;

$shpgeneraljournals[$it]=array('accountid'=>"5762",  'memo'=>"closing balance", 'debit'=>"0", 'credit'=>"$amount", 'total'=>"$amount",'jvno'=>"",'transactdate'=>"0000-00-00");

$it++;

$shpgeneraljournals[$it]=array('accountid'=>"$rows->accountid", 'memo'=>"closing balance", 'debit'=>"$amount", 'credit'=>"0", 'total'=>"$amount",'jvno'=>"",'transactdate'=>"0000-00-00");

$it++;


}
//print_r($shpgeneraljournals);
  $gn = new Generaljournals();
 if($gn->add($rows,$shpgeneraljournals)){    
    echo "updated accountid #".$obj->accountid."\n";
  }
  
}
?>