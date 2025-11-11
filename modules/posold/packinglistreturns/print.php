<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/fleets/Fleets_class.php");
require_once("../packinglistdetails/Packinglistdetails_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../prod/sizes/Sizes_class.php");


$doc=$_GET['doc'];
$customerid=$_GET['customerid'];
$packedon = $_GET['packedon'];

		$customers = New Customers();
		$fields="crm_customers.id, crm_customers.name, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="where crm_customers.id='$customerid'";
		$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $customers->sql;
		$customers=$customers->fetchObject;		
	

$packinglists = new Packinglists();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where documentno='$doc'";
$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $customers->sql;
$packinglists=$packinglists->fetchObject;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" />
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
		jsPrintSetup.setOption('marginLeft','4.8');
		jsPrintSetup.setOption('marginRight','');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
 
  }
 </script>

<style media="all" type="text/css">
body{font-family:'arial';font-size:10px;}
ul{list-style:none !important;}
.table-bordered {
border: 1px solid #ddd;
border-collapse: separate;
/*border-left: 1px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;*/
}
hr {
display: block;
-webkit-margin-before: 0.2em;
-webkit-margin-after: 0.2em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;
border-style: inset;
border-width: 1px;
}
table{width:100%;overflow-y:visible; overflow-x:hidden;margin:0px;padding:0px;}
table{overflow-y:visible; overflow-x:hidden;}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}
.fnt{font-family:tahoma;font-size:9px;}
.fntt{font-family: tahoma ;font-size:10px;}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 {width:100%; height:1160px !important;}
</style>
</head>

<body onload="print_doc();">
<!--<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>-->
<!-- headder -->

