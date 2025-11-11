<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/proc/deliverynotes/Deliverynotes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/proc/deliverynotes/Deliverynotes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Deliverynotes";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8773";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromdeliveredon=date('Y-m-d');
	$obj->todeliveredon=date('Y-m-d');
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
if(!empty($obj->grdocumentno) or !empty($obj->grlpono) or !empty($obj->grsupplierid) or !empty($obj->grdeliveredon) or !empty($obj->gritemid) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) or !empty($obj->grdeliverynoteid) ){
	$obj->shdocumentno='';
	$obj->shlpono='';
	$obj->shsupplierid='';
	$obj->shdeliveredon='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shcostprice='';
	$obj->shtotal='';
	$obj->shremarks='';
	$obj->shmemo='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
	$obj->shdeliverynoteid='';
	$obj->shfile='';
}


	$obj->shquantity=1;
	$obj->shtotal=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->grlpono)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" lpono ";
	$obj->shlpono=1;
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

if(!empty($obj->grdeliveredon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deliveredon ";
	$obj->shdeliveredon=1;
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

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
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

if(!empty($obj->grdeliverynoteid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deliverynoteid ";
	$obj->shdeliverynoteid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "proc_deliverynotes.documentno");
		$k++;
		}

	if(!empty($obj->shlpono)  or empty($obj->action)){
		array_push($sColumns, 'lpono');
		array_push($aColumns, "proc_deliverynotes.lpono");
		$k++;
		}

	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=proc_deliverynotes.supplierid ";
		$k++;
		}

	if(!empty($obj->shdeliveredon)  or empty($obj->action)){
		array_push($sColumns, 'deliveredon');
		array_push($aColumns, "proc_deliverynotes.deliveredon");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=proc_deliverynotedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_deliverynotes.quantity) quantity");
		}else{
		array_push($aColumns, "proc_deliverynotedetails.quantity");
		}

		$k++;
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.quantity ";
		
		$mnt=$k;
		}

	if(!empty($obj->shcostprice) ){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "proc_deliverynotedetails.costprice");
		$k++;
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.costprice ";
		
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_deliverynotedetails.total) total");
		}else{
		array_push($aColumns, "proc_deliverynotedetails.total");
		}

		$k++;
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
		
		$join="left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.total ";
		
		$mnt=$k;
		
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "proc_deliverynotes.remarks");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "proc_deliverynotedetails.memo");
		$k++;
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.memo ";
		
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "proc_deliverynotes.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=proc_deliverynotes.createdby ";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "proc_deliverynotes.ipaddress");
		$k++;
		}

	if(!empty($obj->shdeliverynoteid) ){
		array_push($sColumns, 'deliverynoteid');
		array_push($aColumns, "proc_deliverynotedetails.deliverynoteid");
		$k++;
		}

	if(!empty($obj->shfile) ){
		array_push($sColumns, 'file');
		array_push($aColumns, "proc_deliverynotes.file");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->lpono)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.lpono='$obj->lpono'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.supplierid='$obj->supplierid'";
		$join=" left join proc_suppliers on proc_deliverynotes.id=proc_suppliers.deliverynoteid ";
		
	$track++;
}

if(!empty($obj->fromdeliveredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.deliveredon>='$obj->fromdeliveredon'";
	$track++;
}

if(!empty($obj->todeliveredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.deliveredon<='$obj->todeliveredon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=proc_deliverynotedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}


if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->quantity' ";
	$join=" left join proc_deliverynotedetails on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join proc_deliverynotedetails on proc_deliverynotes.id.id=proc_deliverynotedetails.quantity ";
	
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->deliverynoteid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_deliverynotes.deliverynoteid='$obj->deliverynoteid'";
		$join=" left join proc_deliverynotes on proc_deliverynotes.id=proc_deliverynotes.deliverynoteid ";
		
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

  $("#deliverynotename").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=deliverynotes&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#deliverynoteid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="proc_deliverynotes";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=proc_deliverynotes",
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
<form  action="deliverynotes.php" method="post" name="deliverynotes" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Delivery Note</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>LPO Number	</td>
				<td><input type='text' id='lpono' size='20' name='lpono' value='<?php echo $obj->lpono;?>'></td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Delivery Date</td>
				<td><strong>From:</strong><input type='text' id='fromdeliveredon' size='12' name='fromdeliveredon' readonly class="date_input" value='<?php echo $obj->fromdeliveredon;?>'/>
							<br/><strong>To:</strong><input type='text' id='todeliveredon' size='12' name='todeliveredon' readonly class="date_input" value='<?php echo $obj->todeliveredon;?>'/></td>
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
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='20' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from proc_deliverynotes) ";
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
				<td>Delivery notes</td>
				<td><input type='text' size='20' name='deliverynotename' id='deliverynotename' value='<?php echo $obj->deliverynotename; ?>'>
					<input type="hidden" name='deliverynoteid' id='deliverynoteid' value='<?php echo $obj->field; ?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Delivery Note</td>
				<td><input type='checkbox' name='grlpono' value='1' <?php if(isset($_POST['grlpono']) ){echo"checked";}?>>&nbsp;LPO Number	</td>
			<tr>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='grdeliveredon' value='1' <?php if(isset($_POST['grdeliveredon']) ){echo"checked";}?>>&nbsp;Delivery Date</td>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grdeliverynoteid' value='1' <?php if(isset($_POST['grdeliverynoteid']) ){echo"checked";}?>>&nbsp;Delivery notes</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Delivery Note</td>
				<td><input type='checkbox' name='shlpono' value='1' <?php if(isset($_POST['shlpono'])  or empty($obj->action)){echo"checked";}?>>&nbsp;LPO Number	</td>
			<tr>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='shdeliveredon' value='1' <?php if(isset($_POST['shdeliveredon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Delivery Date</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice']) ){echo"checked";}?>>&nbsp;Rate</td>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shdeliverynoteid' value='1' <?php if(isset($_POST['shdeliverynoteid']) ){echo"checked";}?>>&nbsp;Delivery notes</td>
			<tr>
				<td><input type='checkbox' name='shfile' value='1' <?php if(isset($_POST['shfile']) ){echo"checked";}?>>&nbsp;File</td>
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
				<th>Delivery Note </th>
			<?php } ?>
			<?php if($obj->shlpono==1  or empty($obj->action)){ ?>
				<th>LPO Number </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shdeliveredon==1  or empty($obj->action)){ ?>
				<th>Delivery Date </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shcostprice==1 ){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th> Memo</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> Created On</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created by </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shdeliverynoteid==1 ){ ?>
				<th>Delivery Note </th>
			<?php } ?>
			<?php if($obj->shfile==1 ){ ?>
				<th>Browse File </th>
			<?php } ?>	
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	
	<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shlpono==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdeliveredon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcostprice==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdeliverynoteid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shfile==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
	</tr>
	</tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
