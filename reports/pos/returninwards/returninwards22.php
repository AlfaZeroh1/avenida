<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/returninwards/Returninwards_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/prod/sizes/Sizes_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Returninwards";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8726";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

// if (empty($obj->action)){
// $obj->fromreturnedon=date('y-m-d');
// $obj->toreturnedon=date('y-m-d');

// }
if(empty($obj->action)){
	$obj->fromreturnedon=date('Y-m-d');
	$obj->toreturnedon=date('Y-m-d');
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
if(!empty($obj->grcustomerid) or !empty($obj->grdocumentno) or !empty($obj->grtype) or !empty($obj->grpackingno) or !empty($obj->gritemid) or !empty($obj->grreturnedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grsizeid) or !empty($obj->grcurrencyid) or !empty($obj->grvatable) or !empty($obj->grinvoiceno) ){
	$obj->shcustomerid='';
	$obj->shdocumentno='';
	$obj->shtype='';
	$obj->shpackingno='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shprice='';
	$obj->shexportprice='';
	$obj->shtax='';
	$obj->shdiscount='';
	$obj->shtotal='';
	$obj->shreturnedon='';
	$obj->shmemo='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shprofit='';
	$obj->shmixedbox='';
	$obj->shsizeid='';
	$obj->shboxno='';
	$obj->shcurrencyid='';
	$obj->shvatable='';
	$obj->shvat='';
	$obj->shexchangerate='';
	$obj->shexchangerate2='';
	$obj->shinvoiceno='';
	$obj->shcreditnotenos='';
}


	$obj->sh=1;
	$obj->grcustomerid=1;
	$obj->shtotal=1;
	$obj->shquantity=1;
	$obj->shvat=1;
	$obj->shdocumentno=1;
	$obj->shcreditnotenos=1;
	$obj->shinvoiceno=1;
	$obj->shprice=1;
	//$obj->shtype=1;


if(!empty($obj->grcustomerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" customerid ";
	$obj->shcustomerid=1;
	$track++;
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

if(!empty($obj->grtype)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" type ";
	$obj->shtype=1;
	$track++;
}

if(!empty($obj->grpackingno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" packingno ";
	$obj->shpackingno=1;
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

if(!empty($obj->grreturnedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" returnedon ";
	$obj->shreturnedon=1;
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

if(!empty($obj->grsizeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" sizeid ";
	$obj->shsizeid=1;
	$track++;
}

if(!empty($obj->grcurrencyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" currencyid ";
	$obj->shcurrencyid=1;
	$track++;
}

if(!empty($obj->grvatable)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" vatable ";
	$obj->shvatable=1;
	$track++;
}



if(!empty($obj->grinvoiceno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" invoiceno ";
	$obj->shinvoiceno=1;
	$track++;
}

//processing columns to show
          if(!empty($obj->sh)  or empty($obj->action)){
		array_push($sColumns, '1');
		array_push($aColumns, "1");
		$k++;
		}
	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$join=" left join crm_customers on crm_customers.id=pos_returninwards.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_returninwards.documentno");
		$k++;
		}
	if(!empty($obj->shtype)  or empty($obj->action)){
		array_push($sColumns, 'type');
		array_push($aColumns, "pos_returninwards.type");
		$k++;
		}

	if(!empty($obj->shpackingno)  or empty($obj->action)){
		array_push($sColumns, 'packingno');
		array_push($aColumns, "pos_returninwards.packingno");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name itemid");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		

		$join=" left join  pos_items on pos_items.id=pos_returninwarddetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	
	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup))
		  array_push($aColumns, "case when sum(pos_returninwarddetails.quantity)>0 then sum(pos_returninwarddetails.quantity) else 0 end quantity");
		else
		  array_push($aColumns, "case when pos_returninwarddetails.quantity>0 then pos_returninwarddetails.quantity else 0 end quantity");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shprice)  or empty($obj->action)){
		array_push($sColumns, 'price');
		array_push($aColumns, "sum(pos_returninwarddetails.price)");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		 $mnt=$k;
		}

	if(!empty($obj->shexportprice)  or empty($obj->action)){
		array_push($sColumns, 'exportprice');
		array_push($aColumns, "pos_returninwarddetails.exportprice");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "pos_returninwarddetails.tax");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "pos_returninwarddetails.discount");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shreturnedon)  or empty($obj->action)){
		array_push($sColumns, 'total');
		 if(!empty($rptgroup))
		  array_push($aColumns, "case when sum(pos_returninwarddetails.total)>0 then sum(pos_returninwarddetails.total) else 0 end total");
		else
		  array_push($aColumns, "case when pos_returninwarddetails.total>0 then pos_returninwarddetails.total else 0 end total");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
                
		}

	if(!empty($obj->shreturnedon)  or empty($obj->action)){
		array_push($sColumns, 'returnedon');
		array_push($aColumns, "pos_returninwards.returnedon");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "pos_returninwards.memo");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=pos_returninwards.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_returninwards.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_returninwards.ipaddress");
		$k++;
		}

	if(!empty($obj->shprofit) ){
		array_push($sColumns, 'profit');
		array_push($aColumns, "pos_returninwarddetails.profit");
		$k++;
		$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shmixedbox) ){
		array_push($sColumns, 'mixedbox');
		array_push($aColumns, "pos_returninwarddetails.mixedbox");
		$k++;
		
		
		}

	if(!empty($obj->shsizeid) ){
		array_push($sColumns, 'sizeid');
		array_push($aColumns, "pos_returninwarddetails.sizeid");
		$k++;
		
		
		}

	if(!empty($obj->shboxno)  or empty($obj->action)){
		array_push($sColumns, 'boxno');
		array_push($aColumns, "pos_returninwarddetails.boxno");
		$k++;
		}

