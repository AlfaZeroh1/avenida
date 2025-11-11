<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/proc/purchaseorders/Purchaseorders_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/proc/purchaseorders/Purchaseorders_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Purchaseorders";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8775";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromorderedon=date('Y-m-d');
	$obj->toorderedon=date('Y-m-d');
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
if(!empty($obj->gritemid) or !empty($obj->grdocumentno) or !empty($obj->grrequisionno) or !empty($obj->grsupplierid) or !empty($obj->grorderedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grpurchaseorderid) or !empty($obj->grcurrencyid) ){
	$obj->shitemid='';
	$obj->shdocumentno='';
	$obj->shrequisionno='';
	$obj->shsupplierid='';
	$obj->shquantity='';
	$obj->shcostprice='';
	$obj->shtradeprice='';
	$obj->shtax='';
	$obj->shtotal='';
	$obj->shorderedon='';
	$obj->shremarks='';
	$obj->shmemo='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shpurchaseorderid='';
	$obj->shcurrencyid='';
	$obj->shrate='';
	$obj->sheurorate='';
	
}


	$obj->shquantity=1;
	$obj->shtotal=1;


if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
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

if(!empty($obj->grrequisionno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" requisionno ";
	$obj->shrequisionno=1;
	$track++;
}

if(!empty($obj->grsupplierid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supplierid ";
	$obj->shsupplierid=1;
	$track++;
}

if(!empty($obj->grorderedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" orderedon ";
	$obj->shorderedon=1;
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

if(!empty($obj->grpurchaseorderid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" purchaseorderid ";
	$obj->shpurchaseorderid=1;
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

//processing columns to show
	if(true){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(true){
		array_push($sColumns, 'requisitionno');
		array_push($aColumns, "proc_purchaseorders.requisitionno");
		$k++;
		}
		
	if(true){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "proc_purchaseorders.documentno");
		$k++;
		}

	if(true){
		array_push($sColumns, 'orderedon');
		array_push($aColumns, "proc_purchaseorders.orderedon");
		$k++;
		}

	if(true){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=proc_purchaseorders.supplierid ";
		$k++;
		}
		
	if(true){
		array_push($sColumns, 'qtyreq');
		array_push($aColumns, "proc_purchaseorders.id qtyreq");
		$k++;
		}

	if(true){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_purchaseorderdetails.quantity) quantity");
		}else{
		array_push($aColumns, "proc_purchaseorderdetails.quantity");
		}

		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$mnt=$k;
		
		}
		
	if(true){
		array_push($sColumns, 'qtyrec');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_inwarddetails.quantity) qtrec");
		}else{
		array_push($aColumns, "proc_inwarddetails.quantity as qtrec");
		}

		$k++;
		
		
		$join="left join proc_inwards on proc_inwards.lpono=proc_purchaseorders.documentno ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_inwarddetails on proc_inwards.id=proc_inwarddetails.inwardid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$mnt=$k;
		
		}
	if(true){
	      array_push($sColumns, 'balance');
	      array_push($aColumns,10);
	}

	if(true){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "proc_purchaseorderdetails.costprice");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(true){
		array_push($sColumns, 'tradeprice');
		array_push($aColumns, "proc_purchaseorderdetails.costprice");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}


	if(true ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "proc_purchaseorders.remarks");
		$k++;
		}


$track=0;

//processing filters
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid ";
	
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->requisitionno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.requisitionno='$obj->requisitionno'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.supplierid='$obj->supplierid'";
		$join=" left join proc_suppliers on proc_purchaseorders.id=proc_suppliers.purchaseorderid ";
		
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->quantity' ";
	$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
	
	$join=" left join  on .id=proc_purchaseorderdetails.quantity ";
	
	$track++;
}

if(!empty($obj->fromorderedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.orderedon>='$obj->fromorderedon'";
	$track++;
}

if(!empty($obj->toorderedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.orderedon<='$obj->toorderedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->purchaseorderid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorderdetails.purchaseorderid='$obj->purchaseorderid'";
		$join=" left join proc_purchaseorderdetails on proc_purchaseorderdetails.id=proc_purchaseorders.purchaseorderid ";
		
	$track++;
}

if(!empty($obj->currencyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_purchaseorders.currencyid='$obj->currencyid'";
		$join=" left join sys_currencys on proc_purchaseorders.id=sys_currencys.purchaseorderid ";
		
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
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

  $("#purchaseordername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=purchaseorders&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#purchaseorderid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="proc_purchaseorders";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=proc_purchaseorders",
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
<form  action="purchaseorders.php" method="post" name="purchaseorders" >
<table width="100%" border="0" align="center">
	<tr>
				<td>Item</td>
				<td>
				<select name='itemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
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
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Requisition No</td>
				<td><input type='text' id='requisitionno' size='20' name='requisitionno' value='<?php echo $obj->requisitionno;?>'></td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='20' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
			<tr>
				<td>Order On</td>
				<td><strong>From:</strong><input type='text' id='fromorderedon' size='12' name='fromorderedon' readonly class="date_input" value='<?php echo $obj->fromorderedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toorderedon' size='12' name='toorderedon' readonly class="date_input" value='<?php echo $obj->toorderedon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from proc_purchaseorders) ";
				$join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
				$having="";
				$groupby="";
				$orderby=" order by employeename ";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->employeeid;?></option>
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
				<td>Purchaseorder</td>
				<td><input type='text' size='20' name='purchaseordername' id='purchaseordername' value='<?php echo $obj->purchaseordername; ?>'>
					<input type="hidden" name='purchaseorderid' id='purchaseorderid' value='<?php echo $obj->field; ?>'></td>
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
				<td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
			</tr>
		</table>
		
</form>
</div>
</div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>            
		      <th>#</th>
		      <th>Item</th>
		      <th>Requisition No</th>
		      <th>LPO No</th>
		      <th>LPO Date</th>
		      <th>Supplier</th>
		      <th>Qty Requested</th>
		      <th>Qty Ordered</th>
		      <th>Qty Received</th>
		      <th>Balance</th>
		      <th>Expected date</th>
		      <th>Remarks</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
		<tr>	
		      <th>#</th>
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
	</tfoot>
	</tbody>
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th> Item</th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shrequisionno==1  or empty($obj->action)){ ?>
				<th>Requisition No </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shtradeprice==1  or empty($obj->action)){ ?>
				<th>Trade price </th>
			<?php } ?>
			<?php if($obj->shtax==1  or empty($obj->action)){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th> Total</th>
			<?php } ?>
			<?php if($obj->shorderedon==1  or empty($obj->action)){ ?>
				<th>Order On </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
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
			<?php if($obj->shpurchaseorderid==1 ){ ?>
				<th>Purchaseorder </th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>Currency </th>
			<?php } ?>
			<?php if($obj->shrate==1 ){ ?>
				<th>Kshs. Rate </th>
			<?php } ?>
			<?php if($obj->sheurorate==1 ){ ?>
				<th>Euro Rate </th>
			<?php } ?>
			
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	
	<th>#</th>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shrequisionno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtradeprice==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtax==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shorderedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
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
			<?php if($obj->shpurchaseorderid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shrate==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->sheurorate==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
	</tr>
	</tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
