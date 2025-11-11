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
require_once("../../../modules/inv/departments/Departments_class.php");

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

	$obj->shitemid=1;
	$obj->shrequisionno=1;
	$obj->shdocumentno=1;
	$obj->shorderedon=1;
	$obj->shsupplierid=1;
	$obj->shquantity=1;
	$obj->shcostprice=1;
	$obj->shremarks=1;


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
	if(!empty($obj->shitemid)){
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
	
	if(!empty($obj->shrequisionno)){
		array_push($sColumns, 'requisitionno');
		array_push($aColumns, "proc_purchaseorders.requisitionno");
		$k++;
		}
		
	if(!empty($obj->shdocumentno)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "proc_purchaseorders.documentno");
		$k++;
		}
		
	if(!empty($obj->shorderedon)){
		array_push($sColumns, 'orderedon');
		array_push($aColumns, "proc_purchaseorders.orderedon");
		$k++;
		}
		
	if(!empty($obj->shsupplierid)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=proc_purchaseorders.supplierid ";
		$k++;
		}

	if(!empty($obj->shquantity)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_purchaseorderdetails.quantity) quantity");
		}else{
		array_push($aColumns, "proc_purchaseorderdetails.quantity");
		}
		
		$k++;
		
		array_push($sColumns, 'qtyrec');
		array_push($aColumns, "(select case when sum(proc_inwarddetails.quantity) is null then 0 else sum(proc_inwarddetails.quantity) end from proc_inwarddetails left join proc_inwards on proc_inwarddetails.inwardid=proc_inwards.id where find_in_set(proc_purchaseorders.documentno,proc_inwards.lpono)>0 and proc_inwarddetails.itemid=proc_purchaseorderdetails.itemid) qtyrec");
		
		$k++;
		
		array_push($sColumns, 'balance');
		array_push($aColumns, "(proc_purchaseorderdetails.quantity-(select case when sum(proc_inwarddetails.quantity) is null then 0 else sum(proc_inwarddetails.quantity) end from proc_inwarddetails left join proc_inwards on proc_inwarddetails.inwardid=proc_inwards.id where find_in_set(proc_purchaseorders.documentno,proc_inwards.lpono)>0 and proc_inwarddetails.itemid=proc_purchaseorderdetails.itemid)) balance");
		
		$k++;
		
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$mnt=$k;
		
		}

	if(!empty($obj->shcostprice)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "proc_purchaseorderdetails.costprice");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shtradeprice)){
		array_push($sColumns, 'tradeprice');
		array_push($aColumns, "proc_purchaseorderdetails.tradeprice");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.tradeprice ";
		
		}

	if(!empty($obj->shtax)){
		array_push($sColumns, 'tax');
		array_push($aColumns, "proc_purchaseorderdetails.tax");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shtotal)){
		array_push($sColumns, 'total');
		 if(!empty($rptgroup))
		  array_push($aColumns, "case when sum(proc_purchaseorderdetails.total)>0 then sum(proc_purchaseorderdetails.total) else 0 end total");
		else
		  array_push($aColumns, "case when proc_purchaseorderdetails.total>0 then proc_purchaseorderdetails.total else 0 end total");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
                 $mnt=$k;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "proc_purchaseorders.remarks");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "proc_purchaseorderdetails.memo");
		$k++;
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shcreatedby)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=proc_purchaseorders.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "proc_purchaseorders.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "proc_purchaseorders.ipaddress");
		$k++;
		}

	if(!empty($obj->shpurchaseorderid) ){
		array_push($sColumns, 'purchaseorderid');
		array_push($aColumns, "proc_purchaseorderdetails.purchaseorderid");
		$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
		$k++;
		}

	if(!empty($obj->shcurrencyid)){
		array_push($sColumns, 'currencyid');
		array_push($aColumns, "sys_currencys.name as currencyid");
		$rptjoin.=" left join sys_currencys on sys_currencys.id=proc_purchaseorders.currencyid ";
		$k++;
		}

	if(!empty($obj->shrate) ){
		array_push($sColumns, 'rate');
		array_push($aColumns, "proc_purchaseorders.rate");
		$k++;
		}

	if(!empty($obj->sheurorate) ){
		array_push($sColumns, 'eurorate');
		array_push($aColumns, "proc_purchaseorders.eurorate");
		$k++;
		}

	



