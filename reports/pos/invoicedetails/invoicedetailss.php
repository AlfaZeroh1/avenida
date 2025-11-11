<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/invoicedetails/Invoicedetails_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Sales Report";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9057";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromsoldon=date('Y-m-d');
	$obj->tosoldon=date('Y-m-d');
	
	$obj->grsoldon=1;
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
if(!empty($obj->grdocumentno) or !empty($obj->grcustomerid) or !empty($obj->grsoldon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->gritemid) ){
// 	$obj->shdocumentno='';
// 	$obj->shcustomerid='';
// 	$obj->shsoldon='';
// 	$obj->shremarks='';
// 	$obj->shcreatedby='';
// 	$obj->shcreatedon='';
// 	$obj->shitemid='';
// 	$obj->shquantity='';
}


	
if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->grcustomerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" customerid ";
	$obj->shcustomerid=1;
	$track++;
}

if(!empty($obj->grcontinentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" continentid ";
	$obj->shcontinentid=1;
	$track++;
}

if(!empty($obj->grcountryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" countryid ";
	$obj->shcountryid=1;
	$track++;
}

if(!empty($obj->grsoldon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" soldon ";
	$obj->shsoldon=1;
	$track++;
}

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
	$track++;
}

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
	$track++;
}

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_invoices.documentno");
		$k++;
		}
	if(!empty($obj->shsoldon) ){
		array_push($sColumns, 'soldon');
		array_push($aColumns, "pos_invoices.soldon");
		$k++;
		}

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shcurrencyid)  or empty($obj->action)){
		array_push($sColumns, 'currencyid');
		array_push($aColumns, "sys_currencys.name currencyid");
		
		$join=" left join sys_currencys on sys_currencys.id=pos_invoices.currencyid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}
		
	if(!empty($obj->shcontinentid)){
		array_push($sColumns, 'continentid');
		array_push($aColumns, "crm_continents.name continentid");
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_continents on crm_continents.id=crm_customers.continentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}
		
	if(!empty($obj->shcountryid)){
		array_push($sColumns, 'countryid');
		array_push($aColumns, "crm_countrys.name countryid");
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_countrys on crm_countrys.id=crm_customers.countryid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_invoices.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "pos_invoices.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_invoices.createdon");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		
		$in="";
		for($i=0;$i<count($obj->paymenttermid);$i++){
		  $in.=$obj->paymenttermid[$i].",";
		}
		$in=substr($in,0,-1);
		
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name itemid");
		$k++;
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

// 	if(!empty($obj->shquantity)  or empty($obj->action)){
// 		array_push($sColumns, 'quantity');
// 		array_push($aColumns, "pos_invoicedetails.quantity");
// 		$k++;
// 		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
// 		}


$mnt = ($k+1);
$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.customerid='$obj->customerid'";
		
	$track++;
}

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

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		
	$in="";
	for($i=0;$i<count($obj->itemid);$i++){
	  $in.=$obj->itemid[$i].",";
	}
	$in=substr($in,0,-1);
		
	$rptwhere.=" pos_items.id in($in) ";
	$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
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

});
</script>
<script type="text/javascript" charset="utf-8">

<?php

 $sizes=new Sizes();
  $where="  ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

  
  $cols="";
  while($rw=mysql_fetch_object($sizes->result)){
    if(!empty($obj->shquantity)){
      $cols=" case when sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end) is null then '' else sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end) end '$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, $rw->name);
    }
    
    if(!empty($obj->shtotal)){
      $cols=" case when sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total end) is null then '' else round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total end),2) end 't$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "t".$rw->name);
    }
    
    if(!empty($obj->shkshs)){
      $cols=" case when sum(case when pos_invoicedetails.sizeid=$rw->id then (pos_invoicedetails.total*pos_invoices.exchangerate2) end) is null then '' else round(sum(case when pos_invoicedetails.sizeid=$rw->id then (pos_invoicedetails.total*pos_invoices.exchangerate2) end),2) end 'kshs$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "kshs".$rw->name);
    }
    
    if(!empty($obj->sheuro)){
      $cols=" case when sum(case when pos_invoicedetails.sizeid=$rw->id then (pos_invoicedetails.total*pos_invoices.exchangerate) end) is null then '' else round(sum(case when pos_invoicedetails.sizeid=$rw->id then (pos_invoicedetails.total*pos_invoices.exchangerate) end),2) end 'euro$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "euro".$rw->name);
    }
    $k++;
  }
$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	if(!empty($obj->shquantity)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(pos_invoicedetails.quantity) quantity");
		}else{
		array_push($aColumns, "pos_invoicedetails.quantity");
		}

		$k++;
		
	}
		
	if(!empty($obj->shtotal)){
		array_push($sColumns, 'total');
		if(!empty($rptgroup)){
			array_push($aColumns, "round(sum(pos_invoicedetails.total),2) total");
		}else{
		array_push($aColumns, "round(pos_invoicedetails.total) total");
		}

		$k++;
		
	}
	
	if(!empty($obj->shkshs)){
		array_push($sColumns, 'kshstotal');
		if(!empty($rptgroup)){
			array_push($aColumns, "round(sum(pos_invoicedetails.total*pos_invoices.exchangerate2),2) kshstotal");
		}else{
		array_push($aColumns, "round((pos_invoicedetails.total*pos_invoices.exchangerate2),2) kshstotal");
		}

		$k++;
		
	}
	
	if(!empty($obj->sheuro)){
		array_push($sColumns, 'eurototal');
		if(!empty($rptgroup)){
			array_push($aColumns, "round(sum(pos_invoicedetails.total*pos_invoices.exchangerate),2) eurototal");
		}else{
		array_push($aColumns, "round((pos_invoicedetails.total*pos_invoices.exchangerate),2) eurototal");
		}

		$k++;
		
	}
		

