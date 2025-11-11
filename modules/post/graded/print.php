<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");

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
		jsPrintSetup.setOption('marginTop','7.5');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','0');
		jsPrintSetup.setOption('marginRight','0');
		
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

.noprint{ display:none;}
</style>
<style media="screen">

</style>
</head>

<body onload="print_doc();">
<!--div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div-->

<table cellspacing='0' border="1px" width="99%" height="110%">
<?php
if(!empty($obj->action)){
$i=0;
$str=$obj->employeeid;
while($i<=($obj->noofbarcodes-1)){

$employees = new Employees();
$fields = " concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->employeeid' ";
$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$employees = $employees->fetchObject;

$obj->desc=$employees->names." (".$obj->noofday.")";

$desc=$obj->employeeid."-".$obj->noofday;
$str=str_pad($desc,13,0,STR_PAD_LEFT);

?>
  
  <?php if($i%4==0){ ?>
  <tr>
  <?php }?>
  <td style="padding-left:9px;padding-right:9px;padding-top:9px;padding-bottom:8px;" width="25%" height="4.7619047619%" align="center">
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $obj->desc; ?>&font=2" height="30px" width="160px"
alt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>">
  </td>
  
  <?php
  
$i++;
}
}
?>
</body>
</html>
