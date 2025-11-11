<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/assets/assets/Assets_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/assets/assets/Assets_class.php");
require_once("../../../modules/assets/categorys/Categorys_class.php");
require_once("../../../modules/fn/suppliers/Suppliers_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Assets";
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
	if(!empty($obj->shname)  or empty($obj->action)){
		array_push($sColumns, 'name');
		array_push($aColumns, "assets_assets.name");
	}

	if(!empty($obj->shphoto) ){
		array_push($sColumns, 'photo');
		array_push($aColumns, "assets_assets.photo");
	}

	if(!empty($obj->shdocument)  or empty($obj->action)){
		array_push($sColumns, 'document');
		array_push($aColumns, "assets_assets.document");
	}

	if(!empty($obj->shcategoryid)  or empty($obj->action)){
		array_push($sColumns, 'categoryid');
		array_push($aColumns, "assets_categorys.name as categoryid");
		$rptjoin.=" left join assets_categorys on assets_categorys.id=assets_assets.categoryid ";
	}

	if(!empty($obj->shvalue)  or empty($obj->action)){
		array_push($sColumns, 'value');
		array_push($aColumns, "assets_assets.value");
	}

	if(!empty($obj->shsalvagevalue) ){
		array_push($sColumns, 'salvagevalue');
		array_push($aColumns, "assets_assets.salvagevalue");
	}

	if(!empty($obj->shpurchasedon)  or empty($obj->action)){
		array_push($sColumns, 'purchasedon');
		array_push($aColumns, "assets_assets.purchasedon");
	}

	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "fn_suppliers.name as supplierid");
		$rptjoin.=" left join fn_suppliers on fn_suppliers.id=assets_assets.supplierid ";
	}

	if(!empty($obj->shlpono) ){
		array_push($sColumns, 'lpono');
		array_push($aColumns, "assets_assets.lpono");
	}

	if(!empty($obj->shdeliveryno) ){
		array_push($sColumns, 'deliveryno');
		array_push($aColumns, "assets_assets.deliveryno");
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "assets_assets.remarks");
	}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "assets_assets.memo");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "assets_assets.createdon");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "assets_assets.createdby");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "assets_assets.ipaddress");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.name='$obj->name'";
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->categoryid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.categoryid='$obj->categoryid'";
	$track++;
}

if(!empty($obj->fromvalue)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.value>='$obj->fromvalue'";
	$track++;
}

if(!empty($obj->tovalue)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.value<='$obj->tovalue'";
	$track++;
}

if(!empty($obj->value)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.value='$obj->value'";
	$track++;
}

