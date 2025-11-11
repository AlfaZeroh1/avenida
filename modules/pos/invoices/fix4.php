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
require_once("../../proc/config/Config_class.php");
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

echo "PURCHACES\n";
$purchase = new Purchases();
$fields=" distinct documentno ";
$where=" where boughton>='2015-07-01' ";
$join=" ";
$having="";
$groupby="";
$orderby="   ";
$purchase->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rows=mysql_fetch_object($purchase->result)){
  $purchases=new Purchases();
  $where=" where documentno='$rows->documentno' ";
  $fields="inv_purchases.*, inv_purchases.id purchaseid, inv_purchases.documentno, inv_purchasedetails.id purchasedetailid, inv_purchasedetails.quantity,inv_purchasedetails.itemid, inv_items.name itemname, inv_items.code, inv_purchasedetails.vatclasseid, inv_purchasedetails.tax, inv_purchasedetails.costprice,  inv_purchasedetails.discount, inv_purchasedetails.memo, inv_purchasedetails.vatamount, inv_purchasedetails.total, inv_purchases.documentno, inv_purchases.remarks, inv_purchases.purchasemodeid, inv_purchases.boughton, inv_purchases.createdby, inv_purchases.createdon, inv_purchases.lasteditedby, inv_purchases.lasteditedon, inv_purchases.ipaddress ";
  $join=" left join inv_purchasedetails on inv_purchasedetails.purchaseid=inv_purchases.id left join inv_items on inv_items.id=inv_purchasedetails.itemid ";
  $having="";
  $groupby="";
  $orderby="";
  $purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $it=0;
  $shppurchases = array();
  while($row = mysql_fetch_object($purchases->result)){
      $shppurchases[$it]=array('purchasedetailid'=>"$row->purchasedetailid",'quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$row->itemname", 'code'=>"$row->code", 'vatclasseid'=>"$row->vatclasseid", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'discount'=>"$row->discount", 'remarks'=>"$row->remarks",'vatamount'=>"$row->vatamount", 'total'=>"$row->total-$row->vatamount",'ttotal'=>"$row->total");
      
      $ob = $row;
      $it++;
  }

  $inv = new Purchases();
  $ob->id=$ob->purchaseid;
  if($inv->edit($ob,"",$shppurchases)){
    echo "PURCHASE #".$rows->documentno."\n";
  }
}

// echo "SUPPLIER PAYMENTS\n";
// $supplierpayments = new Supplierpayments();
// $fields="*";
// $where="";
// $join="";
// $having="";
// $groupby="";
// $orderby="";
// $supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// while($row=mysql_fetch_object($supplierpayments->result)){
//   $inv = new Supplierpayments();
//   $row->amount1=$row->amount;
//   if($inv->edit($row,$shop)){
//     echo "SUPPLIER PAYMENTS #".$row->documentno."\n";
//   }
// }

?>