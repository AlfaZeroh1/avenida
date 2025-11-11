<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/purchases/Purchases_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/purchasemodes/Purchasemodes_class.php");
require_once("../../../modules/inv/stores/Stores_class.php");
// require_once("../../../modules/con/projects/Projects_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Purchases";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8812";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromboughton=date('Y-m-d');
	$obj->toboughton=date('Y-m-d');
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
if(!empty($obj->gritemid) or !empty($obj->grdocumentno) or !empty($obj->grlpono) or !empty($obj->grsupplierid) or !empty($obj->grbatchno) or !empty($obj->grboughton) or !empty($obj->grcreatedby) or !empty($obj->createdon) or !empty($obj->grstoreid)  ){
	$obj->shitemid='';
	$obj->shdocumentno='';
	$obj->shlpono='';
	$obj->shsupplierid='';
	$obj->shbatchno='';
	$obj->shremarks='';
	$obj->shquantity='';
	$obj->shcostprice='';
	$obj->shdiscount='';
	$obj->shtax='';
	$obj->shbonus='';
	$obj->shtotal='';
	$obj->shpurchasemodeid='';
	$obj->shboughton='';
	$obj->shmemo='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shstoreid='';
	
}


	
	$obj->shquantity=1;
	$obj->shitemid=1;


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

if(!empty($obj->grbatchno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" batchno ";
	$obj->shbatchno=1;
	$track++;
}

if(!empty($obj->grboughton)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" boughton ";
	$obj->shboughton=1;
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

if(!empty($obj->grstoreid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" storeid ";
	$obj->shstoreid=1;
	$track++;
}


//processing columns to show
	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=inv_purchasedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "inv_purchases.documentno");
		$k++;
		}

	if(!empty($obj->shlpono) ){
		array_push($sColumns, 'lpono');
		array_push($aColumns, "inv_purchases.lpono");
		$k++;
		}

	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=inv_purchases.supplierid ";
		$k++;
		}

	if(!empty($obj->shbatchno) ){
		array_push($sColumns, 'batchno');
		array_push($aColumns, "inv_purchases.batchno");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "inv_purchases.remarks");
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_purchases.quantity");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shcostprice)  or empty($obj->action)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "inv_purchases.costprice");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shdiscount)  or empty($obj->action)){
		array_push($sColumns, 'discount');
		array_push($aColumns, "inv_purchases.discount");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "inv_purchases.tax");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shbonus) ){
		array_push($sColumns, 'bonus');
		array_push($aColumns, "inv_purchases.bonus");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
		}
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		array_push($aColumns, "inv_purchases.total");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shpurchasemodeid) ){
		array_push($sColumns, 'purchasemodeid');
		array_push($aColumns, "sys_purchasemodes.name as purchasemodeid");
		$rptjoin.=" left join sys_purchasemodes on sys_purchasemodes.id=inv_purchases.purchasemodeid ";
		$k++;
		}

	if(!empty($obj->shboughton)  or empty($obj->action)){
		array_push($sColumns, 'boughton');
		array_push($aColumns, "inv_purchases.boughton");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "inv_purchases.memo");
		$k++;
		$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=inv_purchases.createdby ";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "inv_purchases.ipaddress");
		$k++;
		}

	if(!empty($obj->shstoreid)  or empty($obj->action)){
		array_push($sColumns, 'storeid');
		array_push($aColumns, "inv_stores.name as storeid");
		$rptjoin.=" left join inv_stores on inv_stores.id=inv_purchases.storeid ";
		$k++;
		}




$track=0;

//processing filters
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join inv_purchasedetails on inv_purchases.id=inv_purchasedetails.purchaseid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=inv_purchasedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->lpono)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.lpono='$obj->lpono'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.supplierid='$obj->supplierid'";
		
	$track++;
}

