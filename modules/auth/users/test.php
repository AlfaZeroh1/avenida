<?
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");

$db = new DB();



$query="select * from auth_users";
$res=mysql_query($query);

while($row=mysql_fetch_object($res)){
  $users = new Users();
  $obj = $row;
  $obj->pinno = $users->generatePinNo();echo $obj->pinno."\n";
  
  $users = $users->setObject($obj);
  $users->edit($users);
}

?>