if(!empty($obj->frompurchasedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.purchasedon>='$obj->frompurchasedon'";
	$track++;
}

if(!empty($obj->topurchasedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.purchasedon<='$obj->topurchasedon'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.supplierid='$obj->supplierid'";
	$track++;
}

if(!empty($obj->lpono)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.lpono='$obj->lpono'";
	$track++;
}

if(!empty($obj->deliveryno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.deliveryno='$obj->deliveryno'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_assets.createdby='$obj->createdby'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grname)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" name ";
	$obj->shname=1;
	$track++;
}

if(!empty($obj->grdocument)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" document ";
	$obj->shdocument=1;
	$track++;
}

if(!empty($obj->grcategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" categoryid ";
	$obj->shcategoryid=1;
	$track++;
}

if(!empty($obj->grpurchasedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" purchasedon ";
	$obj->shpurchasedon=1;
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

if(!empty($obj->grlpono)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" lpono ";
	$obj->shlpono=1;
	$track++;
}

if(!empty($obj->grdeliveryno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deliveryno ";
	$obj->shdeliveryno=1;
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

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#naname").autocomplete({
	source:"../../../modules/server/server/search.php?main=assets&module=assets&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#name").val(ui.item.id);
	}
  });

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

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="assets_assets";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=assets_assets",
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
<form  action="assets.php" method="post" name="assets" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Asset Name</td>
				<td><input type='text' size='20' name='naname' id='naname' value='<?php echo $obj->naname; ?>'>
					<input type="hidden" name='name' id='name' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Invoice No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Asset Category</td>
				<td>
				<select name='categoryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$categorys=new Categorys();
				$where="  ";
				$fields="assets_categorys.id, assets_categorys.name, assets_categorys.timemethod, assets_categorys.noofdepr, assets_categorys.endingdate, assets_categorys.periodlength, assets_categorys.computationmethod, assets_categorys.degressivefactor, assets_categorys.firstentry, assets_categorys.ipaddress, assets_categorys.createdby, assets_categorys.createdon, assets_categorys.lasteditedby, assets_categorys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($categorys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Gross Value</td>
				<td><strong>From:</strong><input type='text' id='fromvalue' size='from20' name='fromvalue' value='<?php echo $obj->fromvalue;?>'/>
								<br/><strong>To:</strong><input type='text' id='tovalue' size='to20' name='tovalue' value='<?php echo $obj->tovalue;?>'></td>
			</tr>
			<tr>
				<td>Purchase Date</td>
				<td><strong>From:</strong><input type='text' id='frompurchasedon' size='12' name='frompurchasedon' readonly class="date_input" value='<?php echo $obj->frompurchasedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='topurchasedon' size='12' name='topurchasedon' readonly class="date_input" value='<?php echo $obj->topurchasedon;?>'/></td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>LPO No</td>
				<td><input type='text' id='lpono' size='20' name='lpono' value='<?php echo $obj->lpono;?>'></td>
			</tr>
			<tr>
				<td>Delivery Note No </td>
				<td><input type='text' id='deliveryno' size='20' name='deliveryno' value='<?php echo $obj->deliveryno;?>'></td>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grname' value='1' <?php if(isset($_POST['grname']) ){echo"checked";}?>>&nbsp;Name</td>
				<td><input type='checkbox' name='grdocument' value='1' <?php if(isset($_POST['grdocument']) ){echo"checked";}?>>&nbsp;Invoice No</td>
			<tr>
				<td><input type='checkbox' name='grcategoryid' value='1' <?php if(isset($_POST['grcategoryid']) ){echo"checked";}?>>&nbsp;Asset Category</td>
				<td><input type='checkbox' name='grpurchasedon' value='1' <?php if(isset($_POST['grpurchasedon']) ){echo"checked";}?>>&nbsp;Purchase Date</td>
			<tr>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='grlpono' value='1' <?php if(isset($_POST['grlpono']) ){echo"checked";}?>>&nbsp;LPO No</td>
			<tr>
				<td><input type='checkbox' name='grdeliveryno' value='1' <?php if(isset($_POST['grdeliveryno']) ){echo"checked";}?>>&nbsp;Delivery Note No </td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
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
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Asset Name</td>
				<td><input type='checkbox' name='shphoto' value='1' <?php if(isset($_POST['shphoto']) ){echo"checked";}?>>&nbsp;Photo</td>
			<tr>
				<td><input type='checkbox' name='shdocument' value='1' <?php if(isset($_POST['shdocument'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Invoice No</td>
				<td><input type='checkbox' name='shcategoryid' value='1' <?php if(isset($_POST['shcategoryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Asset Category</td>
			<tr>
				<td><input type='checkbox' name='shvalue' value='1' <?php if(isset($_POST['shvalue'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Gross Value</td>
				<td><input type='checkbox' name='shsalvagevalue' value='1' <?php if(isset($_POST['shsalvagevalue']) ){echo"checked";}?>>&nbsp;Salvage Value</td>
			<tr>
				<td><input type='checkbox' name='shpurchasedon' value='1' <?php if(isset($_POST['shpurchasedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purchase Date</td>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
			<tr>
				<td><input type='checkbox' name='shlpono' value='1' <?php if(isset($_POST['shlpono']) ){echo"checked";}?>>&nbsp;LPO No</td>
				<td><input type='checkbox' name='shdeliveryno' value='1' <?php if(isset($_POST['shdeliveryno']) ){echo"checked";}?>>&nbsp;Delivery Note No </td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ip Address</td>
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
			<?php if($obj->shname==1  or empty($obj->action)){ ?>
				<th>Asset Name </th>
			<?php } ?>
			<?php if($obj->shphoto==1 ){ ?>
				<th>Photo </th>
			<?php } ?>
			<?php if($obj->shdocument==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcategoryid==1  or empty($obj->action)){ ?>
				<th>Asset Category </th>
			<?php } ?>
			<?php if($obj->shvalue==1  or empty($obj->action)){ ?>
				<th>Gross Value </th>
			<?php } ?>
			<?php if($obj->shsalvagevalue==1 ){ ?>
				<th>Salvage Value </th>
			<?php } ?>
			<?php if($obj->shpurchasedon==1  or empty($obj->action)){ ?>
				<th>Purchase Date </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shlpono==1 ){ ?>
				<th>LPO No </th>
			<?php } ?>
			<?php if($obj->shdeliveryno==1 ){ ?>
				<th>Delivery Note No </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
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