if(!empty($obj->batchno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.batchno='$obj->batchno'";
	$track++;
}

if(!empty($obj->purchasemodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.purchasemodeid='$obj->purchasemodeid'";
		
	$track++;
}

if(!empty($obj->fromboughton)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.boughton>='$obj->fromboughton'";
	$track++;
}

if(!empty($obj->toboughton)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.boughton<='$obj->toboughton'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->storeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_purchases.storeid='$obj->storeid'";
		
	$track++;
}



//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
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

  $("#projectname").autocomplete({
	source:"../../../modules/server/server/search.php?main=con&module=projects&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="inv_purchases";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hos_patientappointments",
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
<form  action="purchases.php" method="post" name="purchases" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Item</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Document No.</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>L.P.O No</td>
				<td><input type='text' id='lpono' size='20' name='lpono' value='<?php echo $obj->lpono;?>'></td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Batch No.</td>
				<td><input type='text' id='batchno' size='20' name='batchno' value='<?php echo $obj->batchno;?>'></td>
			</tr>
			<tr>
				<td>Mode Of Payment</td>
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
				<td>Purchase Date</td>
				<td><strong>From:</strong><input type='text' id='fromboughton' size='12' name='fromboughton' readonly class="date_input" value='<?php echo $obj->fromboughton;?>'/>
							<br/><strong>To:</strong><input type='text' id='toboughton' size='12' name='toboughton' readonly class="date_input" value='<?php echo $obj->toboughton;?>'/></td>
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
			<tr>
				<td>Store</td>
				<td>
				<select name='storeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$stores=new Stores();
				$where="  ";
				$fields="inv_stores.id, inv_stores.name, inv_stores.remarks, inv_stores.ipaddress, inv_stores.createdby, inv_stores.createdon, inv_stores.lasteditedby, inv_stores.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$stores->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($stores->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->storeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No.</td>
			<tr>
				<td><input type='checkbox' name='grlpono' value='1' <?php if(isset($_POST['grlpono']) ){echo"checked";}?>>&nbsp;L.P.O No</td>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
			<tr>
				<td><input type='checkbox' name='grbatchno' value='1' <?php if(isset($_POST['grbatchno']) ){echo"checked";}?>>&nbsp;Batch No.</td>
				<td><input type='checkbox' name='grboughton' value='1' <?php if(isset($_POST['grboughton']) ){echo"checked";}?>>&nbsp;Purchase Date</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='createdon' value='1' <?php if(isset($_POST['createdon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grstoreid' value='1' <?php if(isset($_POST['grstoreid']) ){echo"checked";}?>>&nbsp;Store</td>
				
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No.</td>
			<tr>
				<td><input type='checkbox' name='shlpono' value='1' <?php if(isset($_POST['shlpono']) ){echo"checked";}?>>&nbsp;L.P.O No</td>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
			<tr>
				<td><input type='checkbox' name='shbatchno' value='1' <?php if(isset($_POST['shbatchno']) ){echo"checked";}?>>&nbsp;Batch No.</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Cost Price</td>
			<tr>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Discount</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax']) ){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shbonus' value='1' <?php if(isset($_POST['shbonus']) ){echo"checked";}?>>&nbsp;Bonus</td>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
			<tr>
				<td><input type='checkbox' name='shpurchasemodeid' value='1' <?php if(isset($_POST['shpurchasemodeid']) ){echo"checked";}?>>&nbsp;Mode Of Payment</td>
				<td><input type='checkbox' name='shboughton' value='1' <?php if(isset($_POST['shboughton'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purchase Date</td>
			<tr>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
			<tr>
				<td><input type='checkbox' name='shstoreid' value='1' <?php if(isset($_POST['shstoreid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Store</td>
				
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item Name </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shlpono==1 or empty($obj->action)){ ?>
				<th>L.P.O No </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shbatchno==1 or empty($obj->action)){ ?>
				<th>Batch No. </th>
			<?php } ?>
			<?php if($obj->shremarks==1 or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>Costprice </th>
			<?php } ?>
			<?php if($obj->shdiscount==1  or empty($obj->action)){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shtax==1 or empty($obj->action)){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shbonus==1 or empty($obj->action)){ ?>
				<th> Bonus</th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shpurchasemodeid==1 or empty($obj->action)){ ?>
				<th>Mode Of Payment </th>
			<?php } ?>
			<?php if($obj->shboughton==1  or empty($obj->action)){ ?>
				<th>Purchase Date </th>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action)){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 or empty($obj->action)){ ?>
				<th>Ip Address </th>
			<?php } ?>
			<?php if($obj->shstoreid==1  or empty($obj->action)){ ?>
				<th>Store </th>
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
