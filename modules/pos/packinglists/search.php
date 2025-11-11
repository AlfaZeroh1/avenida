<?php
session_start();
// require_once "../../../lib.php";
require_once "../../../DB.php";

$db = new DB();

// $query="select * from post_graded where createdon>'2016-07-05 14:36:06' and status in('rebunchinout','checkedout','regradedout')";//echo $query;
$query="select * from pos_packinglistdetails where createdon>'2016-07-05 14:36:06')";//echo $query;
// $query="select * from post_harvervestrejects where createdon>'2016-07-05 14:36:06')";//echo $query;
$res=mysql_query($query);

$i=0;

while($row=mysql_fetch_object($res)){ $i++;
    $barcode=$row->barcode;
    $cod=strrpos($barcode,'=');
    $code=substr($barcode,0,($cod));
    
//     $query2="select * from post_graded where barcode like '$code%' and status not in('rebunchinout','checkedout','regradedout') and id<'$row->id' order by id desc limit 1";
    $query2="select * from post_graded where barcode like '$code%' order by id desc limit 1";
    $w=mysql_fetch_object(mysql_query($query2));
    if($w->datecode!=$row->barcode){
       
       $q=mysql_fetch_object(mysql_query("select * from pos_items where id=$row->itemid"));
       $q2=mysql_fetch_object(mysql_query("select * from pos_sizes where id=$row->sizeid"));
       echo $i."  ".$q->name."->".$q->id."  ".$q2->name."->".$q2->id."  ".$barcode."  ".$row->datecode." === ".$w->datecode."  ".$row->id."   ".$row->quantity."\n";
    }
     
}

?>