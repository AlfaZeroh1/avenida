 <?php
require_once("DB.php");
require_once("lib.php");

$db = new DB();

$json = array();
$output = array( "groupData" => array());
$index=0;

$sql="select * from sys_dashboards where type='panel'";//echo $sql;
$rs=mysql_query($sql);
while($rw=mysql_fetch_object($rs)){

  $query=$rw->query;	
  $res=mysql_query($query);
  $row=mysql_fetch_object($res);
  
  //Statistic 1
  $json[$index]['title'] =$rw->name;
  $json[$index]['amount'] =formatNumber($row->amount);
  
  $index++;

}

$output['groupData']=$json;
      
echo json_encode($output);
