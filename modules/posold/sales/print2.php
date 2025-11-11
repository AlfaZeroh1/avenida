<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../crm/customers/Customers_class.php");
$obj = $_GET['obj'];

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);
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
		jsPrintSetup.setOption('marginTop','3.2');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','3');
		jsPrintSetup.setOption('marginRight','3');
		
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

$customers = new Customers();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->customerid'";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

while($i<=($obj->noofbarcodes-1)){

$desc=$customers->name." Box No: ".($i+1);

$str=$obj->customerid."-".($i+1);
$str=str_pad($str,26,0,STR_PAD_LEFT);

$obj->desc=$desc;
?>
  
  <?php if($i%3==0){ ?>
  <tr>
  <tr style="margin-bottom:0px !important;padding:20px;">
  <?php }?>
  <td style="padding:7px;">
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $desc; ?>" height="80px" width="235px"
a00lt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>">
  </td>
  
  <?php
  
$i++;
}
}
?>
</body>
</html>