?>
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_invoices";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_invoices",
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
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=<?php echo $mnt; ?>; j<aaData[i].length; j++){
			    if(aaData[i][j]=='')
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				
				total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
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
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>&nbsp;<?php if(!empty($rptgroup)){?><a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a><?php } ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter</h4>
      </div>
      <div class="modal-body">
<form  action="invoicedetailss.php" method="post" name="invoices" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Order No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Ordered On</td>
				<td><strong>From:</strong><input type='text' id='fromsoldon' size='12' name='fromsoldon' readonly class="date_input" value='<?php echo $obj->fromsoldon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tosoldon' size='12' name='tosoldon' readonly class="date_input" value='<?php echo $obj->tosoldon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="where id in(select createdby from pos_invoices)";
				$join="   ";
				$having="";
				$groupby="";
				$orderby="";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->username;?></option>
				<?php
				}
				?>
			</td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
			<tr>
				<td>item</td>
				<td>
				<select name='itemid[]' class='selectbox' multiple='multiple'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($items->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grcontinentid' value='1' <?php if(isset($_POST['grcontinentid']) ){echo"checked";}?>>&nbsp;Continent</td>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
			<tr>
				<td><input type='checkbox' name='grsoldon' value='1' <?php if(isset($_POST['grsoldon']) or empty($obj->action)){echo"checked";}?>>&nbsp;Ordered On</td>
				<td><input type='checkbox' name='grcountryid' value='1' <?php if(isset($_POST['grcountryid']) ){echo"checked";}?>>&nbsp;Country</td>
			<!--<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;item</td>-->
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
			<tr>
				<td><input type='checkbox' name='shcurrencyid' value='1' <?php if(isset($_POST['shcurrencyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Currency</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shkshs' value='1' <?php if(isset($_POST['shkshs'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Kshs</td>
				<td><input type='checkbox' name='sheuro' value='1' <?php if(isset($_POST['sheuro'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Euro</td>
				
			<tr>
				<td><input type='checkbox' name='shcontinentid' value='1' <?php if(isset($_POST['shcontinentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Continent</td>
				<td><input type='checkbox' name='shcountryid' value='1' <?php if(isset($_POST['shcountryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Country</td>
				
			<tr>
				<td><input type='checkbox' name='shsoldon' value='1' <?php if(isset($_POST['shsoldon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Sold On</td>
<!-- 				<td><input type='checkbox' name='shcountryid' value='1' <?php if(isset($_POST['shcountryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Country</td> -->
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Order No </th>
			<?php } ?>
			
			<?php if($obj->shsoldon==1){ ?>
				<th>SOLD On </th>
			<?php } ?>
			
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>CUR </th>
			<?php } ?>
			<?php if($obj->shcontinentid==1){ ?>
				<th>Continent </th>
			<?php } ?>
			<?php if($obj->shcountryid==1){ ?>
				<th>Country </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>Created By</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On</th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product</th>
			<?php } ?>
			<?php if($obj->shquantity==1 or $obj->shtotal==1 or $obj->sheuro==1 or $obj->shkshs==1){ 
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				  <th><?php echo "Q".$rw->name; ?></th>
				<?php } ?>
				<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				  <th><?php echo "A".$rw->name; ?></th>
				<?php } ?>
				
				<?php if($obj->sheuro==1){ ?>
				  <th><?php echo "E".$rw->name; ?></th>
				<?php } ?>
				
				<?php if($obj->shkshs==1){ ?>
				  <th><?php echo "K".$rw->name; ?></th>
				<?php } ?>
			<?php }} ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Sub Total</th>
			<?php } ?>
			
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Sub Total</th>
			<?php } ?>
			
			<?php if($obj->sheuro==1){ ?>
				<th>Sub Total</th>
			<?php } ?>
			
			<?php if($obj->shkshs==1){ ?>
				<th>Sub Total</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	    <tr>
			<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shquantity==1 or $obj->shtotal==1 or $obj->sheuro==1 or $obj->shkshs==1){ 
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				  <th>&nbsp;</th>
				<?php } ?>
				
				<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				  <th>&nbsp;</th>
				<?php } ?>
				
				<?php if($obj->sheuro==1){ ?>
				  <th>&nbsp;</th>
				<?php } ?>
				
				<?php if($obj->shkshs==1){ ?>
				  <th>&nbsp;</th>
				<?php } ?>
			<?php }} ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php if($obj->sheuro==1){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shkshs==1){ ?>
				<th>&nbsp;</th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
