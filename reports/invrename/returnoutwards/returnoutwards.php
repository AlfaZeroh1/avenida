<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/returnoutwards/Returnoutwards_class.php");
require_once("../../../modules/inv/returnoutwarddetails/Returnoutwarddetails_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/purchasemodes/Purchasemodes_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Returnoutwards";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

$rptwhere='';
$rptjoin='';
$track=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "fn_suppliers.name as supplierid");
		$rptjoin.=" left join fn_suppliers on fn_suppliers.id=inv_returnoutwards.supplierid ";
	}

	if(!empty($obj->shdocumentno) ){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "inv_returnoutwards.documentno");
	}

	if(!empty($obj->shpurchaseno)  or empty($obj->action)){
		array_push($sColumns, 'purchaseno');
		array_push($aColumns, "inv_returnoutwards.purchaseno");
	}

	if(!empty($obj->shpurchasemodeid)  or empty($obj->action)){
		array_push($sColumns, 'purchasemodeid');
		array_push($aColumns, "sys_purchasemodes.name as purchasemodeid");
		$rptjoin.=" left join sys_purchasemodes on sys_purchasemodes.id=inv_returnoutwards.purchasemodeid ";
	}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$rptjoin.=" left join inv_items on inv_items.id=inv_returnoutwards.itemid ";
	}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_returnoutwards.quantity");
	}

	if(!empty($obj->shcostprice) ){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "inv_returnoutwards.costprice");
	}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "inv_returnoutwards.tax");
	}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "inv_returnoutwards.discount");
	}

	if(!empty($obj->shtotal) ){
		array_push($sColumns, 'total');
		array_push($aColumns, "inv_returnoutwards.total");
	}

	if(!empty($obj->returnedon)  or empty($obj->action)){
		array_push($sColumns, 'turnedon');
		array_push($aColumns, "inv_returnoutwards.turnedon");
	}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "inv_returnoutwards.memo");
	}

	if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "inv_returnoutwards.createdby");
	}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "inv_returnoutwards.createdon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "inv_returnoutwards.ipaddress");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.supplierid='$obj->supplierid'";
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->purchaseno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.purchaseno='$obj->purchaseno'";
	$track++;
}

if(!empty($obj->purchasemodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.purchasemodeid='$obj->purchasemodeid'";
	$track++;
}

if(!empty($obj->itemid	)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.itemid	='$obj->itemid	'";
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.quantity='$obj->quantity'";
	$track++;
}

if(!empty($obj->costprice)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.costprice='$obj->costprice'";
	$track++;
}

if(!empty($obj->fromreturnedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.returnedon>='$obj->fromreturnedon'";
	$track++;
}

if(!empty($obj->toreturnedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.returnedon<='$obj->toreturnedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnoutwards.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grsupplierid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supplierid ";
	$obj->shsupplierid=1;
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

if(!empty($obj->grpurchaseno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" purchaseno ";
	$obj->shpurchaseno=1;
	$track++;
}

if(!empty($obj->grpurchasemodeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" purchasemodeid ";
	$obj->shpurchasemodeid=1;
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

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
	}
  });

  $("#purchasemodename").autocomplete({
	source:"../../../modules/server/server/search.php?main=sys&module=purchasemodes&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#purchasemodeid").val(ui.item.id);
	}
  });

  $("#iteminame").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid	").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="inv_returnoutwards";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_returnoutwards",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
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
<form  action="returnoutwards.php" method="post" name="returnoutwards" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Purchase Invoice/Receipt No	</td>
				<td><input type='text' id='purchaseno' size='20' name='purchaseno' value='<?php echo $obj->purchaseno;?>'></td>
			</tr>
			<tr>
				<td>Mode Of Payment	</td>
				<td><input type='text' size='20' name='purchasemodename' id='purchasemodename' value='<?php echo $obj->purchasemodename; ?>'>
					<input type="hidden" name='purchasemodeid' id='purchasemodeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Item</td>
				<td><input type='text' size='20' name='iteminame' id='iteminame' value='<?php echo $obj->iteminame; ?>'>
					<input type="hidden" name='itemid	' id='itemid	' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='20' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
			<tr>
				<td>Cost Price</td>
				<td><input type='text' id='costprice' size='20' name='costprice' value='<?php echo $obj->costprice;?>'></td>
			</tr>
			<tr>
				<td>Returned On	</td>
				<td><strong>From:</strong><input type='text' id='fromreturnedon' size='12' name='fromreturnedon' readonly class="date_input" value='<?php echo $obj->fromreturnedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toreturnedon' size='12' name='toreturnedon' readonly class="date_input" value='<?php echo $obj->toreturnedon;?>'/></td>
			</tr>
			<tr>
				<td>Returned By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="";
				$join=" left join  ";
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
				<td>Created On	</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='20' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='20' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grpurchaseno' value='1' <?php if(isset($_POST['grpurchaseno']) ){echo"checked";}?>>&nbsp;Purchase Invoice/Receipt No	</td>
				<td><input type='checkbox' name='grpurchasemodeid' value='1' <?php if(isset($_POST['grpurchasemodeid']) ){echo"checked";}?>>&nbsp;Mode Of Payment	</td>
			<tr>
				<td><input type='checkbox' name='grreturnedon' value='1' <?php if(isset($_POST['grreturnedon']) ){echo"checked";}?>>&nbsp;Returned On	</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Returned By</td>
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
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shpurchaseno' value='1' <?php if(isset($_POST['shpurchaseno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purchase Invoice/Receipt No	</td>
				<td><input type='checkbox' name='shpurchasemodeid' value='1' <?php if(isset($_POST['shpurchasemodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Mode Of Payment	</td>
			<tr>
				<td><input type='checkbox' name='shitemid	' value='1' <?php if(isset($_POST['shitemid	'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice']) ){echo"checked";}?>>&nbsp;Cost Price</td>
				<td><input type='checkbox' name='shtax	' value='1' <?php if(isset($_POST['shtax	']) ){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal']) ){echo"checked";}?>>&nbsp;Total</td>
			<tr>
				<td><input type='checkbox' name='returnedon' value='1' <?php if(isset($_POST['returnedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Returned On	</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Returned By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
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
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shpurchaseno==1  or empty($obj->action)){ ?>
				<th>Purchase Invoice/Receipt No </th>
			<?php } ?>
			<?php if($obj->shpurchasemodeid==1  or empty($obj->action)){ ?>
				<th>Mode Of Payment </th>
			<?php } ?>
			<?php if($obj->shitemid	==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shcostprice==1 ){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shtax	==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shtotal==1 ){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->returnedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
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