$track=1;

$rptwhere=" proc_purchaseorderdetails.itemid>0 and proc_purchaseorders.status!=3 ";

//processing filters
if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.=" and ";
	$rptwhere.=" proc_requisitions.departmentid='$obj->departmentid' ";
	$join=" left join proc_requisitions on find_in_set(proc_requisitions.documentno,proc_purchaseorders.requisitionno)>0 ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join proc_purchaseorderdetails on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
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
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
			        <td>Department</td>
			        <td><select name="departmentid" class="selectbox">
				    <option value="">Select...</option>  
				    <?php
				    $departments = new Departments();
				    $fields="* ";
				    $join=" ";
				    $having="";
				    $groupby="";
				    $orderby="";
				    $where="";
				    $departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				    while($row=mysql_fetch_object($departments->result)){
				      ?>
				      <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->departmentid){echo"selected";}?>><?php echo $row->name; ?></option>
				      <?php
				    }
				    ?>
				    </select>
				 </td>
		         </tr>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grrequisionno' value='1' <?php if(isset($_POST['grrequisionno']) ){echo"checked";}?>>&nbsp;Requisition No</td>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
			<tr>
				<td><input type='checkbox' name='grorderedon' value='1' <?php if(isset($_POST['grorderedon']) ){echo"checked";}?>>&nbsp;Order On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grpurchaseorderid' value='1' <?php if(isset($_POST['grpurchaseorderid']) ){echo"checked";}?>>&nbsp;Purchaseorder</td>
			<tr>
				<td><input type='checkbox' name='grcurrencyid' value='1' <?php if(isset($_POST['grcurrencyid']) ){echo"checked";}?>>&nbsp;Currency</td>
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shrequisionno' value='1' <?php if(isset($_POST['shrequisionno'])){echo"checked";}?>>&nbsp;Requisition No</td>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])){echo"checked";}?>>&nbsp;Supplier</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])){echo"checked";}?>>&nbsp;Cost Price</td>
			<tr>
				<td><input type='checkbox' name='shtradeprice' value='1' <?php if(isset($_POST['shtradeprice'])){echo"checked";}?>>&nbsp;Trade Price</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax'])){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])){echo"checked";}?>>&nbsp;Total</td>
				<td><input type='checkbox' name='shorderedon' value='1' <?php if(isset($_POST['shorderedon'])){echo"checked";}?>>&nbsp;Order On</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ip Address</td>
				<td><input type='checkbox' name='shpurchaseorderid' value='1' <?php if(isset($_POST['shpurchaseorderid']) ){echo"checked";}?>>&nbsp;Purchaseorder</td>
			<tr>
				<td><input type='checkbox' name='shcurrencyid' value='1' <?php if(isset($_POST['shcurrencyid'])){echo"checked";}?>>&nbsp;Currency</td>
				<td><input type='checkbox' name='shrate' value='1' <?php if(isset($_POST['shrate']) ){echo"checked";}?>>&nbsp;Rate</td>
			<tr>
				<td><input type='checkbox' name='sheurorate' value='1' <?php if(isset($_POST['sheurorate']) ){echo"checked";}?>>&nbsp;Euro rate</td>
				
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
			<?php if($obj->shitemid==1){ ?>
				<th> Item</th>
			<?php } ?>
			<?php if($obj->shrequisionno==1){ ?>
				<th>Requisition No </th>
			<?php } ?>
			
			<?php if($obj->shdocumentno==1){ ?>
				<th>LPO No. </th>
			<?php } ?>
			
			<?php if($obj->shorderedon==1){ ?>
				<th>Order On </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shquantity==1){ ?>
				<th>Quantity </th>
				<th>Quantity Received </th>
				<th>Balance</th>
			<?php } ?>
			<?php if($obj->shcostprice==1){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shtradeprice==1){ ?>
				<th>Trade price </th>
			<?php } ?>
			<?php if($obj->shtax==1){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shtotal==1){ ?>
				<th> Total</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip Address </th>
			<?php } ?>
			<?php if($obj->shpurchaseorderid==1 ){ ?>
				<th>Purchaseorder </th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1){ ?>
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
	
	</tr>
	</tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
