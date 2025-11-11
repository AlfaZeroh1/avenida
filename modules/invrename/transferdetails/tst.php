<?php
session_start();
require_once "../../../lib.php";
require_once "../../../DB.php";

$db = new DB();

$sqls = "select * from tmp";
$rs = mysql_query($sqls);

while($ob = mysql_fetch_object($rs)){

  $query="update inv_itemdetails dt, inv_transferdetails td set dt.instalcode=td.instalcode where dt.id='$ob->id' and td.id='$ob->transferid'";
  if(mysql_query($query))
    echo "SUCCESS :".$ob->serialno."\n";
    
  $sql="update tmp set status=1 where id='$ob->id'";
  mysql_query($sql);
  
  
  
}

?>
