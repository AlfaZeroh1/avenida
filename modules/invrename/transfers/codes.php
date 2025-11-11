<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transfers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/branches/Branches_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../transferdetails/Transferdetails_class.php");
require_once("../../inv/transfers/Transfers_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/itemdetails/Itemdetails_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");
require_once("../../inv/requisitions/Requisitions_class.php");
require_once("../../inv/creditcodes/Creditcodes_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");

$db = new DB();

$serials = "'SC-14-2794','SC-14-2618','SC-14-3108','SC-14-3100','SC-14-3090' ,'SC-14-3094','SC-14-2791' ,'SC-14-3002','SC-14-2685','SC-14-2986', 'SC-14-1833','SC-14-3045' ,'SC-14-1905', 'SC-14-1971' ,'SC-14-1813','SC-14-1860','SC-14-1907','SC-14-1943','SC-14-1902','SC-14-1868'";
$sql = "select * from inv_itemdetails where serialno in($serials) order by serialno"; 
$rs=mysql_query($sql);echo mysql_error();
$i=0;
while($rw=mysql_fetch_object($rs)){$i++;
echo "\n".$i." = ".$rw->id." = ".$rw->brancheid."=".$rw->serialno;
  $itm = new Itemdetails();
  $obj->instalcode = $itm->generateInstalCodes();

  $query="update inv_creditcodes set status='used' where id='$obj->instalcode'";//echo $query;
  mysql_query($query);
  $query2="update inv_itemdetails set instalcode='$obj->instalcode', version='2' where id='$rw->id'";//echo $query2;
  mysql_query($query2);
}
?>