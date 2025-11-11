<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$module = $_GET['module'];
$main = $_GET['main'];
$field = $_GET['field'];
$field2 = $_GET['field2'];
$value = $_GET['value'];
$value2 = $_GET['value2'];
$arr=$_GET['arr'];

$arr=str_replace("\\", "", $arr);

$arr=unserialize(rawurldecode($arr));
$arr2=$arr;
if($field!="field")
	$arr[$field]=$value;

if(!empty($field2)){
  $arr[$field2]=$value2;
}
$url=explode("_",$module);
require_once("../../$url[0]/$url[1]/".trim(initialCap($url[1]))."_class.php");

$md=trim(initialCap($url[1]));

$mod=new $md;
$db=new DB();

$ob=(object)$arr;

$where=" where ";
$fields=" * ";
$ar=array_keys($arr2);
for($i=0;$i<count($ar);$i++){
	$key=$ar[$i];
	if($i>0)
		$where.=" and ";
	$where.="$key = '$arr2[$key]'";
}
$mod->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $mod->sql;
$obj=$mod->fetchObject;

$ob = (object) array_merge((array) $obj, (array) $ob);

$ob->id=$obj->id;
$ob->createdby=$_SESSION['userid'];
$ob->createdon=date("Y-m-d H:i:s");
$ob->lasteditedby=$_SESSION['userid'];
$ob->lasteditedon=date("Y-m-d H:i:s");
if($mod->affectedRows>0 and $field!="field")
	$mod->edit($ob);
elseif($mod->affectedRows>0 and $field=="field")
	$mod->delete($ob);
else{
	$mod = $mod->setObject($ob);
	$mod->add($mod);
}

?>