<table class="table table-stripped">
<tr>
<td colspan="7">
<div style="text-align:center"> 
 <div style="text-align:center;text-transform:uppercase;"><strong><?php echo $_SESSION['companyname']; ?></strong>
            <div><span class="desc"><?php echo $_SESSION['companydesc']; ?></span>
            <span><?php echo $_SESSION['companActual/V.weight Ratioyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
            <span><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span> &nbsp;&nbsp;
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
</td>
</tr>
<tr>
<td colspan="7" align="center" style="text-align:center;">
<strong>
         <h2> PACKING LIST / DELIVERY NOTE
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
			?>
            </h2>
            </strong>   
            </span>
            </div>
</td>
</tr>
<tr><td>SHIPPED TO:</td></tr>

<tr>
	
<td width="50%" colspan="3">
<div style="font-size:11px !important;">CUSTOMER:&nbsp;<strong><?php echo initialCap($customers->name); ?></strong></div>
<div style="font-size:11px !important;">LOCATION:&nbsp;<strong><?php echo $customers->address; ?></strong></div>
<div style="font-size:11px !important;">TEL:&nbsp;<strong><?php echo $customers->tel; ?></strong></div>
<div style="font-size:11px !important;">FAX:&nbsp;<strong><?php echo $customers->fax; ?></strong></div>
</td>

<td width="50%" colspan="4">
<div style="font-size:11px !important;">DATE: &nbsp;<strong><?php echo $packedon; ?></strong></div>
<div style="font-size:11px !important;">DELIVERY NO: &nbsp;<strong> <?php echo $doc; ?></strong></div>
<!--<div style="font-size:11px !important;">SHIPMENT NO: &nbsp;</strong></div>-->
<div style="font-size:11px !important;">DRIVER NAME:&nbsp;<strong> </strong></div>
<div style="font-size:11px !important;">VEHICLE REG: &nbsp;<strong> </strong></div>      

</td>
</tr>





</table>
<table width="100%" class="table table-stripped">
<tr><td colspan="9"><hr></td></tr>
   	<tr>
			      <th width="2%">#</th>
			      <th align="left">TYPE</th>
			      <th align="left">VARIERTY</th>
			      <th align="left">LENGTH</span></th>
			      <th align="left">VARIETY VOL</span></th>
			      <th>BOXES</th>			     
			      <th>PACK RATE</th>
			       <th>STEMS</th>
			      <th>MEMO</span></th>
	</tr>
	
	<?php
		$i=0;
		$stotal=0;
		$btotal=0;
		$packinglistss = New Packinglists();
		$fields=" * ";
		$join="";
		$having="";
		$groupby=" ";
		$orderby=" ";
		$where="where documentno='$doc' and (returns=0 or returns='' or returns is null)";
		$packinglistss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$packinglistss->result;
		
		
		$pack=array();
		$j=0;
		
		while($row=mysql_fetch_object($res)){
		  
		  //echo " DOCUMENT NO ".$row->id."<br/>";
		  
		  $packinglistdetails = new Packinglistdetails();
		  $fields=" distinct pos_packinglistdetails.itemid, pos_packinglistdetails.sizeid, sum(pos_packinglistdetails.quantity) quantity, pos_items.name itemname, pos_sizes.name sizename, pos_categorys.name categoryid ";
		  $join=" left join pos_items on pos_items.id=pos_packinglistdetails.itemid left join pos_sizes on pos_sizes.id=pos_packinglistdetails.sizeid left join pos_categorys on pos_categorys.id=pos_items.categoryid";
		  $having="";
		  $groupby=" group by itemid, sizeid, quantity ";
		  $where="where packinglistid='$row->id'";
		  $packinglistdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $i=0;
		  $bool=false;
		  $check=0;
		  
		  $pac=array();
		  
		 // echo "</br><br/>"; print_r($packings);
		  while($rw=mysql_fetch_object($packinglistdetails->result)){		    
		   // echo $rw->packinglistid."======".$rw->itemid." = ".$rw->sizeid." = ".$rw->quantity."<br/>";
		    $k=0;
		    $check=0;
		    $bool=false;		    
		    
		    $pac[$i]['itemid']=$rw->itemid;
		    $pac[$i]['itemname']=$rw->itemname;
		    $pac[$i]['sizeid']=$rw->sizeid;
		    $pac[$i]['sizename']=$rw->sizename;
		    $pac[$i]['categoryname']=$rw->categoryid;
		    $pac[$i]['quantity']=$rw->quantity;
		    
		    $i++;
		  }
		  //echo "<br/>PACK <br/>";
		//print_r($pac);
		  //$rw=mysql_fetch_array($packinglistdetails->result);
		  $pk = new Packinglists();
		  $check = $pk->checkArray($pac,$pack);//echo " THIS CHECK ".$check;
		  		
		  if($check=="NOT FOUND"){ //$check=$check-1;  
		  
		    //$packings[$i]['boxes']+=1;
		    $bool=false;
		  }
		  else{
		    $check = $check-1;
		    $bool=true;
		  }
		  
		  if($bool){
		    
		    //echo "<br/>".$check."TRUE<br/>";
		  }else{
		    //echo "<br/>".$check." HERE FALSE<BR/>";
		  }
		  
		  //if($bool){echo" TRUE ";}else{echo " FALSE ";}echo $row->id."<br/>";
		  //if bool is true it means the specific box details exist
		  if($bool){
		    $pack[$check]['boxes']+=1;
		    //break;
		  }
		  else{//echo "WE ARE HERE";
		    $packinglistdetailss = new Packinglistdetails();
		    $fields=" distinct pos_packinglistdetails.itemid, pos_packinglistdetails.sizeid, sum(pos_packinglistdetails.quantity) quantity, pos_items.name itemname, pos_sizes.name sizename, pos_categorys.name categoryid ";
		    $join=" left join pos_items on pos_items.id=pos_packinglistdetails.itemid left join pos_sizes on pos_sizes.id=pos_packinglistdetails.sizeid left join pos_categorys on pos_categorys.id=pos_items.categoryid";
		    $having="";
		    $groupby=" group by itemid, sizeid ";
		    $orderby=" ";
		    $where="where packinglistid='$row->id'";
		    $packinglistdetailss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    $i=0;
		    while($rw=mysql_fetch_object($packinglistdetailss->result)){
		      $pack[$j][$i]['itemid']=$rw->itemid;
		      $pack[$j][$i]['itemname']=$rw->itemname;
		      $pack[$j][$i]['sizeid']=$rw->sizeid;
		      $pack[$j][$i]['sizename']=$rw->sizename;
		      $pack[$j][$i]['categoryname']=$rw->categoryid;
		      $pack[$j][$i]['quantity']=$rw->quantity;
		      $pack[$j]['boxes']=1;
		      
		     // echo $packings[$row->id][$i]['itemid']."==".$rw->itemid." and ".$packings[$row->id][$i]['sizeid']."==".$rw->sizeid." and ".$packings[$row->id][$i]['quantity']."==".$rw->quantity."<br/>";
		      
		      $i++;
		    }		    
		    
		    $j++;
		  }
		 // echo "<br/>PACKINGS <br/>";
		//print_r($pack);
		  //else create a new box in the array
		}
		
		
		
		$i=0;
		$stotal=0;
		while($i<count($pack)){
		  $s=0;
		  $k=0;
		  $st=0;
		  while($k<count($pack[$i])){
		    $st+=$pack[$i][$k]['quantity'];
		    $k++;
		  }
		  ?>
		  <tr><td colspan="9"><hr></td></tr>
	    <tr>
		  <td align="left" rowspan="<?php echo count($pack[$i]);?>"><?php echo ($i+1); ?></td>
		  <td align="left"><?php echo strtoupper($pack[$i][0]['categoryname']); ?></td>
		  <td align="left"><?php echo strtoupper($pack[$i][0]['itemname']); ?></td>		  
		  <td align="left"><?php echo strtoupper($pack[$i][0]['sizename']); ?></td>		  
		  <td align="left"><?php echo strtoupper($pack[$i][0]['quantity']); ?></td>	
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo $pack[$i]['boxes']; ?></td>
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo $st; ?></td>
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo ($st*$pack[$i]['boxes']); ?></td>
		  <td align="center" rowspan="<?php echo count($pack[$i]);?>"><?php echo $row->memo; ?></td>	  
	</tr>
	<tr>
	<?php
		  $stems=0;
		  $stems+=$pack[$i][0]['quantity'];
		  $s=1;
		  while($s<count($pack[$i])){
		    $stems+=$pack[$i][$s]['quantity'];
		  ?>
		  <tr>
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['categoryname']); ?></td>
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['itemname']); ?></td>		  
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['sizename']); ?></td>	
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['quantity']); ?></td>
		</tr>
