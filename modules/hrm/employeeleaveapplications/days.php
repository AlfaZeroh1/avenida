<?php 
session_start();
require_once("../../hrm/workingdays/Workingdays_class.php");
require_once("../../hrm/holidays/Holidays_class.php");
require_once("../../hrm/leavetypes/Leavetypes_class.php");


$obj = (object)$_GET;

$start=$obj->startdate;
$srt=$obj->startdate;
$trt=$obj->startdate;
$duration=$obj->duration;

$count=0;
$i=0;
$j=0;
$leavetypes = new Leavetypes();
$fields="*";
$where=" where id='$obj->type' ";
$join="";
$having="";
$groupby="";
$orderby="";
$leavetypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$leavetypes=$leavetypes->fetchObject;

if($leavetypes->type=='Working Days'){
while($i<$duration){
$day="";
$day=date('l',strtotime($trt));

// echo $day.'<br/>';

$workingdays = new Workingdays();
$fields="*";
$where=" where name='$day' ";
$join="";
$having="";
$groupby="";
$orderby="";
$workingdays->retrieve($fields, $join, $where, $having, $groupby, $orderby);
if($workingdays->affectedRows>0){
    $holidays = new Holidays();
    $fields="*";
    $where=" where date='$trt' ";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $holidays->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    if($holidays->affectedRows>0){    
    //do not increament
    }else{
    $i++;//echo $day.'=>'.$trt.'<br/>';
   }
}
$trt = date('Y-m-d',strtotime($trt."+1 day"));
$count++;
}
}
else{
 $count=$duration;
}
$returndate = date('Y-m-d', strtotime($srt."+$count days"));
echo $returndate;
?>