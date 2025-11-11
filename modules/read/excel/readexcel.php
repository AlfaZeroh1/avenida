<?php
session_start();
require_once "../../../DB.php";
require_once "../../../lib.php";

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

include "../../../head.php";

$db = new DB();
$obj = (object)$_POST;
$ob = (object)$_GET;

if($obj->action=="Save"){
  $shop = $_SESSION['shop'];
  
}

if(!empty($ob->deductionid)){
  $obj->deductionid=$ob->deductionid;
}
if(!empty($ob->frommonth)){
  $obj->frommonth=$ob->frommonth;
}
if(!empty($ob->tomonth)){
  $obj->tomonth=$ob->tomonth;
}
if(!empty($ob->fromyear)){
  $obj->fromyear=$ob->fromyear;
}
if(!empty($ob->toyear)){
  $obj->toyear=$ob->toyear;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>WiseDigits: Harvest</title>

</head>
<body>
<?php

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';
?>
<div class="container" style="margin-top:;">
<form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="deductionid" value="<?php echo $obj->deductionid; ?>"/>
  <input type="hidden" name="frommonth" value="<?php echo $obj->frommonth; ?>"/>
  <input type="hidden" name="fromyear" value="<?php echo $obj->fromyear; ?>"/>
  <input type="hidden" name="tomonth" value="<?php echo $obj->tomonth; ?>"/>
  <input type="hidden" name="toyear" value="<?php echo $obj->toyear; ?>"/>
  <input type="file" class="btn" name="inputfile"/>&nbsp;
  <input type="submit" name="action" class="btn btn-primary" value="Harvest"/>

<?php
if(!empty($obj->action)){
$file=$_FILES['inputfile']['tmp_name'];
$filename=$_FILES['inputfile']['name'];

$inputFileType = 'Excel2007';
$inputFileName = $file;
  

$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objPHPExcel = $objReader->load($inputFileName);

$sheetCount = $objPHPExcel->getSheetCount();

$sheetNames = $objPHPExcel->getSheetNames();

?>
<div class="container" style="margin-top:;">
<div class="panel with-nav-tabs panel-default">
 <div class="panel-heading">
<!-- get deduction name   -->
<?php if(!empty($obj->deductionid)){
  $query="select * from hrm_deductions where id='$obj->deductionid'";
  $deduction = mysql_fetch_object(mysql_query($query));
  echo $deduction->name;
}

echo " From: ".getMonth($obj->frommonth)." ".$obj->fromyear." ";
echo "To: ".getMonth($obj->tomonth)." ".$obj->toyear;
?>
  <ul class="nav nav-tabs">
<?php
foreach($sheetNames as $sheetIndex => $sheetName) {
	
	?>
	
	<li><a href="#<?php echo $sheetIndex; ?>" data-toggle="tab"><?php echo $sheetName; ?></a></li>
	
	<?php
// 	break;
	
}
?>
</ul>
	</div>
<div class="panel-body">
<div class="tab-content">
<?php
$array = array();

foreach($sheetNames as $sheetIndex => $sheetName) {
	
	?>
	<div class="tab-pane" id="<?php echo $sheetIndex; ?>" style="min-height:700px;">
	<div><?php echo $sheetName; ?></div>
	<table class="table display">
	<tbody>
	<?php
	
	$objPHPExcel->setActiveSheetIndexByName($sheetName);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	
	$num = count($sheetData);
	$i = 0;
	while($i<=$num){
	  if($i>1){
	    $array[$i]['deductionid']=$obj->deductionid;
	    $array[$i]['frommonth']=$obj->frommonth;
	    $array[$i]['fromyear']=$obj->fromyear;
	    $array[$i]['toyear']=$obj->toyear;
	    $array[$i]['tomonth']=$obj->tomonth;
	  }
	?>
	<tr>
	<?php
	  $j=0;
	  foreach($sheetData[$i] as $cell){
	    $j++;
	    $color="";
	    if($j==1 and $i>1){
	      //get employees
	      $query="select id, concat(pfnum,' ', concat(firstname, ' ',concat(middlename,' ',lastname))) names from hrm_employees where pfnum='".$cell."'";
	      $res= mysql_query($query);
	      $row=mysql_fetch_object($res);
	      $array[$i]['employeeid']=$row->id;
	      $cell = $row->names;
	      if(empty($row->names)){
		$color="red";
	      }
	    }
	    if($j==3 and $i>1){
	      $array[$i]['amount']=$cell;
	    }
	    ?>
	    <td style="color:<?php echo $color; ?>"><?php echo $cell; ?></td>
	    <?php
	  }
	  $i++;
	?>
	</tr>
	<?php
	}
	
// 	break;
	?>
	</tbody>
	</table>
	</div>
	<?php
	
}

}
?>
<?php if(count($array)>0){ 
$_SESSION['shop'] = $array;
?>
<input class="btn btn-warning" type="submit" name="action" value="Save"/>
<?php } ?>
</form>
<body>
</html>
