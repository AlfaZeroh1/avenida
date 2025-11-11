<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/purchases/Purchases_class.php");
require_once("../../../modules/inv/purchasedetails/Purchasedetails_class.php");
require_once("../../../modules/inv/assets/Assets_class.php");
require_once("../../../modules/crm/countrys/Countrys_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Invoices";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8728";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromboughton=date('Y-m-d');
	$obj->toboughton=date('Y-m-d');
	
	$obj->grsupplierid=1;
}

$aColumns = array('1','name','pinno','vatno','etrno','transactdate','documentno','country', 'remarks','gross','vatamount','net');
$sColumns = array('1','name','pinno','vatno','etrno','transactdate','documentno','country', 'remarks','gross','vatamount','net');
$rptjoin="";
$rptwhere=" transactdate between '$obj->fromboughton' and '$obj->toboughton' ";
$rptgroup="";
$mnt=6;

?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="vats";?>
 <?php $_SESSION['sOrder']=" order by transactdate asc";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=vats",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				  if(i>8)
				    $('td:eq('+i+')', nRow).html(aaData[i]).formatCurrency();
				  else
				    $('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			for(var i=2; i<"<?php echo $mnt; ?>"; i++){
			  $('th:eq('+i+')', nRow).html("");
			}
			var total=[];
			
			
			for(var i=0; i<aaData.length; i++){
			  if(i==0){
			    for(var j="<?php echo $mnt;?>"; j<=aaData[i].length; j++){
			      total[j]=0;
			    }
			  }
			  for(var j="<?php echo $mnt;?>"; j<=aaData[i].length; j++){
			  
			    total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);
			    total[j]=total[j].toFixed(2);
			  }
			}
			
			for(var i=<?php echo $mnt; ?>; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
			}
		}
 	} );
 } );
 </script>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<?php if($obj->filter){?>
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;"></a></div>
<?php }?>
<form  action="vats.php" class="forms" method="post" name="Sales Vats">
<table>
From: <input type="text" size="12" class="date_input" name="fromboughton" value="<?php echo $obj->fromboughton; ?>"/></td>
<td>To: <input type="text" size="12" class="date_input" name="toboughton" value="<?php echo $obj->toboughton; ?>"/>&nbsp;
<!--<select name='showvat' id='showvat' class='selectbox'>
<option value="">Select...</option>
<option value="gt0" <?php if($obj->showvat=='gt0'){echo "selected";}?>>Greater than zero</option>
</select>-->
<input type="submit" name="action" value="Filter"/>
</td>
</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<div style="clear"></div>
<div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Pin No: </th>
			<th>VAT No: </th>
			<th>ETR No: </th>
			<th>Date: </th>
			<th>Document No </th>
			<th>Country </th>
			<th>Remarks</th>
			<th>Gross Amount </th>
			<th>VAT </th>
			<th>NET Amt</th>
		</tr>
		
	</thead>
	<tbody>
	<tfoot>
	<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	<tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
