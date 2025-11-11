<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../sys/margins/Margins_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");

$obj = $_GET['obj'];
$downsize = $_GET['downsize'];

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);

$margins = new Margins();
		$fields=" * ";
		$join="";
		$groupby="";
		$having="";
		$where="";
		$margins->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $margins->sql;
		
		$marg=array();
		while($row=mysql_fetch_object($margins->result)){
		  $marg[$row->name]=$row->value;
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" /-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<script type="text/javascript">
   function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
		//alert(printers[i]+"="+'<?php echo $_SESSION["smallprinter"];?>');
			if(printers[i].indexOf('<?php echo $_SESSION["smallprinter"];?>')>-1)
			{	//alert(i+": "+printers[i]);
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies',1);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginTop','8.1');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','<?php echo $marg['left']; ?>');
		jsPrintSetup.setOption('marginRight','<?php echo $marg['right']; ?>');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>

<style media="print" type="text/css">
table{overflow-y:visible; overflow-x:hidden;}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
td{padding-left:20px !important;margin:0px !important;}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1260px !important;}
</style>
</head>

<body onload="print_doc();">
<!--div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div-->

<table cellpadding='0' cellspacing='0' >
<?php
if(!empty($obj->action)){
$i=0;
//$str=str_pad($str,26,0,STR_PAD_LEFT);

$j=0;

$row=mysql_fetch_object(mysql_query("select case when max(id) is null then 0 else max(id) end id from post_barcodes"));
$j=$row->id+1;

while($i<=($obj->noofbarcodes-1)){

// $str= $obj->itemid."-".$obj->sizeid."-".$obj->quantity."-".($i+1);//."-".date("ymd");
// if(!empty($downsize)){
//   $str.="-".$downsize;
// }
$str=$obj->itemid."-".$obj->sizeid."-".$obj->quantity."-".$obj->greenhouseid."-".$j;//."-".date("ymd");
if(!empty($obj->downsize)){
  $str.="-".$obj->downsize;
}

$items = new Items();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->itemid'";
$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$items = $items->fetchObject;

$sizes = new Sizes();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->sizeid'";
$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$sizes = $sizes->fetchObject;

// $sizes2 = new Sizes();
// $fields="*";
// $join="";
// $having="";
// $groupby="";
// $orderby="";
// $where="";
// $where=" where id='$obj->sizeid2'";
// $sizes2->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// $sizes2 = $sizes2->fetchObject;

$greenhouses=new Greenhouses();
$where=" where id='$obj->greenhouseid' ";
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$greenhouse=$greenhouses->fetchObject;

if(strlen($items->name)>10){
	$v=explode(" ",$items->name);
	$x=0;
	while($x<count($v)){
		if($x==0)
			$items->name=substr(trim(initialCap($v[$x])),0,1)." ";
		else
			$items->name.=trim(initialCap($v[$x]))." ";
		$x++;
	}
}

$desc=$items->code." ".$sizes->name."(".$obj->quantity.")-".$j."(".$greenhouse->name.")";
if(!empty($downsize)){
  $desc.=" DS";
}

$obj->desc=$desc;
?>
  
  <?php if($i%5==0){ ?>
  <tr>
  <tr>
  <?php }?>
  <td style="padding-right:15px;padding-left:15px;padding-top:15px;padding-bottom:10px;">
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $obj->desc; ?>&height=10" height="60px" width="125px"
a00lt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>">
  </td>
  
  <?php
  
  $query="insert into post_barcodes(barcode,greenhouseid,itemid,generatedon,ipaddress,createdby, createdon, lasteditedby, lasteditedon) values('$str','$obj->greenhouseid','$obj->itemid',Now(),'".$_SERVER['REMOTE_ADDR']."','".$_SESSION['userid']."','".date("Y-m-d H:i:s")."','".$_SESSION['userid']."','".date("Y-m-d H:i:s")."')";
  mysql_query($query);
  
$i++;
$j++;
}
}
?>
</body>
</html>