<!--  	    <tr><td colspan="8"><hr></td></tr>  -->
	<?
	$s++;
	}
	$stotal+=$stems*$pack[$i]['boxes'];
	?>
	</tr>
	<?php
	$i++;
	}
	
	$box = mysql_fetch_object(mysql_query("select distinct boxno, count(*) cnt from pos_packinglists where documentno='$doc'"));
	?>
	 	    <tr><td colspan="9"><hr></td></tr> 
	<tr style="font-weight:bold;font-size:16px">
	<td colspan="5" align="left"><strong>TOTAL</strong></td>
		  <td colspan="1" align="center"><strong><?php echo $box->cnt; ?></strong></td>
		  <td colspan="2" align="right"><strong><?php echo $stotal; ?></strong></td>
		  
	    </tr>
	
	
 <tr height="80" style="font-weight:bold;">
  <td>Farm Incharge:</td><td>  __________________________________</td><td> ___________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
  <tr height="80" style="font-weight:bold;">
  
  <td>Security Magana:</td><td>  ___________________________________</td><td> __________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
    <tr height="80" style="font-weight:bold;">
  
  <td>Airport Official:</td><td>  __________________________________ </td><td>__________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
   <tr height="80" style="font-weight:bold;">
  
  <td>Drop off:</td><td>  ___________________________________</td> <td>__________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
  </table>


<div style="font-size:11px !important;" align="center">Prepared by: &nbsp;<strong><?php echo $_SESSION['username']; ?></strong></div>

<!-- bodyend -->

<!-- foooter -->


<!-- footerend -->
<script type="text/javascript" language="javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.tablePagination.0.2.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery_003.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.easing.min.js"></script>


</body>

</html>
