<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../prod/sizes/Sizes_class.php");
require_once("../../sys/margins/Margins_class.php");
require_once("../../prod/varietys/Varietys_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");


$obj = $_GET['obj'];

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);

$arr = str_replace("\\","",$arr);
$arr=unserialize($arr);

$date = str_replace("\\","",$date);
$date=unserialize($date);

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
		//print_r($marg);

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
		jsPrintSetup.setOption('marginTop','1.2');
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
border{color:#ccc !important;}
td{margin-bottom:20px !important;}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1260px !important;}
</style>
</head>

<body onload="print_doc();">
<!--div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div-->

<table cellpadding='0' cellspacing='0' border="1px" width="100%" height="100%" >
<?php
if($obj->action=="Generate"){
$m=0;
$j=0;
while($j<$obj->days){
//$d="date".$j;
$employee="employeeid".$j;
$block="greenhouseid".$j;
$variety="varietyid".$j;
$size="sizeid".$j;
$quantity="quantity".$j;

  $str=str_pad($obj->$employee,4,0,STR_PAD_LEFT)."-".$obj->$block."-".$obj->$variety."-".$obj->$size."-".$obj->$quantity."-";//."-".$obj->$d;

  $str=str_pad($str,26,0,STR_PAD_LEFT);
  
  $employees = new Employees();
  $fields = " concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$obj->$employee."' ";
  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $employees = $employees->fetchObject;


  $varietys = new Varietys();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$obj->$variety."'";
  $varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $varietys = $varietys->fetchObject;
  
  $sizes = new Sizes();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$obj->$size."'";
  $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $sizes = $sizes->fetchObject;

  
  $greenhouses = new Greenhouses();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$obj->$block."'";
  $greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $greenhouses = $greenhouses->fetchObject;
  
  
  
  
  
	if(strlen($varietys->name)>10){
                $v=explode(" ",$varietys->name);
                $i=0;
                while($i<count($v)){
                        if($i==0)
                                $varietys->name=substr(trim(initialCap($v[$i])),0,1)." ";
                        else
                                $varietys->name.=trim(initialCap($v[$i]))." ";
                        $i++;
                }
        }

  
  $desc=$greenhouses->name." ".$employees->names." ".$varietys->name." ".$sizes->name." (".$obj->$quantity.") ";//.getDat($obj->$d);
  $desc = str_replace("&","$",$desc);
  
  $obj->desc=$desc;
  $n="noofbarcodes".$j;
$i=1;
  while($i<=($obj->$n)){
?>
  
  <?php if($m%3==0){ ?>
  <tr>
  <?php }?>
  <td style="padding-top:4px;padding-bottom:4px;padding-left:2px;padding-right:2px;" width="33.333333333%">
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $obj->desc; ?>" height="80px" width="235px"
alt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>">
  </td>
  
  <?php
  
$i++;
$m++;
}
$j++;
}
}
?>
</body>
</html>
