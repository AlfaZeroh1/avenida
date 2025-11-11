<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/returnnotes/Returnnotes_class.php");
require_once("../../../modules/inv/returnnotedetails/Returnnotedetails_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/purchasemodes/Purchasemodes_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Returnnotes";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8813";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

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
if(!empty($obj->grsupplierid) or !empty($obj->grdocumentno) or !empty($obj->grpurchaseno) or !empty($obj->grpurchasemodeid) or !empty($obj->gritemid) or !empty($obj->grreturnedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shsupplierid='';
	$obj->shdocumentno='';
	$obj->shpurchaseno='';
	$obj->shgrpurchasemodeid='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shreturnedon='';
	$obj->shmemo='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shcostprice='';
	$obj->shtax='';
	$obj->shdiscount='';
	$obj->shtotal='';
}


	$obj->sh=1;
	$obj->grquantity=1;
	$obj->gritemid=1;
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
	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=inv_returnnotes.supplierid ";
		$k++;
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "inv_returnnotes.documentno");
		$k++;
		}

	if(!empty($obj->shpurchaseno)  or empty($obj->action)){
		array_push($sColumns, 'purchaseno');
		array_push($aColumns, "inv_returnnotes.purchaseno");
		$k++;
		}

	if(!empty($obj->shgrpurchasemodeid)  or empty($obj->action)){
		array_push($sColumns, 'grpurchasemodeid');
		array_push($aColumns, "inv_returnnotes.purchasemodeid");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_returnnotedetails.itemid");
		$k++;
		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
// 		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.itemid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_returnnotedetails.quantity");
		$k++;
		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
// 		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.quantity ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
		}

	if(!empty($obj->shreturnedon)  or empty($obj->action)){
		array_push($sColumns, 'returnedon');
		array_push($aColumns, "inv_returnnotes.returnedon");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "inv_returnnotes.memo");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "inv_returnnotes.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "inv_returnnotes.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "inv_returnnotes.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "inv_returnnotes.ipaddress");
		$k++;
		}

	if(!empty($obj->shcostprice)  or empty($obj->action)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "inv_returnnotedetails.costprice");
		$k++;
		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
// 		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.costprice ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
		}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "inv_returnnotedetails.tax");
		$k++;
		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
// 		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.tax ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
		}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "inv_returnnotedetails.discount");
		$k++;
		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
// 		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.discount ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		array_push($aColumns, "inv_returnnotedetails.total");
		$k++;
		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
// 		$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.total ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
		}



$track=0;

//processing filters
if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.supplierid='$obj->supplierid'";
		
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->purchaseno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.purchaseno='$obj->purchaseno'";
	$track++;
}

if(!empty($obj->purchasemodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.purchasemodeid='$obj->purchasemodeid'";
		
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->quantity' ";
	$join=" left join inv_returnnotedetails on inv_returnnotes.id=inv_returnnotedetails.returnnoteid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->fromreturnedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.returnedon>='$obj->fromreturnedon'";
	$track++;
}

if(!empty($obj->toreturnedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.returnedon<='$obj->toreturnedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_returnnotes.createdon<='$obj->tocreatedon'";
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
 <?php $_SESSION['sTable']="inv_returnnotes";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_returnnotes",
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
<form  action="returnnotes.php" method="post" name="returnnotes" >
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
				<td>Purchase Invoice/Receipt No</td>
				<td><input type='text' id='purchaseno' size='20' name='purchaseno' value='<?php echo $obj->purchaseno;?>'></td>
			</tr>
			<tr>
				<td>Mode Of Payment	</td>
				<td>
				<select name='purchasemodeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$purchasemodes=new Purchasemodes();
				$where="  ";
				$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($purchasemodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->purchasemodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
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
				<td>Created  by</td>
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
				<td>Created on</td>
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
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grpurchaseno' value='1' <?php if(isset($_POST['grpurchaseno']) ){echo"checked";}?>>&nbsp;Purchase Invoice/Receipt No</td>
				<td><input type='checkbox' name='grpurchasemodeid' value='1' <?php if(isset($_POST['grpurchasemodeid']) ){echo"checked";}?>>&nbsp;Mode Of Payment	</td>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='grreturnedon' value='1' <?php if(isset($_POST['grreturnedon']) ){echo"checked";}?>>&nbsp;Returned On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created  by</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shpurchaseno' value='1' <?php if(isset($_POST['shpurchaseno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purchase Invoice/Receipt No</td>
				<td><input type='checkbox' name='shgrpurchasemodeid' value='1' <?php if(isset($_POST['shgrpurchasemodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Mode Of Payment	</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shreturnedon' value='1' <?php if(isset($_POST['shreturnedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Returned On</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created  by</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Cost Price</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax']) ){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
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
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shpurchaseno==1  or empty($obj->action)){ ?>
				<th>Purchase Invoice/Receipt No </th>
			<?php } ?>
			<?php if($obj->shgrpurchasemodeid==1  or empty($obj->action)){ ?>
				<th>Purchase Mode </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shreturnedon==1  or empty($obj->action)){ ?>
				<th>Returned On </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
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
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th> Total</th>
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
