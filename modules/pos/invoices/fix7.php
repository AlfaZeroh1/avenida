<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/expensecategorys/Expensecategorys_class.php");
require_once("../../fn/expensetypes/Expensetypes_class.php");
require_once("../../sys/acctypes/Acctypes_class.php");
require_once("../../fn/expenses/Expenses_class.php");

$db = new DB();

// $query="select * from fn_expensetypes";
// $res=mysql_query($query);
// while($row=mysql_fetch_object($res)){
//   $expensetypes = new Expensetypes();
//   $expensetypes=$expensetypes->setObject($row);
//   if($expensetypes->edit($expensetypes)){
//     echo "UPDATED: ".$row->name."\n";
//   }
// }

$query="select * from fn_expensecategorys";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $expensecategorys = new Expensecategorys();
  $expensecategorys=$expensecategorys->setObject($row);
  if($expensecategorys->edit($expensecategorys)){
    echo "UPDATED: ".$row->name."\n";
  }
}

$query="select * from inv_categorys";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $categorys = new Categorys();
  $categorys=$categorys->setObject($row);
  if($categorys->edit($categorys)){
    echo "UPDATED: ".$row->name."\n";
  }
}
?>