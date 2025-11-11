<?php
require_once "../../../DB.php";
require_once "../../../lib.php";
require_once("Generaljournals_class.php");

$db = new DB();

$gn = new Generaljournals();

$i=43;
 $total=0;
 $sr=mysql_query("select * from fn_generaljournalaccounts where acctypeid=35");
 
while($rw=mysql_fetch_object($sr)){
 $j=0;
 
 $gnss = mysql_fetch_object(mysql_query("select jvno,case when sum(debit*rate) is null then 0 else sum(debit*rate) end-case when sum(credit*rate) is null then 0 else sum(credit*rate) end amount from fn_generaljournals where transactdate>='2015-07-01' and accountid in($rw->id)"));
 
 echo $j." = ".formatNumber($gnss->amount)."\n";
 
  $sql="select id, trim(name) name from fn_generaljournalaccounts where categoryid='$rw->id' order by name";
  $rs=mysql_query($sql);
  while($rw=mysql_fetch_object($rs)){
    
    $in = $gn->getCategoryAccounts("",$rw->id);
    
    $gns = mysql_fetch_object(mysql_query("select jvno,case when sum(debit*rate) is null then 0 else sum(debit*rate) end-case when sum(credit*rate) is null then 0 else sum(credit*rate) end amount from fn_generaljournals where transactdate>='2015-07-01' and accountid in($rw->id)"));
    
    $res=mysql_query("select jvno,case when sum(debit*rate) is null then 0 else sum(debit*rate) end-case when sum(credit*rate) is null then 0 else sum(credit*rate) end amount from fn_generaljournals where transactdate>='2015-07-01' and accountid in($in)");
    $row=mysql_fetch_object($res);
    
    $amount=$row->amount+$gns->amount;
    
    $total+=($amount);

    if($amount<>0){$j++;
      echo $j." = ".formatNumber($amount)."\n";
    }
  }
  echo "\nTotal: ".$total."\n";
  $i++;
}
 
?>