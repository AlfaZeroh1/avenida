<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/returninwards/Returninwards_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/inv/items/Items_class.php");
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
if(!empty($obj->grcustomerid) or !empty($obj->grdocumentno) or !empty($obj->grcreditnoteno) or !empty($obj->gritemid) or !empty($obj->grreturnedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shcustomerid='';
	$obj->shdocumentno='';
	$obj->shgrcreditnoteno='';
	$obj->shmode='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shcostprice='';
	$obj->shretailprice='';
	$obj->shtradeprice='';
	$obj->shtax='';
	$obj->shdiscount='';
	$obj->shtotal='';
	$obj->shreturnedon='';
	$obj->shmemo='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
}


	$obj->sh=1;


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

if(!empty($obj->grcreditnoteno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" creditnoteno ";
	$obj->shcreditnoteno=1;
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

//processing columns to show
	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "pos_returninwards.customerid");
		$k++;
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_returninwards.documentno");
		$k++;
		}

	if(!empty($obj->shgrcreditnoteno)  or empty($obj->action)){
		array_push($sColumns, 'creditnoteno');
		array_push($aColumns, "pos_returninwards.creditnoteno");
		$k++;
		}

	if(!empty($obj->shmode)  or empty($obj->action)){
		array_push($sColumns, 'mode');
		array_push($aColumns, "pos_returninwards.mode");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name as itemid");
		$rptjoin.=" left join pos_items on pos_items.id=pos_returninwards.itemid ";
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "pos_returninwards.quantity");
		$k++;
		}

	if(!empty($obj->shcostprice)  or empty($obj->action)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "pos_returninwards.costprice");
		$k++;
		}

	if(!empty($obj->shretailprice)  or empty($obj->action)){
		array_push($sColumns, 'retailprice');
		array_push($aColumns, "pos_returninwards.retailprice");
		$k++;
		}

	if(!empty($obj->shtradeprice)  or empty($obj->action)){
		array_push($sColumns, 'tradeprice');
		array_push($aColumns, "pos_returninwards.tradeprice");
		$k++;
		}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "pos_returninwards.tax");
		$k++;
		}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "pos_returninwards.discount");
		$k++;
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		array_push($aColumns, "pos_returninwards.total");
		$k++;
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
		array_push($aColumns, "pos_returninwards.createdby");
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



$track=0;

//processing filters
if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.customerid='$obj->customerid'";
		$join=" left join crm_customers on pos_returninwards.id=crm_customers.returninwardid ";
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

if(!empty($obj->creditnoteno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.creditnoteno='$obj->creditnoteno'";
	$track++;
}

if(!empty($obj->mode)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.mode='$obj->mode'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.itemid='$obj->itemid'";
		$join=" left join inv_items on pos_returninwards.id=inv_items.returninwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_returninwards.quantity='$obj->quantity'";
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
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
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
// 	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	 
	 
	
				
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=post_graded",
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
				<td>Credit Note No</td>
				<td><input type='text' id='creditnoteno' size='20' name='creditnoteno' value='<?php echo $obj->creditnoteno;?>'></td>
			</tr>
			<tr>
				<td>Mode</td>
			</tr>
			<tr>
				<td>Item</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
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
				$where="";
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
				<td><input type='checkbox' name='grcreditnoteno' value='1' <?php if(isset($_POST['grcreditnoteno']) ){echo"checked";}?>>&nbsp;Credit Note No</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
			<tr>
				<td><input type='checkbox' name='grreturnedon' value='1' <?php if(isset($_POST['grreturnedon']) ){echo"checked";}?>>&nbsp;Returned On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<td><input type='checkbox' name='shgrcreditnoteno' value='1' <?php if(isset($_POST['shgrcreditnoteno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Credit Note No</td>
				<td><input type='checkbox' name='shmode' value='1' <?php if(isset($_POST['shmode'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Mode</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Cost Price</td>
				<td><input type='checkbox' name='shretailprice' value='1' <?php if(isset($_POST['shretailprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Retail Price</td>
			<tr>
				<td><input type='checkbox' name='shtradeprice' value='1' <?php if(isset($_POST['shtradeprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Trade Price</td>
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
				<th>Receipt/Invoice No </th>
			<?php } ?>
			<?php if($obj->shgrcreditnoteno==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shmode==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shretailprice==1  or empty($obj->action)){ ?>
				<th>Retail Price </th>
			<?php } ?>
			<?php if($obj->shtradeprice==1  or empty($obj->action)){ ?>
				<th>Trade Price </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>VAT </th>
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
				<th> </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</div>
</div>
</div>
</div>
</div>
