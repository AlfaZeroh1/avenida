<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/invoices/Invoices_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/crm/agents/Agents_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/pos/saletypes/Saletypes_class.php");
require_once("../../../modules/pos/invoiceconsumables/Invoiceconsumables_class.php");


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
	$obj->fromsoldon=date('Y-m-d');
	$obj->tosoldon=date('Y-m-d');
	
	$obj->grcustomerid=1;
}

$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;

$obj->shinvoiceno=1;
$obj->grcustomerid=1;
$obj->shcustomerid=1;
$obj->shsoldon=1;
$obj->shcountryid=1;
$obj->shremarks=1;
$obj->shpin=1;
$obj->shetr=1;
$obj->shvatno=1;
$obj->shvat=1;
$obj->shgross=1;
$obj->shtotal=1;

if(!empty($obj->grcustomerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" pos_invoices.invoiceno ";
	$obj->shcustomerid=1;
	$track++;
}


//processing columns to show

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	  
		$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$rptjoin.=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		$k++;
		}
		
		
		if(!empty($obj->shinvoiceno) ){
		array_push($sColumns, 'invoiceno');
		//array_push($aColumns, "pos_invoices.invoiceno");
		array_push($aColumns, "CONCAT(crm_customers.code,'',pos_invoices.invoiceno) as invoiceno");
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid  ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}
		
		
		if(!empty($obj->shsoldon)  or empty($obj->action)){
		array_push($sColumns, 'soldon');
		array_push($aColumns, "pos_invoices.soldon");
		$k++;
		}
		
		if(!empty($obj->shcountryid)){
		array_push($sColumns, 'countryid');
		array_push($aColumns, "crm_countrys.name countryid");
		$k++;
		
		$join=" left join crm_countrys on crm_countrys.id=crm_customers.countryid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
		if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_invoices.remarks");
		$k++;
		}
		
		if(!empty($obj->shpin)  or empty($obj->action)){
		array_push($sColumns, 'customerpin');
		array_push($aColumns, "crm_customers.pinno as customerpin");
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}
		if(!empty($obj->shvatno)  or empty($obj->action)){
		array_push($sColumns, 'vatno');
		array_push($aColumns, "crm_customers.vatno as vatno");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}
		if(!empty($obj->shetr)  or empty($obj->action)){
		array_push($sColumns, 'etrno');
		array_push($aColumns, "crm_customers.etrno as etrno");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}
		
	      if(!empty($obj->shgross)  or empty($obj->action)){
		array_push($sColumns, 'gross');		
		array_push($aColumns, "round((sum((pos_invoicedetails.quantity*pos_invoicedetails.price*pos_invoices.exchangerate))+(select case when sum((pos_invoiceconsumables.quantity*pos_invoiceconsumables.price*pos_invoices.exchangerate)) is null then 0 else sum((pos_invoiceconsumables.quantity*pos_invoiceconsumables.price*pos_invoices.exchangerate)) end from pos_invoiceconsumables where invoiceid=pos_invoices.id)),2) gross");
		$join=" left join pos_invoiceconsumables on pos_invoices.id=pos_invoiceconsumables.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		$mnt=$k;
	      }
	      
	      if(!empty($obj->shvat)  or empty($obj->action)){
		array_push($sColumns, 'vat');	
		array_push($aColumns, "round(case when sum((pos_invoicedetails.total-(pos_invoicedetails.quantity*pos_invoicedetails.price))*pos_invoices.exchangerate)<0 then 0 else sum((pos_invoicedetails.total-(pos_invoicedetails.quantity*pos_invoicedetails.price))*pos_invoices.exchangerate) end,2) vat");
// 		array_push($aColumns, "round(sum((pos_invoicedetails.total-(pos_invoicedetails.quantity*pos_invoicedetails.price))),2) vat");
		$join=" left join pos_invoiceconsumables on pos_invoices.id=pos_invoiceconsumables.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
	      }
	      
	      if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');		
		array_push($aColumns, "round((sum(pos_invoicedetails.total*pos_invoices.exchangerate)+(select case when sum(pos_invoiceconsumables.total*pos_invoices.exchangerate) is null then 0 else sum(pos_invoiceconsumables.total*pos_invoices.exchangerate) end from pos_invoiceconsumables where invoiceid=pos_invoices.id)),2) total");
		$join=" left join pos_invoiceconsumables on pos_invoices.id=pos_invoiceconsumables.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
	      }
// $mnt=($k+1);
$track=0;

//processing filters
if(!empty($obj->fromsoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.soldon>='$obj->fromsoldon'";
	$track++;
}

if(!empty($obj->tosoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.soldon<='$obj->tosoldon'";
	$track++;
}
if(!empty($obj->showvat) and $obj->showvat=="vatable"){
$having='having vat>0 ';
}

elseif(!empty($obj->showvat) and $obj->showvat=="nonvatable"){
$having='having vat=0 ';
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
	}
  });

  $("#agentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=agents&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#agentid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_invoicedetails";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup $having";?>
 
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_invoicedetails",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
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
			  $('th:eq('+i+')', nRow).html(total[i]).formatCurrency();
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
<form  action="salesvats.php" class="forms" method="post" name="Sales Vats">
<table>
From: <input type="text" size="12" class="date_input" name="fromsoldon" value="<?php echo $obj->fromsoldon; ?>"/></td>
<td>To: <input type="text" size="12" class="date_input" name="tosoldon" value="<?php echo $obj->tosoldon; ?>"/>&nbsp;
Vatable:&nbsp;<select name='showvat' id='showvat' class='selectbox'>
<option value="">Select...</option>
<option value="vatable" <?php if($obj->showvat=='vatable'){echo "selected";}?>>Vatable</option>
<option value="nonvatable" <?php if($obj->showvat=='nonvatable'){echo "selected";}?>>Non-Vatable</option>
</select>
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
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			<?php if($obj->shinvoiceno==1  or empty($obj->action)){ ?>
				<th>Invoice No  </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>Sold On  </th>
			<?php } ?>
			<?php if($obj->shcountryid==1  or empty($obj->action)){ ?>
				<th>Destination Country  </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shpin==1  or empty($obj->action)){ ?>
				<th>Pin No: </th>
			<?php } ?>	
			<?php if($obj->shvatno==1  or empty($obj->action)){ ?>
				<th>VAT No: </th>
			<?php } ?>
			<?php if($obj->shetr==1  or empty($obj->action)){ ?>
				<th>ETR No: </th>
			<?php } ?>
			<?php if($obj->shgross==1 or empty($obj->action)){ ?>
				<th>Gross Amount </th>
			<?php } ?>
			
			<?php if($obj->shvat==1 or empty($obj->action)){ ?>
				<th>VAT </th>
			<?php } ?>
			<?php if($obj->shtotal==1 or empty($obj->action)){ ?>
				<th>NET Amt</th>
			<?php } ?>
		</tr>
		
	</thead>
	<tbody>
	<tfoot>
	<tr>
	<th>#</th>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shinvoiceno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcountryid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpin==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shvatno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shetr==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shgross==1 or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shvat==1 or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotal==1 or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
		</tr>
	<tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