// 	if(!empty($obj->shcurrencyid)  or empty($obj->action)){
// 		array_push($sColumns, 'currencyid');
// 		array_push($aColumns, "pos_returninwards.currencyid");
// 		$k++;
// 		//$join=" left join pos_returninwarddetails on pos_returninwards.id=pos_returninwarddetails.currencyid ";
// 		
// 		}
		
		
	if(!empty($obj->shcurrencyid)  or empty($obj->action)){
		array_push($sColumns, 'currencyid');
		array_push($aColumns, "sys_currencys.name as currencyid");
		$rptjoin.=" left join sys_currencys on sys_currencys.id=pos_returninwards.currencyid ";
		$k++;
		
}
	if(!empty($obj->shvatable)  or empty($obj->action)){
		array_push($sColumns, 'vatable');
		array_push($aColumns, "pos_returninwards.vatable");
		$k++;
		}

	if(!empty($obj->shvat) or empty($obj->action) ){
		array_push($sColumns, 'vat');
		array_push($aColumns, "pos_returninwards.vat");
		$k++;
		}

	if(!empty($obj->shexchangerate)  or empty($obj->action)){
		array_push($sColumns, 'exchangerate');
		array_push($aColumns, "pos_returninwards.exchangerate");
		$k++;
		}

	if(!empty($obj->shexchangerate2)  or empty($obj->action)){
		array_push($sColumns, 'exchangerate2');
		array_push($aColumns, "pos_returninwards.exchangerate2");
		$k++;
		}

	

	if(!empty($obj->shinvoiceno)  or empty($obj->action)){
		array_push($sColumns, 'invoiceno');
		array_push($aColumns, "concat(crm_customers.code,'',pos_invoices.invoiceno) invoiceno");
		
		$join=" left join pos_invoices on pos_returninwards.invoiceno=pos_invoices.documentno ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_customers on crm_customers.id=pos_returninwards.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}
		
	if(!empty($obj->shcreditnotenos)  or empty($obj->action)){
		array_push($sColumns, 'creditnotenos');
		array_push($aColumns, "pos_returninwards.creditnotenos");
		$k++;
		}




$track=0;

//processing filters
if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.customerid='$obj->customerid'";
		$join=" left join crm_customers on crm_customers.id=pos_returninwards.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->type)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.type='$obj->type'";
	$track++;
}

