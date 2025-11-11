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
require_once("../../pos/returninwards/Returninwards_class.php");
require_once("../../pos/returninwarddetails/Returninwarddetails_class.php");
require_once("../../pos/items/Items_class.php");
// require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../proc/inwarddetails/Inwarddetails_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/purchases/Purchases_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
// require_once '../../ProgressBar/Manager.php';
// require_once '../../ProgressBar/Registry.php';

echo "DEBIT/CREDIT NOTES\n";
$returninwards = new Returninwards();
$fields=" distinct documentno ";
$where=" ";
$join=" ";
$having="";
$groupby="";
$orderby="   ";
$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($row=mysql_fetch_object($returninwards->result)){
  $returninwarddetails = new Returninwarddetails();
  $fields=" pos_returninwards.*, pos_returninwards.id returninwardid, pos_returninwarddetails.*, pos_returninwarddetails.id returninwarddetailid ";
  $join=" left join pos_returninwards on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where pos_returninwards.documentno='$row->documentno'";
  $returninwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $returninwarddetails->sql;
  $res=$returninwarddetails->result;
  
  $obj->action="Update";
  
  $it=0;
  $shpreturninwards=array();
  while($rows=mysql_fetch_object($res)){
		  
      $items = new Items();
      $fields="pos_items.name name,pos_categorys.name as variety,pos_categorys.id as varietyid";
      $join=" left join pos_categorys on pos_items.categoryid=pos_categorys.id ";
      $groupby="";
      $having="";
      $where=" where pos_items.id='$rows->itemid'";
      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $items->sql;
      $items=$items->fetchObject;
      
      $item->name="";
      
      if($rows->mixedbox=="Yes"){
	$item = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$rows->itemid'";
	$item->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$item=$item->fetchObject;
      }
	  
	  $sizes = new Sizes();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$rows->sizeid'";
	  $sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $sizes=$sizes->fetchObject;
	  
	  $rows->total=$rows->quantity*$rows->price*(100+$rows->vat)/100;
	  $ob=$rows;
	  $shpreturninwards[$it]=array('id'=>"$ob->returninwarddetailid",'itemid'=>"$ob->itemid", 'itemname'=>"$items->name",'itemnam'=>"$item->name",'item'=>"$item->id", 'sizeid'=>"$ob->sizeid" , 'sizename'=>"$sizes->name", 'quantity'=>"$ob->quantity", 'price'=>"$ob->price",'vat'=>"$obj->vat", 'exportprice'=>"$ob->exportprice", 'discount'=>"$ob->discount", 'bonus'=>"$ob->bonus", 'total'=>"$ob->total",'exporttotal'=>"$ob->exportprice*$ob->quantity",'boxno'=>"$ob->boxno",'varietyid'=>"$items->varietyid",'variety'=>"$items->variety");

	  $it++;
  }
  $inv = new Returninwards();
  $ob->id=$ob->returninwardid;
  if($inv->edit($ob,$shpreturninwards,$shpconsumables)){
    echo "Returns #".$row->documentno."\n";
  }
}
?>