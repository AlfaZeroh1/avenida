<?php
require_once("../../../DB.php");
require_once("../../../lib.php");

$module=trim($_GET['module']);
$main=trim($_GET['main']);
$field=trim($_GET['field']);
$extra=trim($_GET['extra']);
$extratitle=trim($_GET['extratitle']);
$extras=trim($_GET['extras']);
$extratitles=trim($_GET['extratitles']);
$group=trim($_GET['groupby']);

if(!empty($extra)){
  $extras=unserialize(rawurldecode($extras));  
}
else{
  $extras=array();
}
  
if(!empty($extratitles))
  $extratitles=unserialize(rawurldecode($extratitles));
else
  $extratitles=array();

$ob=(object)$_GET;

$str="../../../modules/".$main."/".$module."/".trim(initialcap($module))."_class.php";

require_once($str);

$q = strtolower($_GET['term']);
if(!empty($_GET['where']))
	$wher=" and ".$_GET['where'];
if (!$q) return;

//connect to db
$db=new DB();
$md=trim(initialCap($module));

$field = str_replace("\\", "", $field);

$return_arr = array();

$mod=new $md;
$m=$main."_".$module;
$fields=" $field as names, $m.* ";

if(!empty($extra))
	$fields.=", $extra $extratitle ";

if(count($extras)>0)	{
  $x=0;
  while($x<count($extras)){
    if(!empty($extras[$x]))
      $fields.=", $extras[$x] $extratitles[$x] ";
    $x++;
  }
}

$join=str_replace("'", "", $_GET['join']);
$join = str_replace("\\", "", $join);
$field=str_replace("distinct","",$field);
$having="";
$groupby=" ".$group;
$orderby="";
if(strpos($field,"group_concat"))
  $where=" where 1=1 ".$wher." having names like '%$q%'";
else
  $where=" where replace(lower($field),' ','') like replace(lower('%$q%'),' ','') ".$wher;
$mod->retrieve($fields,$join,$where,$having,$groupby,$orderby);logging($mod->sql);
$res=$mod->result;
$str="";
if($mod->affectedRows>0){
	while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
 	$rs=mysql_query("desc $mod->table");//echo "desc $mod->table ".$rs->num_rows; 	
 	
 	
 	while($rw=mysql_fetch_array($rs)){
		  $row_array[$rw['Field']]=$row[$rw[0]];   		
 	}
 	
 	$row_array['value']=$row['names'];
 	
 	$row_array[$extratitle]=$row[$extratitle];
 	if(count($extras)>0){
	  $x=0;
	  while($x<count($extras)){
	     $row_array[$rw[$extratitles[$x]]]=$row[$extratitles[$x]];
	    $x++;
	  }
	}
	
 	array_push($return_arr,$row_array);
	}
	 echo json_encode($return_arr);//logging(print_r($return_arr)."Test");
}
else{
	$str="No Rows Selected";//logging($return_arr);
        echo $str;
}
   
?>