if(!empty($obj->packingno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.packingno='$obj->packingno'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_returninwarddetails.itemid='$obj->itemid' ";
	
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->quantity' ";
	$join=" left join pos_returninwarddetails on pos_returninwarddetails.id=pos_returninwarddetails.returninwarddetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->fromreturnedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.returnedon>='$obj->fromreturnedon'";
	$track++;
}

if(!empty($obj->toreturnedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.returnedon<='$obj->toreturnedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_returninwarddetails.sizeid='$obj->sizeid' ";

	
	$track++;
}

if(!empty($obj->currencyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.currencyid='$obj->currencyid'";
		
	$track++;
}

if(!empty($obj->vatable)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.vatable='$obj->vatable'";
	$track++;
}





if(!empty($obj->invoiceno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.invoiceno='$obj->invoiceno'";
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

  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=pos&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_returninwards";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_returninwards",
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
			var total=0;
			for(var i=0; i<aaData.length; i++){
			  for(var j=2; j<aaData[i].length; j++){
				if(j=="<?php echo $mnt;?>"){
				  total+=parseInt(aaData[i][j]);
				  $('th:eq('+j+')', nRow).html(total);
				}
				else{
				  $('th:eq('+j+')', nRow).html("");
				}
			  }
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
<form  action="returninwards.php" method="post" name="returninwards" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Receipt/Invoice No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
			  <td>Type</td>
			  <td><select name="type">
				<option value="">Select...</option>
				<option value="Quality Claim" <?php if($obj->type=="Quality Claim"){echo"selected";}?>>Quality Claim</option>
				<option value="Service Claim" <?php if($obj->type=="Service Claim"){echo"selected";}?>>Service Claim</option>
				 Returns</option>
			      </select>
			</tr>
			<tr>
				<td>Packing no</td>
				<td><input type='text' id='packingno' size='20' name='packingno' value='<?php echo $obj->packingno;?>'></td>
			</tr>
			<tr>
				<td>Product</td>
				<td>
				<select name='itemid' class='selectbox'>
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
			<tr>
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='20' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
			<tr>
				<td>Returned On</td>
				<td><strong>From:</strong><input type='text' id='fromreturnedon' size='12' name='fromreturnedon' readonly class="date_input" value='<?php echo $obj->fromreturnedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toreturnedon' size='12' name='toreturnedon' readonly class="date_input" value='<?php echo $obj->toreturnedon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="where id in(select createdby from pos_returninwards)";
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
				<td>Size</td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sizes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Currency</td>
				<td>
				<select name='currencyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$currencys=new Currencys();
				$where="  ";
				$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($currencys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->currencyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Vatable</td>
			</tr>
			
			<tr>
				<td>Invoice no</td>
				<td><input type='text' id='invoiceno' size='20' name='invoiceno' value='<?php echo $obj->invoiceno;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grpackingno' value='1' <?php if(isset($_POST['grpackingno']) ){echo"checked";}?>>&nbsp;Packing No</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
			<tr>
				<td><input type='checkbox' name='grreturnedon' value='1' <?php if(isset($_POST['grreturnedon']) ){echo"checked";}?>>&nbsp;Returned On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Size</td>
			<tr>
				<td><input type='checkbox' name='grcurrencyid' value='1' <?php if(isset($_POST['grcurrencyid']) ){echo"checked";}?>>&nbsp;Currency</td>
				<td><input type='checkbox' name='grvatable' value='1' <?php if(isset($_POST['grvatable']) ){echo"checked";}?>>&nbsp;Vatable</td>
			<tr>
				
				<td><input type='checkbox' name='grinvoiceno' value='1' <?php if(isset($_POST['grinvoiceno']) ){echo"checked";}?>>&nbsp;Invoice no</td>
				<td><input type='checkbox' name='grtype' value='1' <?php if(isset($_POST['grtype']) ){echo"checked";}?>>&nbsp;Type</td>
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
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shpackingno' value='1' <?php if(isset($_POST['shpackingno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Packing no</td>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shprice' value='1' <?php if(isset($_POST['shprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Price</td>
			<tr>
				<td><input type='checkbox' name='shexportprice' value='1' <?php if(isset($_POST['shexportprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Export price</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax']) ){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
			<tr>
				<td><input type='checkbox' name='shreturnedon' value='1' <?php if(isset($_POST['shreturnedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Returned On</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shprofit' value='1' <?php if(isset($_POST['shprofit']) ){echo"checked";}?>>&nbsp;Profit</td>
			<tr>
				<td><input type='checkbox' name='shmixedbox' value='1' <?php if(isset($_POST['shmixedbox']) ){echo"checked";}?>>&nbsp;Mixedbox</td>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid']) ){echo"checked";}?>>&nbsp;Size</td>
			<tr>
				<td><input type='checkbox' name='shboxno' value='1' <?php if(isset($_POST['shboxno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Box no</td>
				<td><input type='checkbox' name='shcurrencyid' value='1' <?php if(isset($_POST['shcurrencyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Currency</td>
			<tr>
				<td><input type='checkbox' name='shvatable' value='1' <?php if(isset($_POST['shvatable'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Vatable</td>
				<td><input type='checkbox' name='shvat' value='1' <?php if(isset($_POST['shvat']) or empty($obj->action) ){echo"checked";}?>>&nbsp;Vat</td>
			<tr>
				<td><input type='checkbox' name='shexchangerate' value='1' <?php if(isset($_POST['shexchangerate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Exchangerate</td>
				<td><input type='checkbox' name='shexchangerate2' value='1' <?php if(isset($_POST['shexchangerate2'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Exchangerate2</td>
			<tr>
				
				<td><input type='checkbox' name='shinvoiceno' value='1' <?php if(isset($_POST['shinvoiceno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Invoice no</td>
				<td><input type='checkbox' name='shcreditnotenos' value='1' <?php if(isset($_POST['shcreditnotenos'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Credit Note No</td>
			<tr>
			      <td><input type='checkbox' name='shtype' value='1' <?php if(isset($_POST['shtype'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Type</td>
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
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shtype==1  or empty($obj->action)){ ?>
				<th>Type </th>
			<?php } ?>
			<?php if($obj->shpackingno==1  or empty($obj->action)){ ?>
				<th>Packing No </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th> Quantity</th>
			<?php } ?>
			<?php if($obj->shprice==1  or empty($obj->action)){ ?>
				<th>Price </th>
			<?php } ?>
			<?php if($obj->shexportprice==1  or empty($obj->action)){ ?>
				<th>Export Price </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shreturnedon==1  or empty($obj->action)){ ?>
				<th>Returned On </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip Address </th>
			<?php } ?>
			<?php if($obj->shprofit==1 ){ ?>
				<th>Profit </th>
			<?php } ?>
			<?php if($obj->shmixedbox==1 ){ ?>
				<th>Mixed box </th>
			<?php } ?>
			<?php if($obj->shsizeid==1 ){ ?>
				<th>Size </th>
			<?php } ?>
			<?php if($obj->shboxno==1  or empty($obj->action)){ ?>
				<th>Box No </th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>Currency </th>
			<?php } ?>
			<?php if($obj->shvatable==1  or empty($obj->action)){ ?>
				<th>VATable </th>
			<?php } ?>
			<?php if($obj->shvat==1 or empty($obj->action)){ ?>
				<th>VAT </th>
			<?php } ?>
			<?php if($obj->shexchangerate==1  or empty($obj->action)){ ?>
				<th>Exchange Rate (Euro)</th>
			<?php } ?>
			<?php if($obj->shexchangerate2==1  or empty($obj->action)){ ?>
				<th>Exchange Rate (Kshs) </th>
			<?php } ?>
			
			<?php if($obj->shinvoiceno==1  or empty($obj->action)){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shcreditnotenos==1  or empty($obj->action)){ ?>
				<th>Credit Note No No </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	
	<tr>
			<th>#</th>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtype==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shpackingno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shprice==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shexportprice==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shreturnedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shprofit==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmixedbox==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shsizeid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shboxno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shvatable==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shvat==1 or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shexchangerate==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shexchangerate2==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shinvoiceno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreditnotenos==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
